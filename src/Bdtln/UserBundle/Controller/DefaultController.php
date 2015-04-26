<?php

namespace Bdtln\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BdtlnUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
