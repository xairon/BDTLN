<?php

namespace Bdtln\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Bdtln\UserBundle\Form\CategoryType;
use Bdtln\UserBundle\Entity\User;
use Bdtln\UserBundle\Entity\Category;


/**
 * Description of UserController
 *
 * @author anthony
 */
class UserController extends Controller{
    
    /**
     * add_category allow to add a category
     * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function add_categoryAction() {
        
        $entityManager = $this->getDoctrine()->getManager();
        $category = new Category();
        $categoryForm = $this->createForm(new CategoryType(), $category);
        $request = $this->get('request');
        
        if ($request->getMethod() == "POST") {
            $categoryForm->submit($request);
            if ( $categoryForm->isValid() ) {
                $entityManager->persist($category);
                $entityManager->flush();
                $this->get('session')->getFlashBag()->add('information', 'form.categoryadded');
                return $this->redirect( $this->generateUrl('bdtln_user_add_category') );
            }
        }
        
        
        return $this->render("BdtlnUserBundle:Category:add_category.html.twig", array('form' => $categoryForm->createView()));
    }
    
    
    /**
     * edit_category allow to add a category
     * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function edit_categoryAction(Category $category) {
        
        $entityManager = $this->getDoctrine()->getManager();
        $categoryForm = $this->createForm(new CategoryType(), $category);
        $request = $this->get('request');
        
        if ($request->getMethod() == "POST") {
            $categoryForm->submit($request);
            if ( $categoryForm->isValid() ) {
                $entityManager->persist($category);
                $entityManager->flush();
                $this->get('session')->getFlashBag()->add('information', 'form.categoryupdated');
                return $this->redirect( $this->generateUrl('bdtln_user_edit_category', array('id' => $category->getId())) );
            }
        }
        
        
        return $this->render("BdtlnUserBundle:Category:edit_category.html.twig", array('form' => $categoryForm->createView(), 'id' => $category->getId() ));
    }
    
    
    /**
     * display_all_categoriesAction display all categories
     * @Secure(roles="ROLE_SUPER_ADMIN")
     * @return Response
     */
    public function display_all_categoriesAction() {
        
        $entityManager = $this->getDoctrine()->getManager();
        $allCategories = $entityManager->getRepository('BdtlnUserBundle:Category')->findAll();
        
        return $this->render('BdtlnUserBundle:Category:display_all_categories.html.twig', array('categories' => $allCategories));
    }
    
    
    /**
     * delete_category will allow to delete a category
     * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function delete_categoryAction(Category $category) {
        
        $entityManager = $this->getDoctrine()->getManager();
        /*
         * Create a token for csrf
         * display form
         * handling form
         */
        $session = $this->get('session');
        $request = $this->get('request');
        $token = $session->get('token');
        if ( $request->getMethod() == "POST") {
            //If token doesn't exist or is invalid, of $_POST['delete_category'] doesn't exist or is invalid
            if ( $token == null || $_POST['token'] != $token || $_POST['delete_category'] == null || ( $_POST['delete_category'] != "yes" && $_POST['delete_category'] != "no" ) )
                throw $this->createNotFoundException ("Category not found");
            //else...
            if ( $_POST['delete_category'] == "yes" ) {
                $entityManager->getRepository('BdtlnUserBundle:User')->setCategoryNull($category->getId());
                $entityManager->remove($category);
                $entityManager->flush();
            } else {
                return $this->redirect( $this->generateUrl('bdtln_user_display_all_categories') );
            }
        }    
        
        
        $this->get('session')->set('token', sha1(time()));
        
        return $this->render('BdtlnUserBundle:Category:delete_category.html.twig', array('id' => $category->getId() ) );
        
    }
    
    
    
    
}
