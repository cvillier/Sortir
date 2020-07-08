<?php

namespace App\Controller;

use App\Entity\Etats;
use App\Entity\Sorties;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="home")
     */
    public function index()
    {
        $sorties = $this->getDoctrine()
            ->getRepository(Sorties::class)
            ->findAll();

        if (!$sorties) {
            throw $this->createNotFoundException(
                'Aucune sortie trouvée'
            );
        }

        return $this->render('accueil/index.html.twig',[
            'sorties'=>$sorties,
        ]);
    }
}
