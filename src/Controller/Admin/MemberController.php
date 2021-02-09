<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemberController extends AbstractController
{
    /**
     * @Route("/admin/member", name="admin_member")
     */
    public function index(): Response
    {
        return $this->render('admin/member/index.html.twig', [
            'controller_name' => 'MemberController',
        ]);
    }
}
