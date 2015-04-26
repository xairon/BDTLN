<?php

namespace Bdtln\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Bdtln\ProjectBundle\Entity\File;
use Bdtln\ProjectBundle\Entity\Project;
use Bdtln\ProjectBundle\Form\ProjectType;

class ProjectController extends Controller
{
    /**
     * indexAction display the page of one project
     * @param string $project
     * @return Response the page of the wanted project
     */
    public function indexAction( Project $project ) {
        return $this->render('BdtlnProjectBundle:Project:display_project.html.twig', array('project' => $project));
    }
    
     /**
     * add_projectAction will display a form and allow to create a project
     * @return Response Project/add_project.html.twig
     */
    public function  add_projectAction() {
        //The entityManager will allow to save the project in the database
        $entityManager = $this->getDoctrine()->getManager();
        //The project we want to fill with the form's values
        $project = new Project();
        //The form
        $projectForm = $this->createForm(new ProjectType(), $project);
        $axes = $entityManager->getRepository('BdtlnAxeBundle:Axe')->findAll();
        
        $request = $this->get('request');
        //If it is a validation of form
        if ( $request->getMethod() == "POST" ) {
            $idAxe = intval($_POST['axe']);
            //Loading of the form
            $projectForm->bind($request);
            //If all the inputs are valids, and wanted axe is differend of 0, save in database
            if ( $projectForm->isValid() && intval($_POST['axe']) != 0 ) {
                //Compare idAxe with all axes
                for ( $i = 0; $i < count($axes); $i++ ) {
                    //If the id of wanted axe is valid
                    if ( $axes[$i]->getId() == $idAxe ) {
                        //if at least one description is not empty
                        if (!empty($project->getFrenchDescription()) || !empty($project->getEnglishDescription())) {
                            $axes[$i]->addProject($project);
                            $entityManager->persist($axes[$i]);
                            $entityManager->persist($project);
                            $entityManager->flush();
                            //Redirect on the page of new project
                            return $this->redirect( $this->generateUrl('bdtln_project_display', array('slug' => $project->getSlug())) );
                       } else { //If all descriptions are empty
                           $this->get('session')->getFlashBag()->add('information', 'Au moins une description doit être remplie !');
                           return $this->render('BdtlnProjectBundle:Project:add_project.html.twig', array('form' => $projectForm->createView(), 'axes' => $axes));
                        }                           
                    }
                }       
            } else { //If the form is invalid
                $this->get('session')->getFlashBag()->add('information', 'Le projet n\'a pas pu être enregistré !');
            }
            if ( intval($idAxe) == 0 )
            $this->get('session')->getFlashBag()->add('information', 'Veuillez ajouter un axe ! !');

        }
        
        return $this->render('BdtlnProjectBundle:Project:add_project.html.twig', array('form' => $projectForm->createView(), 'axes' => $axes));
    }
 
    
    /**
     * add_axe_in_project allow to add axe in a project
     * @param type $id the id of Project
     */
    public function add_axe_in_projectAction( Project $project ) {
        
        //Verifier si la personne qui regarde cette page est aussi celle qui est responsable du projet
        
        $entityManager = $this->getDoctrine()->getManager();
        $axeRepository = $entityManager->getRepository('BdtlnAxeBundle:Axe');
        $axes = $axeRepository->findAllWithProjects();
        //The axes witch doesn't own this project
        $axesNotInProject = $axeRepository->findAllNotInProject($project);
        
        //If the form is submit
        if ( $this->get('request')->getMethod() == "POST" ) {
            $idAxe = intval($_POST['axe']);
            //look over all axes in order to test if the given axe is valid
            for ( $i = 0; $i < count($axes); $i++ ) {
                if ( $idAxe == $axes[$i]->getId() ) {
                    //If the project is not already in this axe
                    if ( in_array($axes[$i], $axesNotInProject) ) { 
                        $axes[$i]->addProject($project);
                        $entityManager->persist($project);
                        $entityManager->flush();
                        $this->get('session')->getFlashBag()->add('information', 'L\'axe a bien été ajouté !');
                        return $this->redirect( $this->generateUrl('bdtln_project_add_axe_in_project', array('slug' => $project->getSlug())) );
                    } else { //If axes[$i] doesn't belong to axes witch are not in project
                        $this->get('session')->getFlashBag()->add('information', 'Ce projet a déjà cet axe !');
                    }
                    break;
                }
            }
        }
        
        return $this->render('BdtlnProjectBundle:Project:add_axe_in_project.html.twig', array('project' => $project, 'axes' => $axesNotInProject));
    }
    
    
    public function update_projectAction ( Project $project ) {
        
        //The entityManager will allow to save the project in the database
        $entityManager = $this->getDoctrine()->getManager();

        //The form
        $projectForm = $this->createForm(new ProjectType(), $project);
        $axes = $entityManager->getRepository('BdtlnAxeBundle:Axe')->findAll();
        
        $request = $this->get('request');
        //If it is a validation of form
        if ( $request->getMethod() == "POST" ) {
            $idAxe = intval($_POST['axe']);
            //Loading of the form
            $projectForm->bind($request);
            //If all the inputs are valids, and wanted axe is differend of 0, save in database
            if ( $projectForm->isValid() && intval($_POST['axe']) != 0 ) {
                //Compare idAxe with all axes
                for ( $i = 0; $i < count($axes); $i++ ) {
                    //If the id of wanted axe is valid
                    if ( $axes[$i]->getId() == $idAxe ) {
                        //if at least one description is not empty
                        if (!empty($project->getFrenchDescription()) || !empty($project->getEnglishDescription())) {
                            $axes[$i]->addProject($project);
                            $entityManager->persist($axes[$i]);
                            $entityManager->persist($project);
                            $entityManager->flush();
                            //Redirect on the page of new project
                            return $this->redirect( $this->generateUrl('bdtln_project_display', array('slug' => $project->getSlug())) );
                       } else { //If all descriptions are empty
                           $this->get('session')->getFlashBag()->add('information', 'Au moins une description doit être remplie !');
                           return $this->render('BdtlnProjectBundle:Project:add_project.html.twig', array('form' => $projectForm->createView(), 'axes' => $axes));
                        }                           
                    }
                }       
            } else { //If the form is invalid
                $this->get('session')->getFlashBag()->add('information', 'Le projet n\'a pas pu être enregistré !');
            }
            if ( intval($idAxe) == 0 )
            $this->get('session')->getFlashBag()->add('information', 'Veuillez ajouter un axe ! !');

        }
        

        
        
        
        return $this->render('BdtlnProjectBundle:Project:update_project.html.twig', array('form' => $projectForm->createView(), 'axes' => $axes));
    }
    
    
    
    
    
    
    
    
}
