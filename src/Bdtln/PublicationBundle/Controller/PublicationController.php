<?php

namespace Bdtln\PublicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PublicationController extends Controller
{
    /**
     * indexAction will display the list of all publications
     * @return Response Publication/publication_list.html.twig the list of publication
     */
    public function indexAction()
    {
        $publications = $this->getDoctrine()->getManager()->getRepository('BdtlnPublicationBundle:Publication')->findAllWithOwner();
        
        return $this->render('BdtlnPublicationBundle:Publication:publication_list.html.twig', array('publications' => $publications));
    }
    
    
}
