<?php

namespace Bdtln\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Bdtln\ProjectBundle\Entity\File;
use Bdtln\ProjectBundle\Entity\Project;

class ProjectController extends Controller
{
    /**
     * indexAction display the page of one project
     * @param string $project_slug
     * @return Response the page of the wanted project
     */
    public function indexAction( Project $project ) {
      
        return $this->render('BdtlnProjectBundle:Project:display_project.html.twig', array('project' => $project));
    }
}
