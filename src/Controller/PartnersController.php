<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartnersController extends AbstractController
{
    /**
     * @Route("/partners", name="app_partners")
     */
    public function index(): Response
    {
        return $this->render('partners/index.html.twig', [
            'controller_name' => 'PartnersController',
        ]);
    }
}
