<?php

namespace App\Controller;

use App\Entity\Sorties;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AffichageDUneSortieController extends AbstractController
{
    /**
     * @Route("/affichage/sortie/{id}", name="affichage_sortie", requirements={"id":"\d+"})
     */
    public function afficher($id)
    {
        if ($this->getUser()) {

            $sortiesRepo = $this->getDoctrine()->getRepository(Sorties::class);
            $sortie = $sortiesRepo->find($id);

            return $this->render('affichage_d_une_sortie/affichageSortie.html.twig', [
                "sortie" => $sortie
            ]);
        } else {
            $this->addFlash("error", "Accès interdit, veuillez vous connecter !");
            return $this->redirectToRoute("app_login");
        }
    }
}
