<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /**
     * @Route("/admin/message", name="admin_message")
     */
    public function index(): Response
    {
        return $this->render('admin/message/index.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }
}
