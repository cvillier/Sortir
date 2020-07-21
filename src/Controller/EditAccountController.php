<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\User;
use App\Form\EditAccountType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EditAccountController extends AbstractController
{
    /**
     * @Route("/compte/detail/{id}/edit", name="edit")
     */
    public function formEditExampleAction(Request $request, $id, UserPasswordEncoderInterface $passwordEncoder)
    {
        // pour recuperer la sortie avec l'id et afficher les valeurs dans les placeholder
        $repoUser = $this->getDoctrine()->getRepository(User::class);
        $user = $repoUser->find($id);

        $repoPhoto = $this->getDoctrine()->getRepository(Photo::class);
        $photo = $repoPhoto->find($id); //à corriger : ici on implique que le user 1 ai la photo 1 etc...

        // empeche de modifier si l'utilisateur n'est pas celui de la page
        if ($user == $this->getUser() or $this->isGranted("ROLE_ADMIN")) {

            $editAccountForm = $this->createForm(EditAccountType::class, $user);


            $editAccountForm->handleRequest($request);

            if ($editAccountForm->isSubmitted() && $editAccountForm->isValid()) {

                //encodage du mdp
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $editAccountForm->get('plainPassword')->getData()
                    )
                );

            if ($photo) {
            // Modification du nom de la photo uploadée
                $safeFilename = uniqid();
                $newFilename = $safeFilename.'.'.$photo->guessExtension();
                $photo->setPhotoName($newFilename);

                // Déplacement du fichier dans notre dossier prévu à cet effet
                try {
                    $photo->move(
                        $this->getParameter('upload_directory' ),
                        $newFilename
                    );

                } catch (FileException $e) {
                    error_log($e->getMessage());
                }

                $user->setPhoto($photo);
            }


                $em = $this->getDoctrine()->getManager();
                $em->persist($photo);
                $em->persist($user);
                $em->flush();

                $this->addFlash("success", "Le profil a bien été mise à jour");

                return $this->redirectToRoute('edit', [
                    'id' => $user->getId()
                ]);

            }

            return $this->render('edit_account/edit.html.twig', [
                'form' => $editAccountForm->createView()
            ]);

        } else {
            $this->addFlash("error", "Modification interdite : ce n'est pas votre compte !");
            return $this->redirectToRoute("accueil");
        }
    }
}
