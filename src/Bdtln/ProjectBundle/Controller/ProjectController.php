<?php

namespace Bdtln\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bdtln\ProjectBundle\Entity\Project;
use Bdtln\ProjectBundle\Form\ProjectType;
use Bdtln\ProjectBundle\Form\AttachedFileType;
use Bdtln\ProjectBundle\Entity\AttachedFile;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;



class ProjectController extends Controller
{
    /**
     * indexAction display the page of one project
     * @param string $slug
     * @return Response the page of the wanted project
     */
    public function indexAction( $slug ) {
            //Get the project and files and participants if it exists
            $projectDisplayed = $this->getDoctrine()->getManager()->getRepository('BdtlnProjectBundle:Project')->findProjectWithParticipantsManagersAndFiles( $slug );
            //If the project is not null
            if ( $projectDisplayed != null ) {
                $isAdmin = false;
                $user = $this->getUser();
                $managers = $projectDisplayed->getManagers()->toArray();
                
                
                
                //If the user has the rights to see the links like add a participant etc
                if ( $user != null && in_array("ROLE_SUPER_ADMIN", $user->getRoles()) || in_array($user, $managers))
                        $isAdmin = true;
                return $this->render('BdtlnProjectBundle:Project:display_project.html.twig', array('project' => $projectDisplayed, 'isAdmin' => $isAdmin));
            }
            else //If the project is null
                throw $this->createNotFoundException ("Project not found");
    }
    
     /**
     * add_projectAction will display a form and allow to create a project
     * @return Response Project/add_project.html.twig
     * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function  add_projectAction() {
        //The entityManager will allow to save the project in the database
        $entityManager = $this->getDoctrine()->getManager();
        //The project we want to fill with the form's values
        $project = new Project();
        //The form
        $projectForm = $this->createForm(new ProjectType(), $project);
        $axes = $entityManager->getRepository('BdtlnAxeBundle:Axe')->findAll();
        $user = $this->getUser();
        
        $request = $this->get('request');
        //If it is a validation of form
        if ( $request->getMethod() == "POST" ) {
            
           
            $idAxe = intval($_POST['axe']);
            //Loading of the form
            $projectForm->bind($request);
            //If all the inputs are valids, and wanted axe is greater than 0, save in database
            if ( $projectForm->isValid() && intval($_POST['axe']) > 0 && ( $project->getEndingDate() == null || $project->getBeginningDate() < $project->getEndingDate()) ) {
                
                //Compare idAxe with all axes
                for ( $i = 0; $i < count($axes); $i++ ) {
                    //If the id of wanted axe is valid
                    if ( $axes[$i]->getId() == $idAxe ) {
                        //if at least one description is not empty
                        if (!empty($project->getFrenchDescription()) || !empty($project->getEnglishDescription())) {
                            $axes[$i]->addProject($project);
                            $entityManager->persist($axes[$i]);
                            $project->addManager($user); //SUPER ADMIN is always manager
                            $entityManager->persist($project);
                            $entityManager->flush();
                            //Redirect on the page of new project
                            return $this->redirect( $this->generateUrl('bdtln_project_display', array('slug' => $project->getSlug())) );
                       } else { //If all descriptions are empty
                           $this->get('session')->getFlashBag()->add('information', 'At least one description should be filled!');
                           return $this->render('BdtlnProjectBundle:Project:add_project.html.twig', array('form' => $projectForm->createView(), 'axes' => $axes));
                        }                           
                    }
                }       
            } else { //If the form is invalid
                $this->get('session')->getFlashBag()->add('information', 'The project couldn\'t be saved!');
            }
            if ( intval($idAxe) == 0 )
                $this->get('session')->getFlashBag()->add('information', 'Please add an axe!');
            if ( $project->getEndingDate() != null && $project->getBeginningDate() > $project->getEndingDate() ) {
                $this->get('session')->getFlashBag()->add('information', 'The ending date should be greater than the beginning date');
            }
        }
        
        return $this->render('BdtlnProjectBundle:Project:add_project.html.twig', array('form' => $projectForm->createView(), 'axes' => $axes));
    }
 
    
    /**
     * add_axe_in_project allow to add axe in a project
     * @param type $id the id of Project
     * @return Response BdtlnProjectBundle:Project:add_axe_in_project.html.twig
     * @Secure(roles="IS_AUTHENTICATED_REMEMBERED")
     */
    public function update_axes_in_projectAction( Project $project ) {
        
        
        //Check if the current user has rigths or if he's the SUPER ADMIN
        $user = $this->getUser();
        $managers = $project->getManagers()->toArray();
        //If the user hasn't the rights to be here
        if ( !in_array("ROLE_SUPER_ADMIN", $user->getRoles()) && !in_array($user, $managers))
                throw new AccessDeniedHttpException("Accès limité");
        
        $session = $this->get('session');
        
        $entityManager = $this->getDoctrine()->getManager();  
        $axeRepository = $entityManager->getRepository('BdtlnAxeBundle:Axe');
        $axes = $axeRepository->findAllWithProjects();
        //The axes witch doesn't own this project
        $axesNotInProject = $axeRepository->findAllNotInProject($project);
        $axesInProject = $axeRepository->findAllInProject($project);
        
        //If the form is submit
        if ( $this->get('request')->getMethod() == "POST" ) {
            $idAxe = intval($_POST['axe']);
            //If admin want add an axe into the project
            if ( !empty($_POST['add_axe']) ) {
                //look over all axes in order to test if the given axe is valid
                for ( $i = 0; $i < count($axes); $i++ ) {
                    if ( $idAxe == $axes[$i]->getId() && !empty($session->get('token_add')) && $_POST['token_add'] == $session->get('token_add') ) {
                        //If the project is not already in this axe AND check the token (for csrf)
                        if ( in_array($axes[$i], $axesNotInProject) ) { 
                            $axes[$i]->addProject($project);
                            $entityManager->persist($project);
                            $entityManager->persist($axes[$i]);
                            $entityManager->flush();
                            $this->get('session')->getFlashBag()->add('information_add', 'The axe has been added!');
                            return $this->redirect( $this->generateUrl('bdtln_project_update_axes_in_project', array('slug' => $project->getSlug())) );
                        } else { //If axes[$i] doesn't belong to axes witch are not in project
                            $this->get('session')->getFlashBag()->add('information_add', 'This project already own this axe!');
                        }
                        break;
                    }
                }
            } else if ( !empty($_POST['delete_axe']) ) { //Id admin want delete an axe
                if ( count($axesInProject) > 1 ) { //If project belong at least to 2 project
                    //look over all axes in order to test if the given axe is valid
                    for ( $i = 0; $i < count($axes); $i++ ) {
                        if ( $idAxe == $axes[$i]->getId() && !empty($session->get('token_delete')) && $_POST['token_delete'] == $session->get('token_delete') ) {
                            //If the project is in this axe AND check the token (for csrf)
                            if ( in_array($axes[$i], $axesInProject) ) { 
                                $axes[$i]->removeProject($project);
                                $entityManager->persist($project);
                                $entityManager->persist($axes[$i]);
                                $entityManager->flush();
                                $this->get('session')->getFlashBag()->add('information_delete', 'The axe has been deleted from this project!');
                                return $this->redirect( $this->generateUrl('bdtln_project_update_axes_in_project', array('slug' => $project->getSlug())) );
                            } else { //If axes[$i] doesn't belong to axes witch are not in project
                                $this->get('session')->getFlashBag()->add('information_delete', 'This project doesn\'t own this axe!');
                            }
                            break;
                        }
                    }
                } else { //If the project belong to only one axe, we can't delete it
                    $this->get('session')->getFlashBag()->add('information_delete', 'A project must belong at least to one axe!');
                }
            } else { //Form is invalid
                return $this->redirect( $this->generateUrl('bdtln_project_update_axes_in_project') );
            }
        }
        
        $session->set('token_add', md5(time()));
        $session->set('token_delete', sha1(time()));
        
        return $this->render('BdtlnProjectBundle:Project:update_axes_in_project.html.twig', array('project' => $project, 'axesNotInProject' => $axesNotInProject, 'axesInProject' => $axesInProject));
    }
    
    /**
     * update_projectAction allow to update a project
     * @param Project $project
     * @return Response BdtlnProjectBundle:Project:update_project.html.twig
     * @Secure(roles="IS_AUTHENTICATED_REMEMBERED")
     */
    public function update_projectAction ( Project $project ) {
        
        
        //Check if the current user has rigths or if he's the SUPER ADMIN
        $user = $this->getUser();
        $managers = $project->getManagers()->toArray();
        //If the user hasn't the rights to be here
        if ( !in_array("ROLE_SUPER_ADMIN", $user->getRoles()) && !in_array($user, $managers))
                throw new AccessDeniedHttpException("The user can't be here");
        
        $request = $this->get('request');
       
        
        //The entityManager will allow to save the project in the database
        $entityManager = $this->getDoctrine()->getManager();

        //The form
        $projectForm = $this->createForm(new ProjectType(), $project);
        
        
        //If it is a validation of form
        if ( $request->getMethod() == "POST" ) {
            
            //Loading of the form
            $projectForm->bind($request);
            //If all the inputs are valids, save in database
            if ( $projectForm->isValid() && $project->getBeginningDate() < $project->getEndingDate() ) {
                
                //if at least one description is not empty
                if (!empty($project->getFrenchDescription()) || !empty($project->getEnglishDescription())) {
                    $entityManager->persist($project);
                    $entityManager->flush();
                    //Redirect on the page of updated project
                    return $this->redirect( $this->generateUrl('bdtln_project_display', array('slug' => $project->getSlug())) );
                } else { //If all descriptions are empty
                    $this->get('session')->getFlashBag()->add('information', 'Au moins une description doit être remplie !');
                    return $this->render('BdtlnProjectBundle:Project:update_project.html.twig', array('form' => $projectForm->createView(), 'axes' => $axes));
                }    
                     
            } else { //If the form is invalid
                $this->get('session')->getFlashBag()->add('information', 'Le projet n\'a pas pu être enregistré !');
            }

        }
        
        return $this->render('BdtlnProjectBundle:Project:update_project.html.twig', array('form' => $projectForm->createView(), 'project' => $project));
    }
    
    
    /**
     * update_participantsAction allow to update a particpants into a project
     * @param string $slug the slug of the project
     * @return Response BdtlnProjectBundle:Project:add_participant.html.twig
     * @Secure(roles="IS_AUTHENTICATED_REMEMBERED")
     */
    public function update_participantsAction( $slug ) {
        
        //Check if the current user has rigths or if he's the SUPER ADMIN
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $repositoryProject = $entityManager->getRepository('BdtlnProjectBundle:Project');
        $repositoryUser = $entityManager->getRepository('BdtlnUserBundle:User');
        $project = $repositoryProject->findProjectWithManagersAndParticipants($slug);

        $allUsers = $repositoryUser->findAll();
        $noParticipants = array();
        $participants = $project->getParticipants();
        
        //Look over all user to find the users who don't participe
        for ( $i = 0; $i < count($allUsers); $i++ ) {
            if ( !in_array($allUsers[$i], $participants->toArray()) )
                    $noParticipants[] = $allUsers[$i];
        }
        
        
        
        $managers = $project->getManagers()->toArray();
        
        //If the user hasn't the rights to be here
        if ( !in_array("ROLE_SUPER_ADMIN", $user->getRoles()) && !in_array($user, $managers))
                throw new AccessDeniedHttpException("Accès limité");
        if ( $project === null )
            throw $this->createNotFoundException ('Projet non trouvé');

        $session = $this->get('session');
        
        //If the form is submitted
        if ( $this->get('request')->getMethod() == "POST" ) {
            $idUser = (!empty($_POST['selectUser']) && intval($_POST['selectUser']) != 0 ) ? intval($_POST['selectUser']) : 0;
            
            if ( $idUser == 0 ) //If selected user is invalid
                return $this->redirect ( $this->generateUrl('bdtln_project_update_participants', array('slug' => $project->getSlug())) );
            
            $postedParticipant = $repositoryUser->find($idUser);
            //If the admin want add a participant
            if ( !empty($_POST['submit_add'])) {
                if ( $postedParticipant != null ) {
                    if ( count($noParticipants) >= 1 ) { //If there is at least one person who don't participe
                        $project->addParticipant($postedParticipant);
                        $entityManager->flush();
                        return $this->redirect( $this->generateUrl('bdtln_project_display', array('slug' => $project->getSlug())) );
                    } else { //If everybody participe to this project
                        $this->get('session')->getFlashBag()->add('informations_add', 'Everybody participe to this project !');
                        return $this->redirect( $this->generateUrl('bdtln_project_update_participants', array('slug' => $project->getSlug())) );
              
                    }
                } else { //If postedParticipant is null
                    throw $this->createNotFoundException('People was not found');
                }
                
            } else if ( !empty($_POST['submit_delete']) ) {//If he want delete a participant
                if ( count($participants) >= 1 ) {
                    $project->removeParticipant($postedParticipant);
                    $entityManager->flush();
                    return $this->redirect( $this->generateUrl('bdtln_project_display', array('slug' => $project->getSlug())) );
                } else {
                    $this->get('session')->getFlashBag()->add('informations_delete', 'The project must have at least one participant !');
                    return $this->redirect( $this->generateUrl('bdtln_project_update_participants', array('slug' => $project->getSlug())) );
                }
            } else { //If in the submitted form there is not submit_add and not submit_delete
                throw $this->createNotFoundException();
            }
            
            
        }
        
        
        
        
        $session->set('token_add_participant', sha1(time()));
        $session->set('token_delete_participant', md5(time()));

        return $this->render('BdtlnProjectBundle:Project:update_participants.html.twig', array('project' => $project, 'participants' => $participants, 'noParticipants' => $noParticipants));
    }
    
    
    
    /**
     * update_managersAction allow to update a managers into a project
     * @param string $slug the slug of the project
     * @return Response BdtlnProjectBundle:Project:update_managers.html.twig
     * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function update_managersAction( $slug ) {
        
        //Check if the current user has rigths or if he's the SUPER ADMIN
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $repositoryProject = $entityManager->getRepository('BdtlnProjectBundle:Project');
        $repositoryUser = $entityManager->getRepository('BdtlnUserBundle:User');
        $project = $repositoryProject->findProjectWithManagersAndParticipants($slug);
        $managers = $project->getManagers()->toArray();
        $allUsers = $repositoryUser->findAll();
        $noManagers = array();
        
        
        //Look over all user to find the users who aren't managers
        for ( $i = 0; $i < count($allUsers); $i++ ) {
            if ( !in_array($allUsers[$i], $managers) )
                    $noManagers[] = $allUsers[$i];
        }
        

        if ( $project === null )
            throw $this->createNotFoundException ('Projet non trouvé');

        $session = $this->get('session');
        
        //If the form is submitted
        if ( $this->get('request')->getMethod() == "POST" ) {
            $idUser = (!empty($_POST['selectUser']) && intval($_POST['selectUser']) != 0 ) ? intval($_POST['selectUser']) : 0;
            
            if ( $idUser == 0 ) //If selected user is invalid
                return $this->redirect ( $this->generateUrl('bdtln_project_update_managers', array('slug' => $project->getSlug())) );
            
            $postedManager = $repositoryUser->find($idUser);
            //If the admin want add a manager
            if ( !empty($_POST['submit_add'])) {
                if ( $postedManager != null ) {
                    $project->addManager($postedManager);
                    $entityManager->flush();
                    return $this->redirect( $this->generateUrl('bdtln_project_display', array('slug' => $project->getSlug())) );
                } else {
                    throw $this->createNotFoundException('The people was not found');
                }
                
            } else if ( !empty($_POST['submit_delete']) ) {//If he want delete a manager
                
                if ( in_array("ROLE_SUPER_ADMIN", $postedManager->getRoles())) { //If postedManager is SUPER_ADMIN
                    $this->get('session')->getFlashBag()->add('informations_delete', 'The root can\'t be deleted!');
                    return $this->redirect( $this->generateUrl('bdtln_project_update_managers', array('slug' => $project->getSlug())) );
                }
                else if ( count($managers) > 1 ) {
                    $project->removeManager($postedManager);
                    $entityManager->flush();
                    return $this->redirect( $this->generateUrl('bdtln_project_display', array('slug' => $project->getSlug())) );
                } else {
                    $this->get('session')->getFlashBag()->add('informations_delete', 'The project must have at least one manager !');
                    return $this->redirect( $this->generateUrl('bdtln_project_update_managers', array('slug' => $project->getSlug())) );
                }
            } else { //If in the submitted form there is not submit_add and not submit_delete
                throw $this->createNotFoundException();
            }
            
            
        }
        
        $session->set('token_add_manager', sha1(time()));
        $session->set('token_delete_manager', md5(time()));

        return $this->render('BdtlnProjectBundle:Project:update_managers.html.twig', array('project' => $project, 'managers' => $managers, 'noManagers' => $noManagers));
        
    }
    
    
    
    /**
     * delete_projectAction allow to delete a project
     * @param Project $project
     * @return Response the page witch delete the project, or if it's already deleted the list of projects
     * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function delete_projectAction( Project $project ) {
        
        $session = $this->get('session');
        $entityManager = $this->getDoctrine()->getManager();
        
        //If the form is submitted
        if ( $this->get('request')->getMethod() == "POST" ) {
            $token = ( !empty($session->get('token')) ) ? $session->get('token') : null;
            //If the form is invalid
            if ( empty($token) ||  $_POST['token'] != $token || $_POST['delete'] != "yes" && $_POST['delete'] != "no" )
                throw $this->createNotFoundException ();
            //Else, delete the project only if $_POST['delete'] equals "yes"
            if ( $_POST['delete'] == "yes" ) {
                $entityManager->remove($project);
                $entityManager->flush();
                return $this->redirect( $this->generateUrl('bdtln_axe_homepage') );
            } else { //IF $_POST['delete'] equals "no" redirect on the project's page
                return $this->redirect( $this->generateUrl('bdtln_project_display', array('slug' => $project->getSlug())) );
            }
        }
        
        $session->set('token', sha1(time()));
        return $this->render('BdtlnProjectBundle:Project:delete_project.html.twig', array('project' => $project));
    }
    
    /**
     * add_file allow to add a file in a project
     * @param string $slug the project where we want add a file
     * @Secure(roles="IS_AUTHENTICATED_REMEMBERED")
     */
    public function add_fileAction($slug) {
        
         //Get the project and files and participants if it exists
            $entityManager = $this->getDoctrine()->getManager();
            $project = $entityManager->getRepository('BdtlnProjectBundle:Project')->findProjectWithParticipantsManagersAndFiles( $slug );
            //If the project is not null
            if ( $project != null ) {
                $user = $this->getUser();
                $managers = $project->getManagers()->toArray();
                $request = $this->get('request');
                $file = new AttachedFile();
                $fileForm = $this->createForm(new AttachedFileType(), $file);
                //If the user has the rights to see this page
                if ( $user != null && in_array("ROLE_SUPER_ADMIN", $user->getRoles()) || in_array($user, $managers)) {
                    //On form submit   
                    if ($request->getMethod() == "POST") {
                        $fileForm->submit($request);
                        if ( $fileForm->isValid() ) {
                            
                            $project->addFile($file);
                            $file->upload($file->getTitle());
                            $entityManager->flush();
                            $this->get('session')->getFlashBag()->add('information', 'The file is added');
                            return $this->redirect( $this->generateUrl('bdtln_project_add_file', array('slug' => $slug)) );
                        }
                        
                    }
                    
                    
                    
                    
                    
                    return $this->render('BdtlnProjectBundle:Project:add_file.html.twig', array('slug' => $slug, 'form' => $fileForm->createView(),
                                              'frenchTitle' => $project->getFrenchTitle(), 'englishTitle' => $project->getEnglishTitle()));
                }
                else { //If user hasn't right
                    throw $this->createAccessDeniedException('Access denied');
                }
            }
            else //If the project is null
                throw $this->createNotFoundException ("Project not found");
    }
    
    
    public function delete_fileAction($slug) {
        
        
            //Get the project and files and participants if it exists
            $entityManager = $this->getDoctrine()->getManager();
            $project = $entityManager->getRepository('BdtlnProjectBundle:Project')->findProjectWithParticipantsManagersAndFiles( $slug );
            //If the project is not null
            if ( $project != null ) {
                $user = $this->getUser();
                $managers = $project->getManagers()->toArray();
                $request = $this->get('request');
                $session = $this->get('session');
                $token = $session->get('token');
                $allFiles = $project->getFiles();
                //If the user has the rights to see this page
                if ( $user != null && in_array("ROLE_SUPER_ADMIN", $user->getRoles()) || in_array($user, $managers)) {
                    //On form submit   
                    if ($request->getMethod() == "POST" ) {
                        //If token is invalid
                        if ( empty($token) || $token != $_POST['token'] )
                            throw $this->createAccessDeniedException();
                        
                        $fileRepository = $entityManager->getRepository('BdtlnProjectBundle:AttachedFile');
                        foreach ( $_POST['delete_file'] as $idFile ) {
                            $file = $fileRepository->find(intval($idFile));
                            if ( $file != null && $project->hasFile($file) ) {
                                $project->removeFile($file);
                                $entityManager->remove($file);
                                $file->deleteFile();
                            }
                            $this->get('session')->getFlashBag()->add('information', 'The file is removed');
                        }
                        $entityManager->flush();
                        /**
                         * Recuperer toutes les cases cochees
                         * parcourir, et si le projet hasFile() de ce fichier
                         * on supprimer
                         */
                        
                    }
                    $session->set('token', sha1(time()));
                    //Render of the view
                    return $this->render('BdtlnProjectBundle:Project:delete_file.html.twig', array('slug' => $slug, 'files' => $allFiles,
                                'frenchTitle' => $project->getFrenchTitle(), 'englishTitle' => $project->getEnglishTitle()));
                }
                else { //If user hasn't right
                    throw $this->createAccessDeniedException();
                }
            }
            else //If the project is null
                throw $this->createNotFoundException ("Project not found");
    }
    
}
