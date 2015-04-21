<?php

namespace Bdtln\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdministrationController extends Controller
{
    /**
     * indexAction is about the administration Dashboard. An administrator can choose that he want
     * to do
     * @return Response  Default/dashboard.html.twig
     */
    public function indexAction() {
        return $this->render('BdtlnAdministrationBundle:Default:dashboard.html.twig');
    }
    
   
    
    /**
     * add_user_to_projectAction will display a form and allow to add users on a project
     * @return Response Project/add_user_to_project.html.twig
     */
    public function add_user_to_projectAction() {
        return $this->render('BdtlnAdministrationBundle:Project:add_user_to_project.html.twig');
    }
    
    /**
     * add_userAction will display a form and allow to add a user
     * @return Response User/add_user.html.twig
     */
    public function add_userAction() {
        return $this->render('BdtlnAdministrationBundle:User:add_user.html.twig');
    }
    
    /**
     * update_userAction will display a form and allow to update a user
     * @return Response User/update_user.html.twig
     */
    public function update_userAction() {
        return $this->render('BdtlnAdministrationBundle:User:update_user.html.twig');
    }
    
    
    
    
    
    
    
    
    
    
    
    
}
