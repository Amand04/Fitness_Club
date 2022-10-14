<?php

namespace App\Controller;

use App\Entity\Partners;
use App\Entity\Permissions;
use App\Entity\Structures;
use App\Form\PermissionFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class PermissionsController extends AbstractController
{
    /**
     * @Route("admin/registerEntity/registerPermission", name="app_registerPermission")
     */
    public function register(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $permissions = new Permissions();

        $form = $this->createForm(PermissionFormType::class, $permissions);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $form->getData();
            $entityManager->persist($permissions);
            $entityManager->flush();

            // On envoie un message flash
            $this->addFlash('message', 'Demande enregistrée avec succès');

            return $this->render('admin/confirmRegister/entity.html.twig');
        }

        return $this->renderForm('admin/registerEntity/permission.html.twig', [
            'permissions' => $permissions,
            'form' => $form
        ]);
    }

    /**
     * @Route("admin/permissions/index", name="app_adminPermissionsIndex")
     */
    public function index(Request $request, ManagerRegistry $doctrine)
    {
        $permissions = $doctrine->getRepository(Permissions::class)->findAll();
        $partners = $doctrine->getRepository(Partners::class)->findAll();
        $structures = $doctrine->getRepository(Structures::class)->findAll();

        return $this->renderForm(
            'admin/permissions/index.html.twig',
            [
                "structures" => $structures,
                "partners" => $partners,
                "permissions" => $permissions,
            ]
        );
    }

    /**
     * @Route("admin/permissions/update/{id}", name="app_updatePermissions")
     */
    public function update(Permissions $permission, Request $request, ManagerRegistry $doctrine, MailerInterface $mailer): Response
    {
        $partners = $doctrine->getRepository(Partners::class)->findAll();

        $form = $this->createForm(PermissionFormType::class, $permission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $permission = $doctrine->getManager()->flush();

            // $partners = $doctrine->$this->getEmail();

            //    $email = (new Email())
            //
            //              ->from('amandinejeanjules@free.fr')
            //            ->to($partners)
            //          ->cc('amandinejeanjules@free.fr')
            //        //->bcc('amandinejeanjules@free.fr')
            //        //->replyTo('fabien@example.com')
            //        //->priority(Email::PRIORITY_HIGH)
            //        ->subject('Bienvenue parmis nous!')
            //        ->text('Cher Client,<br>Félicitations, vous êtes desormais enregistré dans notre application et faites désormais parti de nos clients!')
            //        ->html('<h2>Félicitations, vous êtes desormais enregistré dans notre application et faites désormais parti de nos clients!</h2><br>
            //    <h3>Les identitfiants nécessaires à votre connexion vous seront communiqués très prochainement par télephone par votre administrateur. </h3>
            //    <h3>Celui-ci fera également un point avec vous.</h3>
            //    <h3>Nous vous remercions de votre confiance et vous disons à trés bientôt!</h3>
            //    <h3>L\'équipe Fitness Club</h3>');

            //   $mailer->send($email);

            return $this->render('/mailer/permissions/index.html.twig');
        }

        return $this->renderForm("admin/permissions/update.html.twig", [
            "form" => $form,
            "permission" => $permission,
            "partners" => $partners
        ]);
    }

    /**
     * @Route("admin/permissions/delete/{id}", name="app_deletePermissions")
     */
    public function delete(Permissions $permission, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($permission);
        $entityManager->flush();
        return $this->redirectToRoute("app_adminPermissionsIndex");
    }
}
