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
use Bdtln\ProjectBundle\Entity\AttachedFile;
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
            $projectWithoutFiles->setEnglishDescription("Together we dreamed up than we had a data warehouse, than we was"
                    . " users and than there were data about us, and we have make a system witch allow to suggest"
                    . " some things to a user");
            $projectWithoutFiles->setEnglishSummary("Smart suggestion explain how we can make smart suggestions with data mining");
            $projectWithoutFiles->setEnglishTitle("Smart suggestions");
            $projectWithoutFiles->setFrenchDescription("Pour parvenir à nos fins nous "
                    . "avons réunis de nombreux chercheurs, nous avons imaginé que vous disposions d'un entrepôt de "
                    . "données, que nous étions des utilisateurs et qu'il y avait des données sur nous, "
                    . "et nous avons mis en place un système permettant de suggérer des choses directement en lien"
                    . " avec l'utilisateur demandé.");
            $projectWithoutFiles->setFrenchSummary("Suggestions intelligentes explique comment faire des suggestions intelligentes avec la fouille de données.");
            $projectWithoutFiles->setFrenchTitle("Suggestions intelligentes");
  

            $projectWithFiles = new Project();
            $projectWithFiles->setEnglishDescription("We had lot of texts (150,000 words), we scanned all of them.\n"
                    . "Then we examined times, conjugations, kind of writing according to epoch, and we make a "
                    . "system witch allow to find for example the events witch was before a given date.");
            $projectWithFiles->setEnglishSummary("We had lot of texts, and we"
                    . "wondered how to find any event at a given date ?");
            $projectWithFiles->setEnglishTitle("Ordering by chronological order of events witch are in a corpus");
            $projectWithFiles->setFrenchDescription("Nous avons pris un corpus de textes qui faisait à peu près 150 000 mots, "
                    . " nous avons scanné le tout pour faciliter le traitement.\n Ensuite nous avons étudié les "
                    . "temps, les conjugaisons, les façons d'écrire selon les époques, et nous avons mis en place"
                    . " un système qui peut retrouver par exemple les événements qui se sont déroulés avant une date,"
                    . " ou entre deux dates.");
            $projectWithFiles->setFrenchSummary("Parmis un corpus de textes de 150 000 mots, comment retrouver"
                    . "facilement les éléments antérieurs à une date données ?");
            $projectWithFiles->setFrenchTitle("Classement par ordre chronologique d'événements d'un corpus");
           
            $file1 = new AttachedFile();
            $file1->setPath("uploads/attached_files/source_code.zip");
            $file1->setTitle("Source code");
 
            $file2 = new AttachedFile();
            $file2->setPath("uploads/attached_files/some_notes.zip");
            $file2->setTitle("Some notes");
            
            $projectWithFiles->addFile($file1);
            $projectWithFiles->addFile($file2);
            
            $axe1 = new Axe();
            $axe1->setEnglishDescription("This axe is about databases, it is an important axe for our team"
                    . ", because we are specialized in database, data mining.");
            $axe1->setEnglishTitle("Databases");
            $axe1->setFrenchDescription("Cet axe concerne les bases de données, c'est un axe important pour"
                    . "notre équipe car nous somme spécialisés dans les bases de données, les fouilles de"
                    . " donneés.");
            $axe1->setFrenchTitle("Bases de données");
            $axe1->addProject($projectWithFiles);
            
            
            $axe2 = new Axe();
            $axe2->setEnglishDescription("The second great axis we work on, is handling of "
                    . "natural language.\nWe try to understand how are maked the different languages.");
            $axe2->setEnglishTitle("Natural language handling");
            $axe2->setFrenchDescription("Le second grand axe sur lequel nous travaillons, "
                    . "est le traitement du langage naturel.\nNous essayons de comprendre et de "
                    . "maîtriser comment sont formés les différents langages.");
            $axe2->setFrenchTitle("Traitement du langage naturel");
            $axe2->addProject($projectWithoutFiles);
            
            
            
            $manager->persist($axe1);
            $manager->persist($axe2);
            $manager->persist($projectWithoutFiles); 
            $manager->persist($projectWithFiles);
            $manager->flush();
    }
    
    
    
    
    
    
    
    
    
    
    
    
}
