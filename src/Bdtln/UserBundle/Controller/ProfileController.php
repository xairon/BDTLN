<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bdtln\UserBundle\Controller;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Bdtln\UserBundle\Form\UserProfileType;
use Bdtln\UserBundle\Entity\User;

/**
 * Controller managing the user profile
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class ProfileController extends Controller
{
    /**
     * Show the user
     */
    public function showAction( User $user )
    {
       
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw $this->createNotFoundException('People was not found');
        }

        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $user
        ));
    }

    /**
     * Edit the user
     * @Secure(roles="IS_AUTHENTICATED_REMEMBERED")
     */
    public function editAction(Request $request, User $user)
    {
        
        
        $entityManager = $this->getDoctrine()->getManager();
        $allCategories = $entityManager->getRepository('BdtlnUserBundle:Category')->findAll();
        
        
        //$user must be a User, root or the owner of account
        if (!is_object($user) || !$user instanceof UserInterface || ( $user != $this->getUser() && !in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles()) ) ) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        
        $form = $this->createForm( new UserProfileType(), $user );
        $form->setData($user);

        $form->handleRequest($request);
        if ( $this->get('request')->getMethod() == "POST" ) {
            $givenCategory = $entityManager->getRepository('BdtlnUserBundle:Category')->findOneOrNullById(intval($_POST['category']));
            //Verifier que les titres sont pas to defined
            if ($form->isValid() && $givenCategory != null ) {
                $user->setCategory($givenCategory);
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirect( $this->generateUrl('fos_user_profile_show', array('username' => $user->getUsername())) );
            }
        }
            
        return $this->render('FOSUserBundle:Profile:edit.html.twig', array(
            'form' => $form->createView(),
            'user' => $user,
            'categories' => $allCategories
        ));
    }
}
