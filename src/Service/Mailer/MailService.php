<?php

namespace App\Service\Mailer;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class MailService
{
    private MailerInterface $mailer;
    private Environment $twig;

    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    /**
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function sendTokenEmail(string $email, string $token): void
    {
        $htmlContent = $this->twig->render('emails/verification.html.twig', [
            'token' => $token
        ]);
        $emailMessage = (new Email())
            ->from('matias.xilon@gmail.com')
            ->to($email)
            ->subject('Verificación de cuenta')
            ->html($htmlContent);
        $this->mailer->send($emailMessage);
        try {
            $this->mailer->send($emailMessage);
        } catch (TransportExceptionInterface $e) {
            throw new RuntimeException('No se pudo enviar el correo electrónico: ' . $e->getMessage());
        }
    }
}