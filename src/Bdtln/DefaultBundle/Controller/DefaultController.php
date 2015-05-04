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
        
        $lastPublication10 = $this->getDoctrine()->getManager()->getRepository('BdtlnPublicationBundle:Publication')->findLast(10);
        
        return $this->render('BdtlnDefaultBundle:Default:index.html.twig', array('lastPublications' => $lastPublication10));
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
