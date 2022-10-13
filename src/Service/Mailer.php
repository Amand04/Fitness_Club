<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Mailer
{
    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmailActivateAccount($email, $token)
    {

        //instancie et paramètre les données du mail
        $email = (new TemplatedEmail())

            ->from('amandinejeanjules@free.fr')
            ->to(new Address($email))
            ->cc('amandinejeanjules@free.fr')
            ->subject('Bienvenue parmis nous!')
            ->text('Cher Client,<br>Félicitations, vous êtes desormais inscrit sur notre application FitnessClub!')
            ->htmlTemplate('mailer/user/firstConnection.html.twig')
            ->context([
                'token' => $token,
            ]);

        //envoi de l'email
        $this->mailer->send($email);
    }

    public function sendEmailPassword($email, $token)
    {

        //instancie et paramètre les données du mail
        $email = (new TemplatedEmail())

            ->from('amandinejeanjules@free.fr')
            ->to(new Address($email))
            ->cc('amandinejeanjules@free.fr')
            ->subject('Bienvenue parmis nous!')
            ->text('Cher Client,<br>Pour initialiser votre mot de passe suivez ce lien:!')
            ->htmlTemplate('mailer/user/resetPassword.html.twig')
            ->context([
                'token' => $token,
            ]);

        //envoi de l'email
        $this->mailer->send($email);
    }
}
