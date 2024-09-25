<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\LoginFormType;
use App\Service\Mailer\MailService;
use App\Service\User\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use DateTime;



class UserController extends AbstractController
{
    #[Route('/register-login', name: 'app_register_and_login')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        UserService $userService,
        MailService $mailService,
        AuthenticationUtils $authenticationUtils): Response
    {
        // Formulario de Login
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $loginForm = $this->createForm(LoginFormType::class);

        // Formulario de Registro
        $registrationForm = $this->createForm(RegistrationFormType::class);
        $registrationForm->handleRequest($request);

        if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {
            $data = $registrationForm->getData();
            $email = $data['email'];
            $password = $data['password'];

            $existingUser = $userService->existsUserEmail($email); //Comprobamos si el email existe en la bd

            if ($existingUser !== null) { //Si es un User entonces...
                if ($existingUser->getRequestedToken() !== null && $existingUser->getRequestedToken() > new DateTime()) {
                    $this->addFlash('error', 'Ya existe un registro con este email. Verifica tu correo para validar tu cuenta.');
                } else {
                    $existingUser->updateToken();
                    $existingUser->setRequestedToken(new DateTime('+24 hours'));
                    $userService->saveUser($existingUser);
                    $mailService->sendTokenEmail($email, $existingUser->getToken());
                    $this->addFlash('success', 'Se ha reenviado un nuevo email. Verifica tu correo para validar tu cuenta.');
                }
            } else {
                $newUser = new User($email);
                $newUser->setPassword($passwordHasher->hashPassword($newUser, $password));
                $newUser->setRequestedToken(new DateTime('+24 hours'));
                $userService->saveUser($newUser);
                try {
                    $mailService->sendTokenEmail($email, $newUser->getToken());
                } catch (Exception $e) {
                    $this->addFlash('error', 'No se pudo enviar el correo: ' . $e->getMessage());
                    return $this->redirectToRoute('app_register');
                }
                $this->addFlash('success', 'Registro exitoso. Verifica tu correo para validar tu cuenta.');
            }
        }

        return $this->render('user/register_and_login.html.twig', [
            'registrationForm' => $registrationForm->createView(),
            'form' => $loginForm->createView(),
            'error' => $error,
            'last_username' => $lastUsername
        ]);
        }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
    }


}
