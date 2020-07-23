<?php

namespace App\Controller;
;

use App\Entity\User;
use App\Form\EditAccountType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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
        $role = $this->getUser()->getRoles();

        // empeche de modifier si l'utilisateur n'est pas celui de la page
        if ($user == $this->getUser() or $this->isGranted("ROLE_ADMIN")) {

            $editAccountForm = $this->createForm(EditAccountType::class, $user);


            $editAccountForm->handleRequest($request);

            if ($editAccountForm->isSubmitted() && $editAccountForm->isValid()) {

                $photoFile = $editAccountForm['photoFile']->getData();

                //encodage du mdp
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $editAccountForm->get('plainPassword')->getData()
                    )
                );
                if ($photoFile) {
                    // Modification du nom de la photo uploadée
                    $safeFilename = uniqid();
                    $newFilename = $safeFilename . '.' . $photoFile->guessExtension();
                    $user->setPhotoName($newFilename);

                    // Déplacement du fichier dans notre dossier prévu à cet effet
                    try {
                        $photoFile->move(
                            $this->getParameter('upload_directory'),
                            $newFilename
                        );

                    } catch (FileException $e) {
                        error_log($e->getMessage());
                    }
                }
                $em = $this->getDoctrine()->getManager();
                $user->setRoles($role);
                $em->persist($user);
                $em->flush();

                $this->addFlash("success", "Le profil a bien été mis à jour");

                return $this->redirectToRoute('detail', [
                    'id' => $user->getId()
                ]);

            }

            return $this->render('edit_account/edit.html.twig', [
                'account' => $user,
                'form' => $editAccountForm->createView()
            ]);

        } else {
            $this->addFlash("danger", "Modification interdite : ce n'est pas votre compte !");
            return $this->redirectToRoute("accueil");
        }
    }
}
