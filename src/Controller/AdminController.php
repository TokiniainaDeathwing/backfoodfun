<?php

namespace App\Controller;

use App\Service\AdminService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    public function index()
    {
        return $this->render('login.html.twig');
    }
    public function login(SessionInterface $session,Request $request){
        $user=$request->get('user');
        $password=$request->get('password');
        $serviceadmin=new AdminService($this->getDoctrine(),$session);
        $serviceadmin->connexion($user,$password);

        return $this->redirectToRoute('index');

    }
    public function  deconnexion(SessionInterface $session){
        $serviceadmin=new AdminService($this->getDoctrine(),$session);
        $serviceadmin->deconnexion();
        return $this->redirectToRoute('index');

    }

}
