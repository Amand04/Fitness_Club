<?php

namespace App\Controller;

use App\Entity\Partners;
use App\Entity\Permissions;
use App\Form\PermissionFormType;
use App\Repository\PermissionsRepository;
use App\Repository\StructuresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PermissionsController extends AbstractController
{


    /**
     * @Route("admin/registerPermission", name="app_registerPermission")
     */
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        $permission = new Permissions();

        $form = $this->createForm(PermissionFormType::class, $permission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $form->getData();
            $entityManager->persist($permission);
            $entityManager->flush();

            return $this->redirectToRoute("app_adminPermissionsIndex");
        }


        return $this->renderForm('admin/registerPermission.html.twig', [
            'permission' => $permission,
            'form' => $form
        ]);
    }


    /**
     * @Route("admin/permissions/index", name="app_adminPermissionsIndex")
     */
    public function index(StructuresRepository $structuresRepository, PermissionsRepository $permissionsRepository, Request $request, ManagerRegistry $doctrine, PaginatorInterface $paginator)
    {
        $permissions = $doctrine->getRepository(Permissions::class)->findAll();
        $partners = $doctrine->getRepository(Partners::class)->findAll();

        $permissions = $paginator->paginate(
            $permissions,
            $request->query->getInt('page', 1),
            6
        );

        return $this->renderForm(
            'admin/permissions/index.html.twig',
            [
                "structures" => $structuresRepository->findAll(),
                "partners" => $partners,
                "permissions" => $permissions,
            ]
        );
    }

    /**
     * @Route("admin/permissions/update/{id}", name="app_updatePermissions")
     */
    public function update(Permissions $permission, Request $request, ManagerRegistry $doctrine): Response
    {
        $partners = $doctrine->getRepository(Partners::class)->findAll();

        $form = $this->createForm(PermissionFormType::class, $permission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $permissions = $doctrine->getManager()->flush();

            return $this->redirectToRoute("app_adminPermissionsIndex");
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
    public function delete(Permissions $permission, Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($permission);
        $entityManager->flush();
        return $this->redirectToRoute("app_adminPermissionsIndex");
    }
}
