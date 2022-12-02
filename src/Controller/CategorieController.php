<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\ProgrammerRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="app_categorie")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        // FONCTION QUI RECUPERE TOUTE LES CATEGORIES DE LA BDD
        $categories = $doctrine->getRepository(Categorie::class)->findAll();
        return $this->render('categorie/index.html.twig', [
            'categories' => $categories
        ]);
    }


    // FONCTION D'AJOUT ET D'EDITION DE CATEGORIE -----------------------------------
    /**
     * @Route("/categorie/add", name="add_categorie")
     * @Route("/categorie/{id}/edit", name="edit_categorie")
     */
    public function add(ManagerRegistry $doctrine, Categorie $categorie = null, Request $request): Response {

        if(!$categorie) {
            $categorie = new categorie();
        }

        //création du formulaire avec pour argument la classe du formulaire et une variable
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $categorie = $form->getData();
            $entityManager = $doctrine->getManager();
            //prepare
            $entityManager->persist($categorie);
            //execute
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie');
        }

        //retourne la vue pour afficher le formulaire
        return $this->render('categorie/add.html.twig', [
            //génère la vue du formulaire
            'formAddCategorie' =>$form->createView(),
            //recupere l'id pour l'edition
            'edit' => $categorie->getId()
        ]);
    }


// SUPPRESSION CATEGORIE--------------------------------------------------------
    /**
     * @Route("categorie/{id}/delete", name="delete_categorie")
     */
    public function delete(ManagerRegistry $doctrine, Categorie $categorie) {

        $entityManager = $doctrine->getManager();

        // // dd($programmes);
        // enleve de la collection de la base de données
        $entityManager->remove($categorie);
        $entityManager->flush();

        return $this->redirectToRoute('app_categorie');
    }


// AFFICHER UNE CATEGORIE--------------------------------------------------------
    /**
     * @Route("/categorie/{id}", name="show_categorie")
     */
    public function show(Categorie $categorie): Response
    {
// FONCTION QUI RECUPERE LE categorie DE LA BDD PAR SON ID
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie
        ]);
    }
}
