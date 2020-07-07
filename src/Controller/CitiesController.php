<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CitiesController extends AbstractController
{
    /**
     * @Route("/campus", name="cities_campus")
     */
    public function campus()
    {
        return $this->render('cities/campus.html.twig');
    }

    /**
     * @Route("/villes", name="cities_villes")
     */
    public function villes()
    {
        return $this->render('cities/villes.html.twig');
    }
}
