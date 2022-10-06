<?php

namespace App\Controller;

use App\Entity\Partners;
use App\Entity\Permissions;
use App\Entity\Structures;
use App\Entity\User;
use App\Form\StructuresFormType;
use App\Repository\PartnersRepository;
use App\Repository\PermissionsRepository;
use App\Repository\StructuresRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class StructuresController extends AbstractController
{
    /**
     * @Route("admin/registerStructure", name="app_registerStructure")
     */
    public function registerStructure(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine, MailerInterface $mailer): Response
    {
        $structure = new Structures();

        $form = $this->createForm(StructuresFormType::class, $structure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $form->getData();
            $entityManager->persist($structure);
            $entityManager->flush();

            $email = (new Email())

                ->from('amandinejeanjules@free.fr')
                ->to($structure->getEmail())
                ->cc('amandinejeanjules@free.fr')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject('Votre nouvelle Structure!')
                ->text('Cher Client,<br>Félicitations, votre Structure vient d\'être enregistrée et fait désormais partie de nos clients!')
                ->html('<h2>Félicitations, votre Structure vient d\'être enregistrée et fait désormais partie de nos clients!</h2><br>
                <h3>Les identitfiants nécessaires à votre connexion vous seront communiqués très prochainement par télephone par votre administrateur. </h3>
                <h3>Celui-ci fera également un point avec vous.</h3>
                <h3>Nous vous remercions de votre confiance et vous disons à trés bientôt!</h3>
                <h3>L\'équipe Fitness Club</h3>');

            $mailer->send($email);


            return $this->render('/mailer/structure/index.html.twig');
        }
        return $this->renderForm('admin/registerStructure.html.twig', [
            'structure' => $structure,
            'form' => $form
        ]);
    }


    /**
     * @Route("admin/structures/index", name="app_adminStructuresIndex")
     */
    public function index(PartnersRepository $partnersRepository, Request $request, ManagerRegistry $doctrine, PaginatorInterface $paginator)
    {
        $structures = $doctrine->getRepository(Structures::class)->findAll();

        $structures = $paginator->paginate(
            $structures,
            $request->query->getInt('page', 1),
            6
        );

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
    public function read(PermissionsRepository $permissionsRepository, Request $request, PartnersRepository $partnerRepository, Structures $structure, ManagerRegistry $doctrine): Response
    {
        $structures = $doctrine->getRepository(Structures::class)->findAll();
        $form = $this->createForm(StructuresFormType::class, $structure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $structure = $doctrine->getManager()->flush();
        }
        return $this->render(
            "admin/structures/detailsStructures.html.twig",
            [
                "permission" => $permissionsRepository->findAll(),
                "permissions" => $permissionsRepository->findAll(),
                "partners" => $partnerRepository->findAll(),
                "structure" => $structure,
                "structures" => $structures,
                "form" => $form,

            ]
        );
    }

    /**
     * @Route("structure/structure/{id}/", name="app_structure")
     */
    public function readStructure(PermissionsRepository $permissionsRepository, UserRepository $userRepository, Structures $structures, ManagerRegistry $doctrine): Response
    {
        $user = $doctrine->getRepository(User::class)->findAll();

        return $this->render(
            "structure/structure.html.twig",
            [
                "permissions" => $permissionsRepository->findAll(),
                "user" => $user,
                "structures" => $structures
            ]
        );
    }

    /**
     * @Route("/welcomePage", name="app_welcomePage")
     */
    public function welcome(PartnersRepository $partnersRepository, UserRepository $userRepository, Request $request, ManagerRegistry $doctrine)
    {
        $structures = $doctrine->getRepository(Structures::class)->findAll();

        return $this->renderForm(
            'welcomePage.html.twig',
            [
                "user" => $userRepository->findAll(),
                "partners" => $partnersRepository->findAll(),
                "structures" => $structures,
            ]
        );
    }
}
