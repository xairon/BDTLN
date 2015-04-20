<?php

namespace Bdtln\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * indexAction will display the index of the website
     * @return Response Default/index.html.twig
     */
    public function indexAction() {
        return $this->render('BdtlnDefaultBundle:Default:index.html.twig');
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
