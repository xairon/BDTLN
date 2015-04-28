<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Bdtln\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Bdtln\UserBundle\Entity\User;



/**
 * Description of Users
 *
 * @author anthony
 */
class Users implements FixtureInterface {

    public function load(ObjectManager $manager) {
        
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setPlainPassword("admin");
        $admin->setRoles(array('ROLE_SUPER_ADMIN'));
        $admin->setEnglishBiography("Hey I am an admin");
        $admin->setFrenchBiography("Hey, je suis un admin");
        $admin->setEmail("admin@bdtln.com");
        $admin->setFirstName("admin");
        $admin->setLastName("admin");
        $admin->setEnabled(true);
        
        $user = new User();
        $user->setUsername('user');
        $user->setPlainPassword("user");
        $user->setRoles(array('ROLE_USER'));
        $user->setEnglishBiography("Hey I am an user");
        $user->setFrenchBiography("Hey, je suis un utilisateur");
        $user->setEmail("user@bdtln.com");
        $user->setFirstName("user");
        $user->setLastName("user");
        $user->setEnabled(true);
        
        $manager->persist($admin);
        $manager->persist($user);
        $manager->flush();
    }
    
    
    
    
    
    
    
    
    
    
    
    
}
