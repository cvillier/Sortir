<?php

namespace App\Controller;

use App\Entity\Etats;
use App\Entity\Inscriptions;
use App\Entity\Sorties;
use App\Form\AccueilType;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use function Doctrine\ORM\QueryBuilder;


class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index(Request $request, EntityManagerInterface $em)
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
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

                $sorties = $this->recherche($form, $em);

        }
        return $this->render('accueil/index.html.twig', [
            'sorties' => $sorties, 'inscriptions' => $inscriptions,
            'accueilForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/recherche", name="recherche")
     */
    public function recherche(FormInterface $form, EntityManagerInterface $em)
    {
        $qb = $em->createQueryBuilder();
        // si la case (Dont je suis l'organisteur est cochée)
        if ($form->get("organisateur")->getData()) {
            $qb->select('s')
                ->from('App:Sorties', 's')
                ->where('s.organisateur = ?1')
                ->setParameter(1, $this->getUser());
            if ($form->get("sortiesPassees")->getData()) {
                $qb->andWhere('s.datedebut < ?2');
                $qb->setParameter(2, new \DateTime());
            }
            // si la case (Dont je suis inscrit)
        } elseif ($form->get("inscrit")->getData()) {
            $qb->select(array('i', 's'))
                ->from('App:Sorties', 's')
                ->Join('s.sortieUser', 'i')
                ->where('i.user = ?1')
                ->setParameter(1, $this->getUser());
            if ($form->get("sortiesPassees")->getData()) {
                $qb->andWhere('s.datedebut < ?2');
                $qb->setParameter(2, new \DateTime());
            }

            // si la case (Dont je ne suis pas inscrit) -> j'y arrive pas :(
//        } elseif ($form->get("nonInscrit")->getData()) {
//            $inscrit = $em->createQueryBuilder();
//
//            $inscrit->select(array('i', 's'))
//                ->from('App:Sorties', 's')
//                ->Join('s.sortieUser', 'i')
//                ->where('i.user = ?1');
//
//                ->getQuery()
//                ->getArrayResult();
//
//
//            $qb->select(array('ii', 'ss'))
//                ->from('App:Sorties', 'ss')
//                ->Join('ss.sortieUser', 'ii')
//                ->where($qb->expr()->notIn('ii.user', $inscrit->getDQL()))
//                ->setParameter(1, $this->getUser());
//            if ($form->get("sortiesPassees")->getData()) {
//                $qb->andWhere('ss.datedebut < ?2');
//                $qb->setParameter(2, new \DateTime());
//            }

        } elseif ($form->get("sortiesPassees")->getData()) {
            $qb->select('s')
                ->from('App:Sorties', 's')
                ->where('s.datedebut < ?2')
                ->setParameter(2, new \DateTime());
        } else {
            $sorties = $this->getDoctrine()
                ->getRepository(Sorties::class)
                ->findAll();
            return $sorties;
        }
        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;

    }

    /**
     * @Route("/desister/{id}", name="desister", requirements={"id":"\d+"})
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
        $inscription = $inscriptionRepo->findOneBy(['sortie' => $sortie, 'user' => $utilisateurConnecte]);

        // ajout en BDD
        $em->remove($inscription);
        $em->flush();

        $this->addFlash("success", "Desinscription réalisée avec succès !");
        return $this->redirectToRoute("accueil");


    }

    /**
     * @Route("/publier/{id}", name="publier", requirements={"id":"\d+"})
     */
    public
    function publier($id, EntityManagerInterface $em)
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
     * @Route("/inscrire/{id}", name="inscrire", requirements={"id":"\d+"})
     */
    public
    function inscrire($id, EntityManagerInterface $em)
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
