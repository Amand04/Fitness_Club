<?php

namespace App\Controller;

use App\Entity\Structures;
use App\Form\StructureFormType;
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
    public function registerStructure(Request $request, EntityManagerInterface $entityManager): Response
    {
        $structure = new Structures();

        $form = $this->createForm(StructureFormType::class, $structure);
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
    public function index(Request $request, ManagerRegistry $doctrine)
    {
        $structures = $doctrine->getRepository(Structures::class)->findAll();

        return $this->renderForm(
            'admin/structures/index.html.twig',
            [
                "structures" => $structures,
            ]
        );
    }

    /**
     * @Route("admin/structures/update/{id}", name="update_structure")
     */
    public function update(Structures $structure, Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(StructureFormType::class, $structure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $structures = $doctrine->getManager()->flush();

            return $this->redirectToRoute("app_adminStructuresIndex");
        }

        return $this->renderForm("admin/structures/update.html.twig", [
            "form" => $form,
            "structure" => $structure
        ]);
    }

    /**
     * @Route("admin/structures/delete/{id}", name="delete_structures")
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
    public function read(Structures $structure): Response
    {
        return $this->render(
            "admin/structures/detailsStructure.html.twig",
            [
                "structure" => $structure
            ]
        );
    }
}
