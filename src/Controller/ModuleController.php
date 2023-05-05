<?php

namespace App\Controller;

use App\Entity\Module;
use App\Form\ModuleType;
use App\Repository\ProgrammerRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModuleController extends AbstractController
{
    /**
     * @Route("/categorie", name="app_module")
     * @IsGranted("ROLE_USER")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
       // FONCTION QUI RECUPERE TOUT LES SESSIONS DE LA BDD
       $modules = $doctrine->getRepository(Module::class)->findAll();
       return $this->render('categorie/view.html.twig', [
           'modules' => $modules
       ]);
    }


    // FONCTION D'AJOUT ET D'EDITION DE MODULE -------------------------------
    /**
     * @Route("/module/add", name="add_module")
     * @Route("/module/{id}/edit", name="edit_module")
     * @IsGranted("ROLE_ADMIN")
     */
public function add(ManagerRegistry $doctrine, Module $module = null, Request $request): Response 
    {
        // condition IF si il n'y a pas de module, alors création d'une nouvelle instance de la classe module
        if(!$module) {
            $module = new module();
        }

        // création du formulaire
        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);
        
        // condition IF si le formulaire est valide et soumis
        if($form->isSubmitted() && $form->isValid()) {
            
            // récuperation des données du formulaire dans la variable module
            $module = $form->getData();
            $entityManager = $doctrine->getManager();
            //prepare la requête DQL
            $entityManager->persist($module);
            //execute la requête DQL vers la base de données
            $entityManager->flush();
            // récupère l'id de la catégorie du module visé
            $idCat = $module->getCategorie()->getId();
            
            // retourne une route avec des paramètres
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


// SUPPRESSION MODULE -----------------------------------------------------
    /**
     * @Route("module/{id}/delete", name="delete_module")
     * @IsGranted("ROLE_ADMIN")
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
