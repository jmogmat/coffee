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
        private readonly Environment $twig,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->urlGenerator = $urlGenerator;
    }



    public function sendTokenEmail(string $toEmail, string $token): void
    {
        $mailTitle = 'Verificación de cuenta';
        $url = $this->generateUrl('verify_account', ['token' => $token]);

        $email = (new TemplatedEmail())
            ->from(new Address('matias.xilon@gmail.com', 'Matias Xilon'))
            ->to(new Address($toEmail))
            ->html(
                sprintf(
                    'Gracias por registrarte. Por favor, haz clic en el siguiente enlace para verificar tu cuenta: <a href="%s">%s</a>',
                    $url,
                    $url
                )
            );
            $this->mailer->send($email);

    }

    public function generateUrl(string $route, array $parameters = []): string
    {
        return $this->urlGenerator->generate($route, $parameters, UrlGeneratorInterface::ABSOLUTE_URL);
    }


}
