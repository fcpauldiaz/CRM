<?php

namespace Modulo1Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TelefonoController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('Modulo1Bundle:Default:index.html.twig', array('name' => $name));
    }

    public function showTelefonosAction()
    {
        
    }
}
