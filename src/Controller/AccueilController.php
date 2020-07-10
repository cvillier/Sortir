<?php

namespace App\Controller;

use App\Entity\Etats;
use App\Entity\Inscriptions;
use App\Entity\Sorties;
use App\Form\AccueilType;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index()
    {
        // pour l'instant ne sert a rien , a voir si arrive a faire marcher pour eviter des requetes d'user
//        $session = new Session();
//        if (!$session->get('utilisateurConnecte')) {
//            $repoUser = $this->getDoctrine()->getRepository(User::class);
//            $utilisateurConnecte = $repoUser->findOneBy(['pseudo' => $this->getUser()->getUsername()]);
//            $session->set('utilisateurConnecte', $utilisateurConnecte);
//        }

        $sorties = $this->getDoctrine()
            ->getRepository(Sorties::class)
            ->findAll();
        $inscriptions = $this->getDoctrine()->getRepository(Inscriptions::class)->findAll();

        if (!$sorties) {
            throw $this->createNotFoundException(
                'Aucune sortie trouvée'
            );
        }

        $form = $this->createForm(AccueilType::class);

        return $this->render('accueil/index.html.twig', [
            'sorties' => $sorties, 'inscriptions' => $inscriptions,
             'accueilForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/desister", name="desister", requirements={"id":"\d+"})
     */
    public function seDesister($id, EntityManagerInterface $em)
    {
        // recupere la sortie
        $sortiesRepo = $this->getDoctrine()->getRepository(Sorties::class);
        $sortie = $sortiesRepo->find($id);

        // recupere l'utilisateur
        $repoUser = $this->getDoctrine()->getRepository(User::class);
        $utilisateurConnecte = $repoUser->findOneBy(['pseudo' => $this->getUser()->getUsername()]);

        // supprime l'inscription
        $inscriptionRepo = $this->getDoctrine()->getRepository(Inscriptions::class);
        $inscription = $inscriptionRepo->findOneBy(['sortie_id' => $sortie, '_user_id' => $utilisateurConnecte]);

        // ajout en BDD
        $em->remove($inscription);
        $em->flush();

        $this->addFlash("success", "Desinscription réalisée avec succès !");
        return $this->redirectToRoute("accueil");



    }

    /**
     * @Route("/publier", name="publier", requirements={"id":"\d+"})
     */
    public function publier($id, EntityManagerInterface $em)
    {
        // recupere la sortie
        $sortiesRepo = $this->getDoctrine()->getRepository(Sorties::class);
        $sortie = $sortiesRepo->find($id);

        // recupere l'etat "Ouvert"
        $etatRepo = $this->getDoctrine()->getRepository(Etats::class);
        $etat = $etatRepo->find(2);

        // change l'etat de la sortie
        $sortie->setEtat($etat);

        // ajout en BDD
        $em->persist($sortie);
        $em->flush();

        $this->addFlash("success", "Sortie publiée avec succès !");
        return $this->redirectToRoute("accueil");
    }

    /**
     * @Route("/inscrire", name="inscrire", requirements={"id":"\d+"})
     */
    public function inscrire($id, EntityManagerInterface $em)
    {
        // recupere la sortie
        $sortiesRepo = $this->getDoctrine()->getRepository(Sorties::class);
        $sortie = $sortiesRepo->find($id);

        // recupere l'utilisateur
        $repoUser = $this->getDoctrine()->getRepository(User::class);
        $utilisateurConnecte = $repoUser->findOneBy(['pseudo' => $this->getUser()->getUsername()]);

        // ajoute l'inscription
        $inscription = new Inscriptions();
        $inscription->setSortie($sortie);
        $inscription->setUser($utilisateurConnecte);
        $inscription->setDate(new \DateTime());

        // ajout en BDD
        $em->persist($inscription);
        $em->flush();

        $this->addFlash("success", "Inscription effectuée avec succès !");

        return $this->redirectToRoute("accueil");

    }


}
