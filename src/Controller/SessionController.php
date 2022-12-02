<?php

namespace App\Controller;

use App\Entity\SessionFormation;
use App\Form\SessionType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    /**
     * @Route("/session", name="app_session")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        // FONCTION QUI RECUPERE TOUT LES SESSIONS DE LA BDD
        $sessions = $doctrine->getRepository(SessionFormation::class)->findAll();
        return $this->render('session/index.html.twig', [
            'sessions' => $sessions
        ]);
    }

    /**
     * @Route("/session/add", name="add_session")
     */
// FONCTION D'AJOUT ET D'EDITION DE STAGIAIRE
    public function add(ManagerRegistry $doctrine, SessionFormation $session = null, Request $request): Response {

        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $session = $form->getData();
            $entityManager = $doctrine->getManager();
            //prepare
            $entityManager->persist($session);
            //execute
            $entityManager->flush();

            return $this->redirectToRoute('app_session');
        }

         //vue pour afficher le formulaire
         return $this->render('session/add.html.twig', [
            //génère le formulaire visuellement
            'formAddSession' =>$form->createView()
        ]);
    }

        /**
     * @Route("/session/{id}", name="show_session")
     */
    public function show(SessionFormation $session): Response
    {
// FONCTION QUI RECUPERE LE STAGIAIRE DE LA BDD PAR SON ID
        return $this->render('session/show.html.twig', [
            'session' => $session
        ]);
    }


}
