<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditAccountType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EditAccountController extends AbstractController
{
    /**
     * @Route("/compte/detail/{id}/edit", name="edit")
     */
    public function formEditExampleAction(Request $request, User $user, EntityManagerInterface $em, $id)
    {
        // pour recuperer la sortie avec l'id et afficher les valeurs dans les placeholder
        $repo = $this->getDoctrine()->getRepository(User::class);
        $account = $repo->find($id);
        $editAccountForm = $this->createForm(EditAccountType::class, $account);


        $editAccountForm->handleRequest($request);

        if ($editAccountForm->isSubmitted() && $editAccountForm->isValid()) {

//            /** @var User $user */
//            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('edit'    , [
                'id' => $account->getId(),]);

        }

        return $this->render('edit_account/edit.html.twig', [
            'form' => $editAccountForm  ->createView()
        ]);
    }
}
