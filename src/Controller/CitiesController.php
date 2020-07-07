<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Villes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CitiesController extends AbstractController
{
    /**
     * @Route("/campus", name="cities_campus")
     */
    public function campus()
    {
        $campus = $this->getDoctrine()
            ->getRepository(Campus::class)
            ->findAll();

        if (!$campus) {
            throw $this->createNotFoundException(
                'Aucun campus trouvé'
            );
        }

        return $this->render('cities/campus.html.twig',
            ['campus' => $campus]
        );
    }

    /**
     * @Route("/villes", name="cities_villes")
     */
    public function villes()
    {
        $villes = $this->getDoctrine()
            ->getRepository(Villes::class)
            ->findAll();

        if (!$villes) {
            throw $this->createNotFoundException(
                'Aucune ville trouvée'
            );
        }
        return $this->render('cities/villes.html.twig',
        ['villes' => $villes]
        );
    }
}
