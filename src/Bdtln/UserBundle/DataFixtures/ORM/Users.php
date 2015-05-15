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
use Bdtln\PublicationBundle\Entity\Publication;
use Bdtln\UserBundle\Entity\Category;



/**
 * Description of Users
 *
 * @author anthony
 */
class Users implements FixtureInterface {

    public function load(ObjectManager $manager) {
        
        
        $category1 = new Category();
        $category1->setEnglishTitle("Teachers-Researchers");
        $category1->setFrenchTitle("Enseignant-Chercheurs");
        $manager->persist($category1);
        
        $category2 = new Category();
        $category2->setEnglishTitle("Doctors");
        $category2->setFrenchTitle("Docteurs");
        $manager->persist($category2);
        
        $category3 = new Category();
        $category3->setEnglishTitle("Doctorant");
        $category3->setFrenchTitle("Doctorant");
        $manager->persist($category3);
        $manager->flush();
        
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
        
        
        $publication1 = new Publication();
        $publication1->setTitle('My first publication');
        $publication1->setContent('This is a great publication');
        $publication1->setOwner($user);
        $manager->persist($publication1);
        $manager->flush();
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
}
