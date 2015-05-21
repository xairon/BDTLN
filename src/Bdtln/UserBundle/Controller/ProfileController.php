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
use Bdtln\UserBundle\Entity\Photo;

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
        $userRepository = $entityManager->getRepository('BdtlnUserBundle:User');
        $categoryRepository = $entityManager->getRepository('BdtlnUserBundle:Category');
        $allCategories = $categoryRepository->findAll();
        
        
        //$user must be a User, root or the owner of account
        if (!is_object($user) || !$user instanceof UserInterface || ( $user != $this->getUser() && !in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles()) ) ) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        
        $form = $this->createForm( new UserProfileType(), $user );
        $form->setData($user);

        $form->handleRequest($request);
        if ( $this->get('request')->getMethod() == "POST" ) {
            $givenCategory = $categoryRepository->findOneOrNullById(intval($_POST['category']));
            if ($form->isValid() && $givenCategory != null) {
                    //If the user has already a photo
                    $oldPhoto = $userRepository->findOneById($user->getId())->getPhoto();
                //If a photo is uploaded
                if ( $user->getPhoto() != null ) {

                    
                    //If delete_photo isn't checked
                    if ( empty($_POST['delete_photo'])) {
                        //Upload new photo
                        $user->getPhoto()->upload($user->getFirstName(), $user->getLastName(), $user->getId());
                    } else { //else, delete photo on server and on database
                        $entityManager->remove($user->getPhoto());
                        $user->getPhoto()->deleteFile();
                        $user->setPhoto(null);
                    }
                }
                
                $user->setCategory($givenCategory);
                //If user doesn't post any photo, he keep the old photo
                if ( empty($_POST['delete_photo']) && $oldPhoto != null)
                    $entityManager->persist($user->getPhoto());
                
                //If root disable the account (he can't disable account of a root)
                if ( in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles()) && !empty($_POST['disable_account']) && !in_array('ROLE_SUPER_ADMIN', $user->getRoles()) ) {
                    $user->setEnabled(false);
                    $user->setDateLeaving(new \DateTime);
                } else if (in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles()) && !empty($_POST['enable_account'])) {
                    $user->setEnabled(true);
                    $user->setDateLeaving(null);
                }
                
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
