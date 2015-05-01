<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Bdtln\ProjectBundle\DataFixtures\ORM\Projects;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Bdtln\ProjectBundle\Entity\Project;
use \Bdtln\ProjectBundle\Entity\File;
use Bdtln\AxeBundle\Entity\Axe;


/**
 * Description of Project
 *
 * @author anthony
 */
class Projects implements FixtureInterface {

    public function load(ObjectManager $manager) {

        
            // Creating of projects
            $projectWithoutFiles = new Project();
            $projectWithoutFiles->setEnglishDescription("This project is about databases, it is a research . . . .");
            $projectWithoutFiles->setEnglishSummary("This is a project.");
            $projectWithoutFiles->setEnglishTitle("A first project");
            $projectWithoutFiles->setFrenchDescription("C'est un projet qui concerne les bases de données, c'est une recherche . . . .");
            $projectWithoutFiles->setFrenchSummary("C'est un projet.");
            $projectWithoutFiles->setFrenchTitle("Un premier projet");
  

            $projectWithFiles = new Project();
            $projectWithFiles->setEnglishDescription("This project is about language, it is a research . . . .");
            $projectWithFiles->setEnglishSummary("This is a second project.");
            $projectWithFiles->setEnglishTitle("A second project");
            $projectWithFiles->setFrenchDescription("C'est un projet qui concerne le langage, c'est une recherche . . . .");
            $projectWithFiles->setFrenchSummary("C'est un deuxième projet");
            $projectWithFiles->setFrenchTitle("Un second projet");
           
            $file1 = new File();
            $file1->setPath("pictures/my_first_file.zip");
            $file1->setTitle("My file");
 
            $file2 = new File();
            $file2->setPath("pictures/my_second_file.zip");
            $file2->setTitle("My second file");
            
            $projectWithFiles->addFile($file1);
            $projectWithFiles->addFile($file2);
            
            $axe1 = new Axe();
            $axe1->setEnglishDescription("This axe is about databases . . . .");
            $axe1->setEnglishSummary("It's an axe bla bla bla bla bla");
            $axe1->setEnglishTitle("My First Axe");
            $axe1->setFrenchDescription("Cet axe concerne les bases de données");
            $axe1->setFrenchSummary("C'est un axe");
            $axe1->setFrenchTitle("Mon Premier Axe");
            $axe1->addProject($projectWithFiles);
            
            
            $axe2 = new Axe();
            $axe2->setEnglishDescription("This axe is about languages . . . .");
            $axe2->setEnglishSummary("It's an other axe");
            $axe2->setEnglishTitle("My Second Axe");
            $axe2->setFrenchDescription("Cet axe concerne le langage");
            $axe2->setFrenchSummary("C'est un autre axe");
            $axe2->setFrenchTitle("Mon Deuxième Axe");
            $axe2->addProject($projectWithoutFiles);
            
            
            
            $manager->persist($axe1);
            $manager->persist($axe2);
            $manager->persist($projectWithoutFiles); 
            $manager->persist($projectWithFiles);
            $manager->flush();
    }
    
    
    
    
    
    
    
    
    
    
    
    
}
