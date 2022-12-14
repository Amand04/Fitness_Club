<?php

namespace App\Controller;

use App\Entity\Partners;
use App\Entity\Permissions;
use App\Entity\Structures;
use App\Entity\User;
use App\Form\PartnersFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartnersController extends AbstractController
{
    /**
     * @Route("admin/registerEntity/registerPartner", name="app_registerPartner")
     */
    public function registerPartner(Request $request, EntityManagerInterface $entityManager): Response
    {
        $partner = new Partners();

        $form = $this->createForm(PartnersFormType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData();
            $entityManager->persist($partner);
            $entityManager->flush();

            // On envoie un message flash
            $this->addFlash('message', 'Demande enregistrée avec succès');

            //renvoi au template
            return $this->render('admin/confirmRegister/entity.html.twig');
        }
        return $this->renderForm('admin/registerEntity/partner.html.twig', [
            'partner' => $partner,
            'form' => $form
        ]);
    }

    /**
     * @Route("admin/partners/index", name="app_adminPartnersIndex")
     */
    public function index(Request $request, ManagerRegistry $doctrine)
    {
        $permissions = $doctrine->getRepository(Permissions::class)->findAll();
        $partners = $doctrine->getRepository(Partners::class)->findAll();

        return $this->renderForm(
            'admin/partners/index.html.twig',
            [

                "permissions" => $permissions,
                "partners" => $partners,
            ]
        );
    }

    /**
     * @Route("admin/partners/update/{id}", name="app_updatePartner")
     */
    public function update(Partners $partner, Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(PartnersFormType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $partner = $doctrine->getManager()->flush();

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
    public function delete(Partners $partner, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($partner);
        $entityManager->flush();

        // On envoie un message flash
        $this->addFlash('message', 'Suppression réalisée avec succès');

        return $this->redirectToRoute("app_adminPartnersIndex");
    }

    /**
     * @Route("admin/partners/detailsPartner/{id}", name="app_detailsPartner")
     *
     */
    public function read(Partners $partner, Request $request, ManagerRegistry $doctrine): Response
    {
        $structures = $doctrine->getRepository(Structures::class)->findAll();
        $permissions = $doctrine->getRepository(Permissions::class)->findAll();

        $form = $this->createForm(PartnersFormType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $partner = $doctrine->getManager()->flush();
        }


        return $this->render(
            "admin/partners/detailsPartner.html.twig",
            [
                "partner" => $partner,
                "structures" => $structures,
                "permissions" => $permissions,
            ]
        );
    }

    /**
     * @Route("partner/partner/{id}", name="app_partner")
     */
    public function readPartner(Partners $partners, ManagerRegistry $doctrine): Response
    {
        $permissions = $doctrine->getRepository(Permissions::class)->findAll();
        $user = $doctrine->getRepository(User::class)->findAll();
        $structures = $doctrine->getRepository(Structures::class)->findAll();

        return $this->render(
            "partner/partner.html.twig",
            [
                "permissions" => $permissions,
                "user" => $user,
                "partners" => $partners,
                "structures" => $structures
            ]
        );
    }
}
