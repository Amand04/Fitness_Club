<?php

namespace App\Controller;

use App\Entity\Partners;
use App\Entity\Permissions;
use App\Entity\Structures;
use App\Form\PermissionFormType;
use App\Service\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PermissionsController extends AbstractController
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
     * @Route("admin/registerEntity/registerPermission", name="app_registerPermission")
     */
    public function register(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
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
    public function update(Permissions $permission, Request $request, ManagerRegistry $doctrine, int $id): Response
    {


        $partner = $doctrine->getRepository(Partners::class)->find($id);


        $partners = $doctrine->getRepository(Partners::class)->findAll();

        $form = $this->createForm(PermissionFormType::class, $permission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $permission = $doctrine->getManager()->flush();
            $this->mailer->sendEmailPermissionsPartners($partner->getEmail());

            return $this->render('/mailer/permissions/index.html.twig');
        }

        return $this->renderForm("admin/permissions/update.html.twig", [
            'form' => $form,
            'permission' => $permission,
            'partners' => $partners,
            'partner' => $partner
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
