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
        $admin->setUsername('nathalie-friburger');
        $admin->setPlainPassword("nathalie");
        $admin->setRoles(array('ROLE_SUPER_ADMIN'));
        $admin->setEnglishBiography("My name is Nathalie Friburger, I am teacher at François Rabelais.\n"
                . "I like practice ping pong.");
        $admin->setFrenchBiography("Je m'appelle Nathalie Friburger, je suis enseignante à l'université François Rabelais.\n"
                . "J'aime jouer au ping pong");
        $admin->setEmail("nathalie.friburger@univ-tours.fr");
        $admin->setFirstName("Nathalie");
        $admin->setLastName("Friburger");
        $admin->setEnabled(true);
        
        
        $user = new User();
        $user->setUsername('jean-yves-antoine');
        $user->setPlainPassword("jean");
        $user->setRoles(array('ROLE_USER'));
        $user->setEnglishBiography("My name is Jean-Yves Antoine, I'm researcher and teacher. I like practice scooter.");
        $user->setFrenchBiography("Je m'appelle Jean-Yves Antoine, je suis chercheur et enseignant. J'aime faire de la trotinette.");
        $user->setEmail("jean-yves.antoine@univ-tours.fr");
        $user->setFirstName("Jean-Yves");
        $user->setLastName("Antoine");
        $user->setEnabled(true);
        
        $manager->persist($admin);
        $manager->persist($user);
        $manager->flush();
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
}
