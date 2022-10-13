<?php

namespace App\Controller;

use App\Entity\Partners;
use App\Entity\Permissions;
use App\Entity\Structures;
use App\Entity\User;
use App\Form\StructuresFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StructuresController extends AbstractController
{
    /**
     * @Route("admin/registerStructure", name="app_registerStructure")
     */
    public function registerStructure(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
    {
        $structure = new Structures();

        $form = $this->createForm(StructuresFormType::class, $structure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $form->getData();
            $entityManager->persist($structure);
            $entityManager->flush();

            //renvoi au template
            return $this->render('/mailer/user/confirmRegisterEntity.html.twig');
        }
        $permissions = $doctrine->getRepository(Permissions::class)->findAll();

        return $this->renderForm('admin/registerStructure.html.twig', [
            'structure' => $structure,
            "permissions" => $permissions,
            'form' => $form
        ]);
    }

    /**
     * @Route("admin/structures/index", name="app_adminStructuresIndex")
     */
    public function index(Request $request, ManagerRegistry $doctrine, PaginatorInterface $paginator)
    {
        $structures = $doctrine->getRepository(Structures::class)->findAll();
        $partners = $doctrine->getRepository(Partners::class)->findAll();

        //pagination//
        $structures = $paginator->paginate(
            $structures,
            $request->query->getInt('page', 1),
            10
        );

        return $this->renderForm(
            'admin/structures/index.html.twig',
            [
                "partners" => $partners,
                "structures" => $structures,
            ]
        );
    }

    /**
     * @Route("admin/structures/update/{id}", name="app_updateStructures")
     */
    public function update(Structures $structure, Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(StructuresFormType::class, $structure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $structure = $doctrine->getManager()->flush();

            return $this->redirectToRoute("app_adminStructuresIndex");
        }

        return $this->renderForm("admin/structures/update.html.twig", [
            "form" => $form,
            "structure" => $structure
        ]);
    }

    /**
     * @Route("admin/structures/delete/{id}", name="app_deleteStructures")
     */
    public function delete(Structures $structure, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($structure);
        $entityManager->flush();
        return $this->redirectToRoute("app_adminStructuresIndex");
    }

    /**
     * @Route("structures/detailsStructure/{id}", name="app_detailsStructure")
     */
    public function read(Request $request, Structures $structure, ManagerRegistry $doctrine): Response
    {
        $structures = $doctrine->getRepository(Structures::class)->findAll();
        $partners = $doctrine->getRepository(Partners::class)->findAll();

        $form = $this->createForm(StructuresFormType::class, $structure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $structure = $doctrine->getManager()->flush();
        }
        return $this->render(
            "admin/structures/detailsStructures.html.twig",
            [
                "partners" => $partners,
                "structure" => $structure,
                "structures" => $structures,
                "form" => $form,
            ]
        );
    }

    /**
     * @Route("structure/structure/{id}/", name="app_structure")
     */
    public function readStructure(ManagerRegistry $doctrine): Response
    {
        $structures = $doctrine->getRepository(Structures::class)->findAll();
        $user = $doctrine->getRepository(User::class)->findAll();
        $permissions = $doctrine->getRepository(Permissions::class)->findAll();

        return $this->render(
            "structure/structure.html.twig",
            [
                "permissions" => $permissions,
                "user" => $user,
                "structures" => $structures
            ]
        );
    }

    /**
     * @Route("/welcomePage", name="app_welcomePage")
     */
    public function welcome(ManagerRegistry $doctrine)
    {
        $structures = $doctrine->getRepository(Structures::class)->findAll();
        $partners = $doctrine->getRepository(Partners::class)->findAll();
        $user = $doctrine->getRepository(User::class)->findAll();

        return $this->renderForm(
            'welcomePage.html.twig',
            [
                "user" => $user,
                "partners" => $partners,
                "structures" => $structures,
            ]
        );
    }
}
