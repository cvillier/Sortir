<?php

namespace App\Controller;


use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AffichageCompteController extends AbstractController
{
    /**
     * @Route("/compte", name="compte")
     */
    public function affichage()
    {
        //récupère le repository pour les Idea, afin de faire une requête SELECT
        $repo = $this->getDoctrine()->getRepository(User::class);
        //fait la requête SELECT avec un WHERE et un ORDER BY et une LIMIT à 50
        $account = $repo->findAll();

        return $this->render('compte/list.html.twig', [
            //passe notre variable à twig
            "account" => $account,
        ]);
    }

    /**
     * @Route("/compte/detail/{id}", name="detail")
     */
    public function detail($id, UserRepository $repo)
    {
        //récupère une idée en fonction de sa clé primaire
        $account = $repo->find($id);
//        $pif = "paf";

        //compact crée un tableau associatif en recherchant les variables passées sous forme de chaîne
        return $this->render('compte/detail.html.twig', compact("account"));
    }
}
