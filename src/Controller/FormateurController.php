<?php

namespace App\Controller;

use App\Entity\Formateur;
use App\Form\FormateurType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormateurController extends AbstractController
{
    /**
     * @Route("/formateur", name="app_formateur")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
         // FONCTION QUI RECUPERE TOUT LES FORMATEURS DE LA BDD
        $formateurs = $doctrine->getRepository(Formateur::class)->findAll();
        return $this->render('formateur/index.html.twig', [
            'formateurs' => $formateurs
        ]);
    }

    /**
     * @Route("/formateur/add", name="add_formateur")
     * @Route("/formateur/{id}/edit", name="edit_formateur")
     */
// FONCTION D'AJOUT ET D'EDITION DE FORMATEUR
    public function add(ManagerRegistry $doctrine, Formateur $formateur = null, Request $request): Response {

        if(!$formateur) {
            $formateur = new Formateur();
        }


        $form = $this->createForm(FormateurType::class, $formateur);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $formateur = $form->getData();
            $entityManager = $doctrine->getManager();
            //prepare
            $entityManager->persist($formateur);
            //execute
            $entityManager->flush();

            return $this->redirectToRoute('app_formateur');
        }


        //vue pour afficher le formulaire
        return $this->render('formateur/add.html.twig', [
            //génère le formulaire visuellement
            'formAddFormateur' =>$form->createView(),
            //recupere pour l'edit
            'edit' => $formateur->getId()
        ]);
    }

     // SUPPRESSION FORMATEUR
    /**
     * @Route("formateur/{id}/delete", name="delete_formateur")
     */
    public function delete(ManagerRegistry $doctrine, Formateur $formateur) {

        $entityManager = $doctrine->getManager();
        // enleve de la collection de la base de données
        $entityManager->remove($formateur);
        $entityManager->flush();

        return $this->redirectToRoute('app_formateur');
    }

}
