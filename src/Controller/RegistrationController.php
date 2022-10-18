<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\ResetFormType;
use App\Repository\UserRepository;
use App\Security\UserAuthenticator;
use App\Service\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * Require ROLE_ADMIN for all the actions of this controller
 */
class RegistrationController extends AbstractController
{
    /**
     * @var Mailer
     */
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
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
            // On génère un token et on l'enregistre
            $user->setActivationToken(md5(uniqid()));

            $entityManager->persist($user);
            $entityManager->flush();
            $this->mailer->sendEmailActivateAccount($user->getEmail(), $user->getActivationToken(), $user->getLastname());

            //renvoi un template
            return $this->render('mailer/user/index.html.twig', [
                'registrationForm' => $form->createView()
            ]);

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

    /**
     * @Route("/activation/{token}", name="app_activation")
     */
    public function activation($token, UserRepository $users, EntityManagerInterface $entityManager)
    {
        // On recherche si un utilisateur avec ce token existe dans la base de données
        $user = $users->findOneBy(['activation_token' => $token]);

        // Si aucun utilisateur n'est associé à ce token
        if (!$user) {
            // On renvoie une erreur 404
            throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
        }

        // On supprime le token
        $user->setActivationToken(null);
        $user->setEnabled(true);
        $entityManager->persist($user);
        $entityManager->flush();



        // On envoie un message flash
        $this->addFlash('message', 'Vous avez bien activé votre compte');

        // On retoure à l'accueil
        return $this->redirectToRoute('app_forgottenPassword');
    }

    /**
     * @Route("/forgottenPassword", name="app_forgottenPassword")
     */
    public function forgottenPass(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        // On crée le formulaire
        $form = $this->createForm(ResetFormType::class);

        // On traite le formulaire
        $form->handleRequest($request);

        // Si le formulaire est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les données
            $donnees = $form->getData();

            // On cherche si un utilisateur a cet email
            $user = $userRepository->findOneByEmail($donnees['email']);

            // Si l'utilisateur n'existe pas
            if (!$user) {
                // On envoie un message flash
                $this->addFlash('danger', 'Cette adresse n\'existe pas');

                return $this->redirectToRoute('app_login');
            }

            // On génère un token et on l'enregistre


            try {
                $user->setResetToken(md5(uniqid()));

                $entityManager->persist($user);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', 'Une erreur est survenue : ' . $e->getMessage());
                return $this->redirectToRoute('app_login');
            }


            $this->mailer->sendEmailPassword($user->getEmail(), $user->getResetToken());

            // On crée le message flash
            $this->addFlash('message', 'Un email de réinitialisation de mot de passe vous a été envoyé');

            return $this->redirectToRoute('app_login');
        }

        // On envoie vers la page de demande de l'e-mail
        return $this->render('mailer/user/forgottenPassword.html.twig', ['emailForm' => $form->createView()]);
    }

    /**
     * @Route("/reset-pass/{token}", name="app_resetPassword")
     */
    public function resetPassword($token, Request $request, UserPasswordHasherInterface $userPasswordHasher, ManagerRegistry $doctrine)
    {
        // On cherche l'utilisateur avec le token fourni
        $user = $doctrine->getRepository(User::class)->findOneBy(['reset_token' => $token]);

        if (!$user) {
            $this->addFlash('danger', 'Token inconnu');
            return $this->redirectToRoute('app_login');
        }

        // Si le formulaire est envoyé en méthode POST
        if ($request->isMethod('POST')) {
            // On supprime le token
            $user->setResetToken(null);

            // On chiffre le mot de passe
            $user->setPassword(
                $userPasswordHasher->hashPassword($user, $request->request->get('password'))
            );
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Mot de passe modifié avec succès');

            return $this->redirectToRoute('app_login');
        } else {
            return $this->render('mailer/security/resetPassword.html.twig', ['token' => $token]);
        }
    }
}
