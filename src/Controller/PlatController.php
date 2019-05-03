<?php
// src/Controller/AdvertController.php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;

class PlatController extends  AbstractController
{
    // home page
    private $servicePlat;
    public function index(Environment $twig)
    {

        // var_dump($data);
        $content = $twig->render('base.html.twig');

        return new Response($content);
    }


}
