<?php

namespace App\Controller;

use App\Entity\Permissions;
use App\Entity\Structures;
use App\Form\StructuresFormType;
use App\Repository\PartnersRepository;
use App\Repository\PermissionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StructuresController extends AbstractController
{
    /**
     * @Route("admin/registerStructure", name="app_registerStructure")
     */
    public function registerStructure(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {


        $structure = new Structures();



        $form = $this->createForm(StructuresFormType::class, $structure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $form->getData();
            $entityManager->persist($structure);
            $entityManager->flush();




            return $this->redirectToRoute('app_adminStructuresIndex');
        }
        return $this->renderForm('admin/registerStructure.html.twig', [
            'structure' => $structure,
            'form' => $form
        ]);
    }

    /**
     * @Route("admin/structures/index", name="app_adminStructuresIndex")
     */
    public function index(PartnersRepository $partnersRepository, Request $request, ManagerRegistry $doctrine)
    {
        $structures = $doctrine->getRepository(Structures::class)->findAll();

        return $this->renderForm(
            'admin/structures/index.html.twig',
            [
                "partners" => $partnersRepository->findAll(),
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
    public function delete(Structures $structure, Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($structure);
        $entityManager->flush();
        return $this->redirectToRoute("app_adminStructuresIndex");
    }

    /**
     * @Route("structures/detailsStructure/{id}", name="app_detailsStructure")
     */
    public function read(PermissionsRepository $permissionsRepository, Structures $structure): Response
    {
        return $this->render(
            "admin/structures/detailsStructures.html.twig",
            [
                "permission" => $permissionsRepository->findAll(),
                "permissions" => $permissionsRepository->findAll(),
                "structure" => $structure
            ]
        );
    }
}
