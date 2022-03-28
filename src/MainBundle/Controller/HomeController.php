<?php

namespace App\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

    /**
     * @Route("/user/home", name="home")
     */
    public function home(){
        return $this->render('base.html.twig');
    }

    /**
     * @Route("/user/vue", name="vue")
     */
    public function vue(){
        return $this->redirect('http://localhost:8080');
    }
}
