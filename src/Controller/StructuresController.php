<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StructuresController extends AbstractController
{
    /**
     * @Route("/structures", name="app_structures")
     */
    public function index(): Response
    {
        return $this->render('structures/index.html.twig', [
            'controller_name' => 'StructuresController',
        ]);
    }
}
