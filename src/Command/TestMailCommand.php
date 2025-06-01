<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AsCommand(name: 'app:test-email')]
class TestMailCommand extends Command
{
    public function __construct(private MailerInterface $mailer)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = (new Email())
            ->from('matias.xilon@gmail.com')
            ->to('jmog.matias@gmail.com')
            ->subject('Test desde Symfony')
            ->text('Este es un email de prueba con Mailtrap');

        $this->mailer->send($email);

        $output->writeln('Email enviado.');
        return Command::SUCCESS;
    }
}