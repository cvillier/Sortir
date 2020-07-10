<?php

namespace App\Controller;

use App\Entity\Etats;
use App\Entity\Sorties;
use App\Entity\User;
use App\Form\CreationSortieFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CreationSortieController extends AbstractController
{
    /**
     * @Route("/creation/sortie", name="creation_sortie")
     */
    public function createSortie(EntityManagerInterface $em, Request $request)
    {
        if (!$this->isGranted("ROLE_ORGANISATEUR")) {
            $this->addFlash("error", "Accès interdit !");
            return $this->redirectToRoute("accueil");
        }

        // en attente de pouvoir reussir a utiliser l'utilisateur en session pour eviter la requete
//        $session = $request->getSession();
//        $utilisateurConnecte = $session->get('utilisateurConnecte');


        $sortie = new Sorties();
        $creationSortieform = $this->createForm(CreationSortieFormType::class, $sortie);



        $creationSortieform->handleRequest($request);

        if ($creationSortieform->isSubmitted() && $creationSortieform->isValid()) {

            // recupere l'utilisateur connecté
            $repoUser = $this->getDoctrine()->getRepository(User::class);
            $utilisateurConnecte = $repoUser->findOneBy(['pseudo' => $this->getUser()->getUsername()]);

            // recupere la liste des etats
            $etatRepo = $this->getDoctrine()->getRepository(Etats::class);

            // changement de l'etat selon le bouton choisi : En creation / Ouvert
            if ($request->request->has('enregistrer')) {
                $etat = $etatRepo->find(1);
                $sortie->setEtat($etat);
            }
            if ($request->request->has('publier')) {
                $etat = $etatRepo->find(2);
                $sortie->setEtat($etat);
            }

            //set l'organisateur a l'user connecté
            $sortie->setOrganisateur($utilisateurConnecte);
            //set le campus de la sortie comme celui de l'utilisateur connecté
            $sortie->setCampus($utilisateurConnecte->getCampus());
            //ajout en BDD
            $em->persist($sortie);
            $em->flush();

            $this->addFlash("success", "Sortie ajouté avec succès !");
            return $this->redirectToRoute("affichage_sortie", [
                "id" => $sortie->getId()
            ]);

        }

        return $this->render('creation_sortie/creation.html.twig', [
            'creationSortieForm' => $creationSortieform->createView(),
        ]);
    }
}
