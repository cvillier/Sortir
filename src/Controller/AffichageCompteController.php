<?php

namespace App\Controller;


use App\Entity\Campus;
use App\Entity\User;
use App\Repository\CampusRepository;
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
        $repo = $this->getDoctrine()->getRepository(User::class);
        $account = $repo->findUserWithCampus();

        return $this->render('compte/list.html.twig', [
            "account" => $account,
        ]);
    }

    /**
     * @Route("/compte/detail/{id}", name="detail")
     */
    public function detail($id, UserRepository $repo)
    {
        $account = $repo->find($id);

        return $this->render('compte/detail.html.twig', compact("account"));
    }
}
