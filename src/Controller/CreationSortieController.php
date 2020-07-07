<?php

namespace App\Controller;

use App\Entity\Sorties;
use App\Form\CreationSortieFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CreationSortieController extends AbstractController
{
    /**
     * @Route("/creation/sortie", name="creation_sortie")
     */
    public function createSortie(EntityManagerInterface $em, Request $request)
    {
        if (!$this->isGranted("ROLE_USER")) {
            throw $this->createAccessDeniedException("Interdit");
        }
        $sortie = new Sorties();
        $creationSortieform = $this->createForm(CreationSortieFormType::class, $sortie);
        $data = $creationSortieform->getData();

        if ($creationSortieform->isSubmitted() && $creationSortieform->isValid()) {
            var_dump($data);
        }



//            $em->persist($sortie);
//            $em->flush();
//            $this->addFlash("success", "Sortie ajouté avec succès !");
//            return $this->redirectToRoute("sortie_detail", [
//                    "id" => $sortie->getId()
//                ]
//            );
//        }


        return $this->render('creation_sortie/creation.html.twig', [
            'creationSortieForm' => $creationSortieform->createView(),
        ]);
    }
}
