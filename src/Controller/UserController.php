<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\LoginFormType;
use App\Service\Mailer\MailService;
use App\Service\User\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use DateTime;
class UserController extends AbstractController
{


    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly UserService $userService,
        private readonly MailService $mailService,
        private readonly AuthenticationUtils $authenticationUtils)
    {
    }

    #[Route('/login/', name: 'app_login')]
    public function login(Request $request): Response
    {

        $error = $this->authenticationUtils->getLastAuthenticationError();
        $lastUsername = $this->authenticationUtils->getLastUsername();
        $loginForm = $this->createForm(LoginFormType::class);
        return $this->render('user/login.html.twig', [
            'form' => $loginForm->createView(),
            'error' => $error,
            'last_username' => $lastUsername
        ]);
        }

    #[Route('/register/', name: 'app_register')]
    public function register(Request $request): Response {
        $registrationForm = $this->createForm(RegistrationFormType::class);
        $registrationForm->handleRequest($request);

        if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {
            $data = $registrationForm->getData();
            $email = $data['email'];
            $password = $data['password'];

            $existingUser = $this->userService->existsUserEmail($email);

            if ($existingUser !== null) {
                if ($existingUser->getRequestedToken() !== null && $existingUser->getRequestedToken() > new \DateTime()) {
                    $this->addFlash('error', 'Ya existe un registro con este email. Verifica tu correo para validar tu cuenta.');
                } else {
                    try {
                        $existingUser->updateToken();
                        $existingUser->setRequestedToken(new \DateTime('+24 hours'));
                        $this->userService->saveUser($existingUser);
                        $this->mailService->sendTokenEmail($email, $existingUser->getToken());
                        $this->addFlash('success', 'Se ha reenviado un nuevo email. Verifica tu correo para validar tu cuenta.');
                    } catch (\Exception $e) {
                        $this->logger->error('Error actualizando usuario: ' . $e->getMessage());
                        $this->addFlash('error', 'Ocurrió un error durante el proceso. Inténtalo de nuevo.');
                    }
                }
            } else {
                try {
                    $newUser = new User($email);
                    $newUser->setPassword($this->passwordHasher->hashPassword($newUser, $password));
                    $newUser->setRequestedToken(new \DateTime('+24 hours'));
                    $this->userService->saveUser($newUser);
                    $this->mailService->sendTokenEmail($email, $newUser->getToken());
                    $this->addFlash('success', 'Registro exitoso. Verifica tu correo para validar tu cuenta.');
                } catch (\Exception $e) {
                    $this->logger->error('Error creando usuario: ' . $e->getMessage());
                    $this->addFlash('error', 'Ocurrió un error durante el registro. Inténtalo de nuevo.');
                }
            }

            return $this->redirectToRoute('app_register');
        }

        return $this->render('user/register.html.twig', [
            'registrationForm' => $registrationForm->createView(),
        ]);
    }



    #[Route('/test-email/', name: 'test_email')]
    public function testEmail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('no-reply@demomailtrap.com')
            ->to('jmog.matias@gmail.com') // cualquier correo
            ->subject('Prueba de correo')
            ->text('Esto es una prueba');

        try {
            $mailer->send($email);
            return new Response('Correo enviado correctamente');
        } catch (\Exception $e) {
            return new Response('Error al enviar: ' . $e->getMessage());
        }
    }




    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
    }
}
