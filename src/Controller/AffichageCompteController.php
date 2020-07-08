<?php

namespace App\Controller;


use App\Entity\Campus;
use App\Entity\User;
use App\Form\EditAccountType;
use App\Repository\CampusRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
//    /**
//     * @Route("{id}/edit", name="edit")
//     */
//    public function formEditExampleAction(Request $request, User $user, EntityManagerInterface $em)
//    {
//        $form = $this->createForm(EditAccountType::class, $user);
//
//
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//
////            /** @var User $user */
////            $user = $form->getData();
//            $em = $this->getDoctrine()->getManager();
//            $em->flush();
//
//            return $this->redirectToRoute('edit', [
//                'id' => $user->getId(),]);
//        }
//
//        return $this->render('edit_account/edit.html.twig', [
//            'form' => $form->createView()
//        ]);
//    }
}
