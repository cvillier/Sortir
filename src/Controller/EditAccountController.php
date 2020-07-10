<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditAccountType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EditAccountController extends AbstractController
{
    /**
     * @Route("/compte/detail/{id}/edit", name="edit")
     */
    public function formEditExampleAction(Request $request, User $user, $id, UserPasswordEncoderInterface $passwordEncoder)
    {
        // pour recuperer la sortie avec l'id et afficher les valeurs dans les placeholder
        $repo = $this->getDoctrine()->getRepository(User::class);
        $account = $repo->find($id);

        // empeche de modifier si l'utilisateur n'est pas celui de la page
//        if ($account !== $this->getUser()) {
//            $this->addFlash("error", "Modification interdite ce n'est pas votre compte !");
//            return $this->redirectToRoute("accueil");
//        }

        $editAccountForm = $this->createForm(EditAccountType::class, $account);


        $editAccountForm->handleRequest($request);

        if ($editAccountForm->isSubmitted() && $editAccountForm->isValid()) {
            $account->setPassword(
                $passwordEncoder->encodePassword(
                    $account,
                    $editAccountForm->get('plainPassword')->getData()
                )
            );
            $photoProfil = $user->getPhotoFile();
            // this condition is needed because the 'photo' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($photoProfil) {
                $safeFilename = uniqid();
                $newFilename = $safeFilename.'.'.$photoProfil->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $photoProfil->move(
                        $this->getParameter('upload_directory' ),
                        $newFilename
                    );
                    $user->setAttachment($newFilename);
                } catch (FileException $e) {
                    error_log($e->getMessage());
                }

                $user->setPhoto($newFilename);
            }

//            /** @var User $user */
//            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('edit', [
                'id' => $account->getId()
            ]);

        }

        return $this->render('edit_account/edit.html.twig', [
            'form' => $editAccountForm->createView()
        ]);
    }
}
