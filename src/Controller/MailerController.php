<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class MailerController extends AbstractController
{
    /**
     * @Route("/email/creationStructure", name="app_emailCreationStructure")
     */
    // public function sendEmail(MailerInterface $mailer, User $user, ManagerRegistry $doctrine): Response
    //{
    //  $user = $this->$doctrine->getRepository(Structures::class)->findAll();

    //$email = (new Email())
    //  ->from(new Address('expediteur@demo.test', 'Fitness club'))
    //->to($user->getEmail())
    //->cc('cc@example.com')
    //->bcc('bcc@example.com')
    //->replyTo('fabien@example.com')
    //->priority(Email::PRIORITY_HIGH)
    //->subject('Votre Structure vient d\'être crée!')
    //->text('Chers Clients,<br>Félicitations, votre Structure vient d\'être enregistrée et fait désormais partie de nos clients!')
    //->html('');

    // $mailer->send($email);

    // ...

    //return $this->render('/mailer/structure/index.html.twig');
}
