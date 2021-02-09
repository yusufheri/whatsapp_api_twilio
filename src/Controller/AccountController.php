<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    
    /**
     * Permet de se connecter au serveur
     * 
     * @Route("/login", name="account_login")
     * 
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $hasErrors = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->redirectToRoute("homepage", [
            'hasErrors' => $hasErrors,
            'username' => $username
        ]);
    }

    /**
     * Permet de se déconnecter
     * @Route("/logout", name="account_logout")
     * @return void
     */
    public function logout(){

    }

    /**
     * Permet d'afficher le foormulaire d'inscription
     * 
     * @Route("/register", name="account_register")
     *
     * @return Response
     */
    public function register(Request $request, EntityManagerInterface $manager, 
    UserPasswordEncoderInterface $encoder){
        
        $user = new User();
        $user->setEmail($request->query->get('_email'))
                ->setHash($request->query->get('_password'))
                ->setPasswordConfirm($request->query->get('_confirm'))
                ->setContent($request->query->get('_content'));


            if($user->getHash() === $user->getPasswordConfirm()) {

                $hash = $encoder->encodePassword($user, $user->getHash());
                $user->setHash($hash);
    
                $manager->persist($user);
                $manager->flush();
    
                $this->addFlash('success', 'Votre compte a été créé avec succès, maintenant vous pouvez vous connecter');
                
            } else {
                $this->addFlash('danger', 'Les deux mots de passe doivent être identiques');
            }
            return $this->redirectToRoute('homepage');

        
    }
}
