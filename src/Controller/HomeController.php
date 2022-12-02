<?php

namespace App\Controller;

use App\Repository\SessionFormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(SessionFormationRepository $sr): Response
    {
        $pastSessions = $sr->showSessionPast();
        $nowSessions = $sr->showSessionNow();
        $postSessions = $sr->showSessionPost();

        return $this->render('home/index.html.twig', [
            'pastSessions' => $pastSessions,
            'nowSessions' => $nowSessions,
            'postSessions' => $postSessions
        ]);
    }
}