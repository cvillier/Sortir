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


class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {

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
            $sorties = $this->recherche($request, $form, $em);

        }
        return $this->render('accueil/index.html.twig', [
            'sorties' => $sorties, 'inscriptions' => $inscriptions,
            'accueilForm' => $form->createView(),
        ]);
    }

    /**
     * Fonction pour les checkbox
     * @Route("/recherche", name="recherche")
     * @param Request $request
     * @param FormInterface $form
     * @param EntityManagerInterface $em
     * @return int|mixed|string
     */
    public function recherche(Request $request, FormInterface $form, EntityManagerInterface $em)
    {
        $qb = $em->createQueryBuilder();
        $qb->select('s')
            ->from('App:Sorties', 's');

        // si la case (Dont je suis l'organisteur est cochée)
        if ($form->get("organisateur")->getData()) {
            $qb->where('s.organisateur = ?1')
                ->setParameter(1, $this->getUser());
        }

        // si la case (Dont je suis inscrit)
        if ($form->get("inscrit")->getData()) {
            $qb->LeftJoin('s.sortieUser', 'i')
                ->orWhere('i.user = ?9')
                ->setParameter(9, $this->getUser());
        }

        //      si la case (Dont je ne suis pas inscrit) -> j'y arrive pas :(
//        if ($form->get("nonInscrit")->getData()) {
//        }

        if ($form->get("sortiesPassees")->getData()) {
            $qb->andWhere('s.datedebut < ?2');
            $qb->setParameter(2, new \DateTime());
        }

        if ($request->get('inputRecherche') != "") {
            $word = $request->get('inputRecherche');
            $qb->andWhere('s.nom LIKE :word')
                ->orWhere('s.descriptioninfos LIKE :word')
                ->setParameter('word', '%' . $word . '%');
        }

        if ($request->get('inputDateDebut') != "") {
            $qb->andWhere('s.datedebut > ?4')
                ->setParameter(4, $request->get('inputDateDebut'));
        }

        if ($request->get('inputDateFin') != "") {
            $qb->andWhere('s.datedebut < ?5')
                ->setParameter(5, $request->get('inputDateFin'));
        }


        $qb->andWhere('s.campus = ?3')
            ->setParameter(3, $form->get('campus')->getData());
        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;

    }

    /**
     * Fonction pour se desinscrire d'une sortie.
     * @Route("/desister/{id}", name="desister", requirements={"id":"\d+"})
     * @param $id
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
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
     * Fonction pour publier une fonction crée.
     * @Route("/publier/{id}", name="publier", requirements={"id":"\d+"})
     * @param $id
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
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
     * Fonction pour s'inscrire a une sortie publiée.
     * @Route("/inscrire/{id}", name="inscrire", requirements={"id":"\d+"})
     * @param $id
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
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

    /**
     * Pour se rendre sur la page d'après connexion et va checker et changer au besoin l'etat de la sortie selon la date du jour.
     * @Route("/home", name="home")
     */
    public function home(EntityManagerInterface $em)
    {
        // changement d'etat des sorties selon la date
        $etatRepo = $this->getDoctrine()->getRepository(Etats::class);
        $cloturee = $etatRepo->find(3);
        //$enCours = $etatRepo->find(4);
        $passee = $etatRepo->find(5);

        $qbCloture = $em->createQueryBuilder();
        $qbCloture->update('App:Sorties', 's')
            ->set('s.etat', '?1')
            // si entre la date de cloture et la date du debut -> etat : cloturée
            ->where(':now BETWEEN  s.datecloture AND s.datedebut')
            ->setParameter(1, $cloturee)
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->execute();

        $qbPasse = $em->createQueryBuilder();
        $qbPasse->update('App:Sorties', 's')
            ->set('s.etat', '?3')
            // si apres la fin de la sortie -> etat : passée
            ->where('s.datedebut < :now')
            ->setParameter(3, $passee)
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->execute();


        $dansUnMois = new \DateTime();
        $dansUnMois->modify('-1 month');

        $qbArchive = $em->createQueryBuilder();
        $qbArchive->update('App:Sorties', 's')
            ->set('s.archivee', 1)
            //  si un mois apres la fin de la sortie -> archivée = true
            ->where('s.datedebut < :unMois')
            ->setParameter('unMois', $dansUnMois)
            ->getQuery()
            ->execute();

        return $this->render('accueil/accueilfront.html.twig', []);
    }

}
