<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\LoginFormType;
use App\Service\Mailer\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Service\UserService;
use DateTime;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;


class UserController extends AbstractController
{
    /**
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     * @throws RuntimeError
     * @throws LoaderError
     */
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, UserService $userService, MailService $mailService): Response
    {
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $email = $data['email'];
            $password = $data['password'];
            $existingUser = $userService->existsUserEmail($email);

            if ($existingUser !== null) {
                if ($existingUser->getRequestedToken() !== null && $existingUser->getRequestedToken() > new DateTime()) {
                    $this->addFlash('error', 'Ya existe un registro con este email. Verifica tu correo para validar tu cuenta.');
                    return $this->redirectToRoute('app_register');
                } else {
                    $existingUser->updateToken();
                    $existingUser->setRequestedToken(new DateTime('+10 minutes'));
                    $userService->saveUser($existingUser);
                    $mailService->sendTokenEmail($email, $existingUser->getToken());
                    $this->addFlash('success', 'Se ha reenviado un nuevo token de validación a tu correo.');
                    return $this->redirectToRoute('app_login');
                }
            } else {
                $newUser = new User($email);
                $newUser->setPassword(
                    $passwordHasher->hashPassword($newUser, $password)
                );
                $newUser->setRequestedToken(new \DateTime('+10 minutes'));
                $userService->saveUser($newUser);
                $mailService->sendTokenEmail($email, $newUser->getToken());

                $this->addFlash('success', 'Registro exitoso. Verifica tu correo para validar tu cuenta.');
                return $this->redirectToRoute('app_login');
            }
        }

        return $this->render('user/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('user/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
            'form' => $this->createForm(LoginFormType::class)->createView(),
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
    }
}
