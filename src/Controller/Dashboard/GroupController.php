<?php

namespace App\Controller\Dashboard;

use App\Entity\Group;
use App\Form\GroupType;
use App\Repository\GroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GroupController extends AbstractController
{
    /**
     * @Route("/dashboard/groupes", name="dashboard_group")
     */
    public function index(Request $request, EntityManagerInterface $manager, GroupRepository $groupRepository): Response
    {
        $group = new Group();
        $form = $this->createForm(GroupType::class, $group);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($group);
            $manager->flush();
        }
        return $this->render('dashboard/group/index.html.twig', [
            'form' => $form->createView(),
            'groupes' => $groupRepository->findBy([],["title" => "ASC"])
        ]);
    }
}
