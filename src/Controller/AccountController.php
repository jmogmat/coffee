<?php

namespace App\Controller;

use App\Service\User\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{

    public function __construct(private readonly UserService $userService)
    {
    }

    #[Route('/verify-account/{token}', name: 'verify-account')]
    public function verify(string $token): RedirectResponse
    {

        $user = $this->userService->findToken($token);

        if (!$user || !$this->userService->isTokenValid($user)) {
            $this->addFlash('error', 'El token es inválido o ha expirado.');
            return $this->redirectToRoute('app_register');
        }

        // Actualizar el estado del usuario
        $this->userService->activateUser($user);

        $this->addFlash('success', 'Cuenta verificada correctamente.');
        return $this->redirectToRoute('index.html.twig');
    }



}