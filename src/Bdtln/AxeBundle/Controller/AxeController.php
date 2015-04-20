<?php

namespace Bdtln\AxeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AxeController extends Controller
{
    /**
     * indexAction will display all the axes in a list with all projects in
     * @return Response Axe/index.html.twig the list of all the axes with all projects
     */
    public function indexAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        $allAxes = $entityManager->getRepository("BdtlnAxeBundle:Axe")->findAllWithProjects();
        
        
        return $this->render('BdtlnAxeBundle:Axe:axe_list.html.twig', array("axes" => $allAxes));
    }
}
