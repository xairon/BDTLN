<?php

namespace Bdtln\AxeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bdtln\AxeBundle\Entity\Axe;
use Bdtln\AxeBundle\Form\AxeType;
use JMS\SecurityExtraBundle\Annotation\Secure;



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
    
    
    
    /**
     * display_axeAction display only one axe
     * @param string $slug
     * @return BdtlnAxeBundle:Axe:display_axe.html.twig
     */
    public function display_axeAction( Axe $axe ) {
        $user = $this->getUser();
        $managers = $axe->getManagers();
        $isAdmin = ( $user != null && (in_array("ROLE_SUPER_ADMIN", $user->getRoles()) || in_array($user, $managers) ) ) ? true : false;
        
        return $this->render('BdtlnAxeBundle:Axe:display_axe.html.twig', array('axe' => $axe, 'isAdmin' => $isAdmin));
    }
    
    /**
     * add_axe allow to add an axe
     * @return Response BdtlnAxeBundle:Axe:add_axe.html.twig
     * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function add_axeAction() {
        
        //The entityManager will allow to save the axe in the database
        $entityManager = $this->getDoctrine()->getManager();
        $axe = new Axe();
        $axeForm = $this->createForm(new AxeType(), $axe);
        $managers = $axe->getManagers();
        $user = $this->getUser();
        $isAdmin = ( $user != null && (in_array("ROLE_SUPER_ADMIN", $user->getRoles()) || in_array($user, $managers) ) ) ? true : false;
      

        
        $request = $this->get('request');
        //If it is a validation of form
        if ( $request->getMethod() == "POST" ) {
            //Loading of the form
            $axeForm->bind($request);
            //If all the inputs are valids, save in database
            if ( $axeForm->isValid() ) {
                        //if at least one description is not empty
                        if (!empty($axe->getFrenchDescription()) || !empty($axe->getEnglishDescription())) { 
                            $axe->addManager($user); //SUPER ADMIN is always manager
                            $entityManager->persist($axe);
                            $entityManager->flush();
                            //Redirect on the page of new axe
                            return $this->redirect( $this->generateUrl('bdtln_axe_display_axe', array('slug' => $axe->getSlug())) );
                       } else { //If all descriptions are empty
                           $this->get('session')->getFlashBag()->add('information', 'Au moins une description doit être remplie !');
                           return $this->render('BdtlnaxeBundle:Axe:add_axe.html.twig', array('form' => $axeForm->createView(), 'axes' => $axes));
                        }
                }       
             else { //If the form is invalid
                $this->get('session')->getFlashBag()->add('information', 'L\'axe n\'a pas pu être enregistré !');
            }
        }
        
        
       return $this->render('BdtlnAxeBundle:Axe:add_axe.html.twig', array('form' => $axeForm->createView())); 
    }
    
    
    
    
    public function update_axeAction( Axe $axe ) {
        
        //The entityManager will allow to save the axe in the database
        $entityManager = $this->getDoctrine()->getManager();
        $axeForm = $this->createForm(new AxeType(), $axe);
        $user = $this->getUser();
        $managers = $axe->getManagers();
        $isAdmin = ( $user != null && (in_array("ROLE_SUPER_ADMIN", $user->getRoles()) || in_array($user, $managers) ) ) ? true : false;
      
        
        
        
        
        $request = $this->get('request');
        //If it is a validation of form
        if ( $request->getMethod() == "POST" ) {
            //Loading of the form
            $axeForm->bind($request);
            //If all the inputs are valids, save in database
            if ( $axeForm->isValid() ) {
                        //if at least one description is not empty
                        if (!empty($axe->getFrenchDescription()) || !empty($axe->getEnglishDescription())) { 
                            $entityManager->persist($axe);
                            $entityManager->flush();
                            //Redirect on the page of new axe
                            return $this->redirect( $this->generateUrl('bdtln_axe_display_axe', array('slug' => $axe->getSlug(), 'isAdmin' => $isAdmin)) );
                       } else { //If all descriptions are empty
                           $this->get('session')->getFlashBag()->add('information', 'Au moins une description doit être remplie !');
                           return $this->render('BdtlnaxeBundle:Axe:add_update.html.twig', array('form' => $axeForm->createView(), 'axes' => $axe));
                        }
                }       
             else { //If the form is invalid
                $this->get('session')->getFlashBag()->add('information', 'L\'axe n\'a pas pu être enregistré !');
            }
        }
        
        
       return $this->render('BdtlnAxeBundle:Axe:update_axe.html.twig', array('form' => $axeForm->createView(), 'axe' => $axe)); 
    }
    
    
    /**
     * update_managersAction allow to update a managers into an axe
     * @param string $slug the slug of the axe
     * @return Response BdtlnAxeBundle:Axe:update_managers.html.twig
     * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function update_managersAction ( $slug ) {
        
         //Check if the current user has rigths or if he's the SUPER ADMIN
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $repositoryUser = $entityManager->getRepository('BdtlnUserBundle:User');
        $repositoryAxe = $entityManager->getRepository('BdtlnAxeBundle:Axe');
        $axe = $repositoryAxe->findOneWithManagers($slug);
        
        if ( $axe === null )
            throw $this->createNotFoundException ('Axe non trouvé');
        
        $managers = $axe->getManagers()->toArray();
        $allUsers = $repositoryUser->findAll();
        $noManagers = array();
        
        
 
        
        
        //Look over all user to find the users who aren't managers
        for ( $i = 0; $i < count($allUsers); $i++ ) {
            if ( !in_array($allUsers[$i], $managers) )
                    $noManagers[] = $allUsers[$i];
        }

        $session = $this->get('session');
        
        //If the form is submitted
        if ( $this->get('request')->getMethod() == "POST" ) {
            $idUser = (!empty($_POST['selectUser']) && intval($_POST['selectUser']) != 0 ) ? intval($_POST['selectUser']) : 0;
            
            if ( $idUser == 0 ) //If selected user is invalid
                return $this->redirect ( $this->generateUrl('bdtln_axe_update_managers', array('slug' => $axe->getSlug())) );
            
            $postedManager = $repositoryUser->find($idUser);
            //If the admin want add a manager
            if ( !empty($_POST['submit_add'])) {
                if ( $postedManager != null ) {
                    $axe->addManager($postedManager);
                    $entityManager->flush();
                    return $this->redirect( $this->generateUrl('bdtln_axe_display_axe', array('slug' => $axe->getSlug())) );
                } else {
                    throw $this->createNotFoundException('The people was not found');
                }
                
            } else if ( !empty($_POST['submit_delete']) ) {//If he want delete a manager
                
                if ( in_array("ROLE_SUPER_ADMIN", $postedManager->getRoles())) { //If postedManager is SUPER_ADMIN
                    $this->get('session')->getFlashBag()->add('informations_delete', 'The root can\'t be deleted !');
                    return $this->redirect( $this->generateUrl('bdtln_axe_update_managers', array('slug' => $axe->getSlug())) );
                }
                else if ( count($managers) > 1 ) {
                    $axe->removeManager($postedManager);
                    $entityManager->flush();
                    return $this->redirect( $this->generateUrl('bdtln_axe_display_axe', array('slug' => $axe->getSlug())) );
                } else {
                    $this->get('session')->getFlashBag()->add('informations_delete', 'The project must have at least one manager !');
                    return $this->redirect( $this->generateUrl('bdtln_axe_update_managers', array('slug' => $axe->getSlug())) );
                }
            } else { //If in the submitted form there is not submit_add and not submit_delete
                throw $this->createNotFoundException();
            }
            
            
        }
        
        $session->set('token_add_manager', sha1(time()));
        $session->set('token_delete_manager', md5(time()));

        return $this->render('BdtlnAxeBundle:Axe:update_managers.html.twig', array('axe' => $axe, 'managers' => $managers, 'noManagers' => $noManagers));
    }
    
    

    /**
     * delete_axeAction allow to delete an axe
     * @param Axe $axe
     * @return Response the page witch delete the axe, or if it's already deleted the list of projects
     * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function delete_axeAction( Axe $axe ) {
        
        
         $session = $this->get('session');
        $entityManager = $this->getDoctrine()->getManager();
        
        //If the form is submitted
        if ( $this->get('request')->getMethod() == "POST" ) {
            $token = ( !empty($session->get('token')) ) ? $session->get('token') : null;
            //If the form is invalid
            if ( empty($token) ||  $_POST['token'] != $token || $_POST['delete'] != "yes" && $_POST['delete'] != "no" )
                throw $this->createNotFoundException ();
            //Else, delete the axe and all project in this axe
            
            
            $entityManager->remove($axe);
            $entityManager->flush();
            return $this->redirect( $this->generateUrl('bdtln_axe_homepage') );
        }
        
        $session->set('token', sha1(time()));
        
        return $this->render('BdtlnAxeBundle:Axe:delete_axe.html.twig', array('slug' => $axe->getSlug()));
    }
    
    
    
    
}
