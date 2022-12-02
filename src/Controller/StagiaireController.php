<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Form\StagiaireType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StagiaireController extends AbstractController
{
    /**
     * @Route("/stagiaire", name="app_stagiaire")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
// FONCTION QUI RECUPERE TOUT LES STAGIAIRES DE LA BDD
        $stagiaires = $doctrine->getRepository(Stagiaire::class)->findBy([],['nom'=>'ASC']);
        return $this->render('stagiaire/index.html.twig', [
            'stagiaires' => $stagiaires
        ]);
    }


// FONCTION D'AJOUT ET D'EDITION DE STAGIAIRE ------------------------------------
    /**
     * @Route("/stagiaire/add", name="add_stagiaire")
     * @Route("/stagiaire/{id}/edit", name="edit_stagiaire")
     */
    public function add(ManagerRegistry $doctrine, Stagiaire $stagiaire = null, Request $request): Response {

        if(!$stagiaire) {
            $stagiaire = new stagiaire();
        }
    

        $form = $this->createForm(StagiaireType::class, $stagiaire);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $stagiaire = $form->getData();
            $entityManager = $doctrine->getManager();
            //prepare
            $entityManager->persist($stagiaire);
            //execute
            $entityManager->flush();

            return $this->redirectToRoute('app_stagiaire');
        }


        //vue pour afficher le formulaire
        return $this->render('stagiaire/add.html.twig', [
            //génère le formulaire visuellement
            'formAddStagiaire' =>$form->createView(),
            //recupere pour l'edit
            'edit' => $stagiaire->getId()
        ]);
    }


// SUPPRESSION STAGIAIRE ----------------------------------------------------
    /**
     * @Route("stagiaire/{id}/delete", name="delete_stagiaire")
     */
    public function delete(ManagerRegistry $doctrine, Stagiaire $stagiaire) {

        $entityManager = $doctrine->getManager();
        // enleve de la collection de la base de données
        $entityManager->remove($stagiaire);
        $entityManager->flush();

        return $this->redirectToRoute('app_stagiaire');
    }


// FONCTION QUI RECUPERE LE STAGIAIRE DE LA BDD PAR SON ID----------------------------
    /**
     * @Route("/stagiaire/{id}", name="show_stagiaire")
     */
    public function show(Stagiaire $stagiaire): Response
    {
        return $this->render('stagiaire/show.html.twig', [
            'stagiaire' => $stagiaire
        ]);
    }

}
