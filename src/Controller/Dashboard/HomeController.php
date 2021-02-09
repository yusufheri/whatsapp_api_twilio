<?php

namespace App\Controller\Dashboard;

use App\Repository\FavoriteRepository;
use App\Repository\MessageRepository;
use App\Repository\PersonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard_home")
     */
    public function index(FavoriteRepository $favorite, PersonRepository $person, 
    MessageRepository $messages): Response
    {
        $balance = 100;
        $credit = $balance - count($messages->findBy(["state" => true]));
        return $this->render('dashboard/home/index.html.twig', [
            'controller_name' => 'HomeController',
            'favorites' => count($favorite->findAll()),
            'people' => count($person->findAll()),
            'balance' => ($balance > 0)?$credit:0 
        ]);
    }
}
