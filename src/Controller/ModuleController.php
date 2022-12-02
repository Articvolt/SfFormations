<?php

namespace App\Controller;

use App\Entity\Module;
use App\Form\ModuleType;
use App\Repository\ProgrammerRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModuleController extends AbstractController
{
    /**
     * @Route("/categorie", name="app_module")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
       // FONCTION QUI RECUPERE TOUT LES SESSIONS DE LA BDD
       $modules = $doctrine->getRepository(Module::class)->findAll();
       return $this->render('categorie/view.html.twig', [
           'modules' => $modules
       ]);
    }

    /**
     * @Route("/module/add", name="add_module")
     * @Route("/module/{id}/edit", name="edit_module")
     */
// FONCTION D'AJOUT ET D'EDITION DE module
public function add(ManagerRegistry $doctrine, Module $module = null, Request $request): Response {

    if(!$module) {
        $module = new module();
    }


    $form = $this->createForm(ModuleType::class, $module);
    $form->handleRequest($request);
    
    if($form->isSubmitted() && $form->isValid()) {
        
        $module = $form->getData();
        $entityManager = $doctrine->getManager();
        //prepare
        $entityManager->persist($module);
        //execute
        $entityManager->flush();
        // récupère l'id de la catégorie du module visé
        $idCat = $module->getCategorie()->getId();
        
        return $this->redirectToRoute('show_categorie', ["id" => $idCat]);
    }
    

    //vue pour afficher le formulaire
    return $this->render('module/add.html.twig', [
        //génère le formulaire visuellement
        'formAddModule' =>$form->createView(),
        //recupere pour l'edit
        'edit' => $module->getId()
    ]);
}

// SUPPRESSION MODULE
    /**
     * @Route("module/{id}/delete", name="delete_module")
     */
    public function delete(ManagerRegistry $doctrine, Module $module) {

        $entityManager = $doctrine->getManager();

        // dd($programmes);
        
        $idCat = $module->getCategorie()->getId();
        // enleve de la collection de la base de données
        $entityManager->remove($module);
        $entityManager->flush();

        return $this->redirectToRoute('show_categorie', ["id" => $idCat]);
    }
}
