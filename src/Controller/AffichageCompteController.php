<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AffichageCompteController extends AbstractController
{
    /**
     * @Route("/affichage/compte", name="affichage_compte")
     */
    public function index()
    {
        return $this->render('affichage_compte/index.html.twig', [
            'controller_name' => 'AffichageCompteController',
        ]);
    }
}
