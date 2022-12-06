<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Form\SessionType;
use App\Entity\SessionFormation;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\SessionFormationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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


// FONCTION D'AJOUT ET D'EDITION DE SESSION ------------------------------------------
    /**
     * @Route("/session/add", name="add_session")
     * @Route("/session/{id}/edit", name="edit_session")
     */
    public function add(ManagerRegistry $doctrine, SessionFormation $session = null, Request $request): Response {

        if(!$session) {
            $session = new SessionFormation();
        }

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
            'formAddSession' =>$form->createView(),
            //recupere pour l'edit
            'edit' => $session->getId()
        ]);
    }

// SUPPRESSION SESSION ---------------------------------------------------------
    /**
     * @Route("session/{id}/delete", name="delete_session")
     */
    public function delete(ManagerRegistry $doctrine, SessionFormation $session) {

        $entityManager = $doctrine->getManager();
        // enleve de la collection de la base de données
        $entityManager->remove($session);
        $entityManager->flush();

        return $this->redirectToRoute('app_session');
    }

// FONCTION D'AJOUT DE STAGIAIRE
    /**
         * @Route("/session/formation/{idsess}/add/{idstag}", name="addStagiaire")
         * @ParamConverter("session", options={"mapping" : {"idsess": "id"}})
         * @ParamConverter("stagiaire", options={"mapping": {"idstag": "id"}})
     */
    public function addParticipant(ManagerRegistry $doctrine, SessionFormation $session, Stagiaire $stagiaire){

        $em = $doctrine->getManager();
        $session->addStagiaire($stagiaire);
        $em->persist($session);
        $em->flush();
        return $this->redirectToRoute('show_session', ['id' => $session->getId()]);

    }

// FONCTION DE SUPPRESSION DE STAGIAIRE 
    /**
        * @Route("/session/formation/{idsess}/remove/{idstag}", name="removeStagiaire")
        * @ParamConverter("session", options={"mapping" : {"idsess": "id"}})
        * @ParamConverter("stagiaire", options={"mapping": {"idstag": "id"}})
     */

    public function removeParticipant(ManagerRegistry $doctrine, SessionFormation $session, Stagiaire $stagiaire){

        $em = $doctrine->getManager();
        $session->removeStagiaire($stagiaire);
        $em->persist($session);
        $em->flush();
        return $this->redirectToRoute('show_session', ['id' => $session->getId()]);

    }

// FONCTION QUI RECUPERE LE STAGIAIRE DE LA BDD PAR SON ID ----------------------------
    /**
     * @Route("/session/{id}", name="show_session", requirements={"id"="\d+"})
     */
    public function show(SessionFormation $session, SessionFormationRepository $sr): Response
    {

        $nonInscrits = $sr->findNonInscrits($session->getId());
        // $nonProgrammes = $sr->findNonProgrammes($session->getId());


        return $this->render('session/show.html.twig', [
            'session' => $session,
            'nonInscrits' => $nonInscrits,
            // 'nonProgrammes' => $nonProgrammes
        ]);
    }


}
