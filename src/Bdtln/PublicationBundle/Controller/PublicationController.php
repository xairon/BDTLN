<?php

namespace Bdtln\PublicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PublicationController extends Controller
{
    /**
     * indexAction will display the list of all publication
     * @return Response Publication/publication_list.html.twig the list of publication
     */
    public function indexAction()
    {
        return $this->render('BdtlnPublicationBundle:Publication:publication_list.html.twig');
    }
    
    
}
