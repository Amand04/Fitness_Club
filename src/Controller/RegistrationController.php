<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;


class RegistrationController extends AbstractController
{
    //private EmailVerifier $emailVerifier;

    //public function __construct(EmailVerifier $emailVerifier)
    //{
    //    $this->emailVerifier = $emailVerifier;
    //}

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            //generate a signed url and email it to the user
            //$this->emailVerifier->sendEmailConfirmation(
            //    'app_verify_email',
            //    $user,
            //    $email = (new TemplatedEmail())
            //        ->from('amandinejeanjules@free.fr')
            //        ->to($user->getEmail())
            //        ->subject('Please Confirm your Email')
            //        ->htmlTemplate('registration/confirmation_email.html.twig')
            //);
            // do anything else you need here, like send an email
            //$mailer->send($email);

            // On envoie un mail
            // $mail->send(
            //   'no-reply@monsite.net',
            // $user->getEmail(),
            //'Activation de votre compte sur le site e-commerce',
            //'register',
            //compact('user')
            //);

            $email = (new Email())

                ->from('amandinejeanjules@free.fr')
                ->to($user->getEmail())
                ->cc('amandinejeanjules@free.fr')
                //->bcc('amandinejeanjules@free.fr')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject('Bienvenue parmis nous!')
                ->text('Cher Client,<br>Félicitations, vous êtes desormais inscrit sur notre application FitnessClub!')
                ->html('<h2>Félicitations, vous êtes desormais enregistré dans notre application et faites désormais parti de nos clients!</h2><br>
        <h3>Les identitfiants nécessaires à votre connexion vous seront communiqués très prochainement par télephone par votre administrateur. </h3>
        <h3>Celui-ci fera également un point avec vous.</h3>
        <h3>L\'équipe Fitness Club</h3>');

            $mailer->send($email);

            return $this->render('/mailer/user/index.html.twig');


            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
