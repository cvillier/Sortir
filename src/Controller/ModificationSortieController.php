<?php

namespace App\Controller;

use App\Entity\Etats;
use App\Entity\Sorties;
use App\Form\CreationSortieFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ModificationSortieController extends AbstractController
{
    /**
     * @Route("/modification/sortie/{id}", name="modification_sortie", requirements={"id":"\d+"})
     */
    public function afficher($id, Request $request, EntityManagerInterface $em)
    {
        //  recupere la sortie
        $sortiesRepo = $this->getDoctrine()->getRepository(Sorties::class);
        $sortie = $sortiesRepo->find($id);

        // empeche d'acceder a la page si l'user n'est pas l'organisateur de la sortie
        if ($sortie->getOrganisateur() == $this->getUser() or $this->isGranted("ROLE_ADMIN")) {


            $modificationSortieform = $this->createForm(CreationSortieFormType::class, $sortie);
            $modificationSortieform->handleRequest($request);

            if ($modificationSortieform->isSubmitted() && $modificationSortieform->isValid()) {

                // renvoi sur l'accueil si annuler
                if ($request->request->has('annuler')) {
                    return $this->redirectToRoute("accueil");
                }

                // recupere la liste des etat possibles
                $etatRepo = $this->getDoctrine()->getRepository(Etats::class);

                // set l'etat a Clôturé si bouton supprimer
                if ($request->request->has('supprimer')) {
                    $etat = $etatRepo->find(3);
                    $sortie->setEtat($etat);
                    $em->persist($sortie);
                    $em->flush();
                    $this->addFlash("success", "Sortie supprimée avec succès !");
                    return $this->redirectToRoute("accueil");
                }

                // set l'etat a Ouvert si bouton publier
                if ($request->request->has('publier')) {
                    $etat = $etatRepo->find(2);
                    $sortie->setEtat($etat);
                }

                //ajout a la BDD
                $em->persist($sortie);
                $em->flush();

                // renvoit sur l'affichage de la sortie créée
                $this->addFlash("success", "Sortie modifiée avec succès !");
                return $this->redirectToRoute("affichage_sortie", [
                    "id" => $sortie->getId()
                ]);
            }

            return $this->render('modification_sortie/modificationSortie.html.twig', [
                'modificationSortieForm' => $modificationSortieform->createView(),
                "sortie" => $sortie
            ]);

        } else {
            $this->addFlash("error", "Modification interdite vous n'etes pas l'organisateur !");
            return $this->redirectToRoute("accueil");
        }
    }
}
