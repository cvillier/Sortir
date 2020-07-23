<?php

namespace App\Controller;

use App\Entity\Etats;
use App\Entity\Sorties;
use App\Form\AnnulationSortieFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AnnulationSortieController extends AbstractController
{
    /**
     * @Route("/sortie/annulation/{id}", name="annulation_sortie", requirements={"id":"\d+"})
     */
    public function annulerSortie($id, Request $request, EntityManagerInterface $em)
    {
        $sortiesRepo = $this->getDoctrine()->getRepository(Sorties::class);
        $sortie = $sortiesRepo->find($id);

        // autorise l'acces a la page que si l'user est l'organisateur de la sortie ou admin
        if ($sortie->getOrganisateur() == $this->getUser() or $this->isGranted("ROLE_ADMIN")) {

            $annulationSortieForm = $this->createForm(AnnulationSortieFormType::class, $sortie);
            $annulationSortieForm->handleRequest($request);

            if ($annulationSortieForm->isSubmitted() && $annulationSortieForm->isValid()) {

                if ($request->request->has('annuler')) {
                    return $this->redirectToRoute("accueil");
                }
                $etatRepo = $this->getDoctrine()->getRepository(Etats::class);

                if ($request->request->has('enregistrer')) {
                    $etat = $etatRepo->find(6);
                    $sortie->setEtat($etat);
                    $em->persist($sortie);
                    $em->flush();
                    $this->addFlash("success", "Sortie annulée avec succès !");
                    return $this->redirectToRoute("accueil");
                }

            }
            return $this->render('annulation_sortie/annulationSortie.html.twig', [
                'annulationSortieForm' => $annulationSortieForm->createView(),
                "sortie" => $sortie
            ]);

        } else {
            $this->addFlash("error", "Annulation interdite vous n'etes pas l'organisateur !");
            return $this->redirectToRoute("accueil");
        }
    }

}
