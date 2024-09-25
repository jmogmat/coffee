<?php

namespace App\Controller;

use App\Service\User\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AccountController extends AbstractController
{

    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index.html.twig', []);
    }

    public function __construct(private readonly UserService $userService)
    {
    }

    #[Route('/verify-account/{token}', name: 'verify_account')]
    public function verify(string $token): RedirectResponse
    {

        $user = $this->userService->findToken($token);

        if (!$user || !$this->userService->isTokenValid($user)) {
            $this->addFlash('error', 'El token es inválido o ha expirado.');
            return $this->redirectToRoute('app_register_and_login');
        }

        $this->userService->activateUser($user);

        $this->addFlash('success', 'Cuenta verificada correctamente.');
        return $this->redirectToRoute('app_index');
    }



}