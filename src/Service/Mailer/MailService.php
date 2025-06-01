<?php

namespace App\Service\Mailer;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;
use RuntimeException;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

class MailService
{

    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly UrlGeneratorInterface $urlGenerator
    ) {

    }


    public function sendTokenEmail(string $toEmail, string $token): void
    {
        $mailTitle = 'Verificación de cuenta';
        $url = $this->generateUrl('verify_account', ['token' => $token]);
        $email = (new Email())
                ->from(new Address('no-reply@demomailtrap.com', 'Matias AppCoffee'))
                ->to(new Address($toEmail))
                ->subject($mailTitle)
                ->html(
                    sprintf(
                        'Gracias por registrarte. Por favor, haz click en el siguiente enlace para verificar tu cuenta: <a href="%s">%s</a>',
                        $url,
                        $url
                    )
                );
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            error_log('Error enviando mail: ' . $e->getMessage());
            throw $e;
        }

    }


    public function generateUrl(string $route, array $parameters = []): string
    {
        return $this->urlGenerator->generate($route, $parameters, UrlGeneratorInterface::ABSOLUTE_URL);
    }


}
