<?php

namespace App\Controller;

use App\Entity\Partners;
use App\Form\PartnerFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartnersController extends AbstractController
{
    /**
     * @Route("admin/registerPartner", name="app_registerPartner")
     */
    public function registerPartner(Request $request, EntityManagerInterface $entityManager): Response
    {
        $partner = new Partners();

        $form = $this->createForm(PartnerFormType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData();
            $entityManager->persist($partner);
            $entityManager->flush();

            return $this->redirectToRoute('app_adminPartnersIndex');
        }
        return $this->renderForm('admin/registerPartner.html.twig', [
            'partner' => $partner,
            'form' => $form
        ]);
    }

    /**
     * @Route("admin/partners/index", name="app_adminPartnersIndex")
     */
    public function index(Request $request, ManagerRegistry $doctrine)
    {
        $partners = $doctrine->getRepository(Partners::class)->findAll();

        return $this->renderForm(
            'admin/partners/index.html.twig',
            [
                "partners" => $partners,
            ]
        );
    }

    /**
     * @Route("admin/partners/update/{id}", name="app_updatePartner")
     */
    public function update(Partners $partner, Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(PartnerFormType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $partners = $doctrine->getManager()->flush();

            return $this->redirectToRoute("app_adminPartnersIndex");
        }

        return $this->renderForm("admin/partners/update.html.twig", [
            "form" => $form,
            "partner" => $partner
        ]);
    }

    /**
     * @Route("admin/partners/delete/{id}", name="app_deletePartner")
     */
    public function delete(Partners $partner, Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($partner);
        $entityManager->flush();
        return $this->redirectToRoute("app_adminPartnersIndex");
    }

    /**
     * @Route("admin/partners/detailsPartner/{id}", name="app_detailsPartner")
     */
    public function read(Partners $partner): Response
    {
        return $this->render(
            "admin/partners/detailsPartner.html.twig",
            [
                "partner" => $partner
            ]
        );
    }
}
