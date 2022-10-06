<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UsersFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    /**
     * @Route("admin/users/index", name="app_adminUsersIndex")
     */
    public function index(Request $request, ManagerRegistry $doctrine)
    {
        $users = $doctrine->getRepository(User::class)->findAll();



        return $this->renderForm(
            'admin/users/index.html.twig',
            [
                "users" => $users,
            ]
        );
    }

    /**
     * @Route("admin/users/update/{id}", name="app_updateUser")
     */
    public function update(User $user, Request $request, UserPasswordHasherInterface $userPasswordHasher, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(UsersFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user = $doctrine->getManager()->flush();

            return $this->redirectToRoute("app_adminUsersIndex");
        }

        return $this->renderForm("admin/users/update.html.twig", [
            "form" => $form,
            "user" => $user
        ]);
    }

    /**
     * @Route("admin/users/delete/{id}", name="app_deleteUser")
     */
    public function delete(User $user, Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute("app_adminUsersIndex");
    }

    /**
     * @Route("admin/users/detailsUser/{id}", name="app_detailsUser")
     */
    public function read(Request $request, ManagerRegistry $doctrine, User $user): Response
    {
        $form = $this->createForm(UsersFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $doctrine->getManager()->flush();
        }
        return $this->render(
            "admin/users/detailsUser.html.twig",
            [
                "user" => $user,
                "form" => $form,

            ]
        );
    }
}
