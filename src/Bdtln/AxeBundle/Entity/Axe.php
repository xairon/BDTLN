<?php

namespace Bdtln\AxeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Axe
 *
 * @ORM\Table(name="axe")
 * @ORM\Entity(repositoryClass="Bdtln\AxeBundle\Entity\AxeRepository")
 */
class Axe
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * frenchTitle represent the french title of the axe
     * @var string
     *
     * @ORM\Column(name="french_title", type="string", length=255, unique=true)
     */
    private $frenchTitle;
    
    
    /**
     * englishTtitle represent the english title of the axe
     * @var string
     *
     * @ORM\Column(name="english_title", type="string", length=255, unique=true)
     */
    private $englishTitle;

    /**
     * englishDescription represent the english axe's description, it will be displayed on the axe page
     * 
     * @var string
     *
     * @ORM\Column(name="english_description", type="text")
     */
    private $englishDescription;
    
    /**
     * frenchDescription represent the french axe's description, it will be displayed on the axe page
     * 
     * @var string
     *
     * @ORM\Column(name="french_description", type="text")
     */
    private $frenchDescription;

    /**
     * frenchSummary represent the french axe's summary, it will be displayed on the axe's list
     * 
     * @var string
     *
     * @ORM\Column(name="french_summary", type="string", length=255)
     */
    private $frenchSummary;

    /**
     * englishSummary represent the english axe's summary, it will be displayed on the axe's list
     * 
     * @var string
     *
     * @ORM\Column(name="english_summary", type="string", length=255)
     */
    private $englishSummary;
    
    
    /**
     * projects represent all the projects in the axe
     * @var ArrayCollection 
     * @ORM\ManyToMany(targetEntity="Bdtln\ProjectBundle\Entity\Project")
     */
    private $projects;
    
    
    
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set frenchTitle
     *
     * @param string $frenchTitle
     *
     * @return Axe
     */
    public function setFrenchTitle($frenchTitle)
    {
        $this->frenchTitle = $frenchTitle;

        return $this;
    }

    /**
     * Get frenchTitle
     *
     * @return string
     */
    public function getFrenchTitle()
    {
        return $this->frenchTitle;
    }

    /**
     * Set englishTitle
     *
     * @param string $englishTitle
     *
     * @return Axe
     */
    public function setEnglishTitle($englishTitle)
    {
        $this->englishTitle = $englishTitle;

        return $this;
    }

    /**
     * Get englishTitle
     *
     * @return string
     */
    public function getEnglishTitle()
    {
        return $this->englishTitle;
    }

    /**
     * Set englishDescription
     *
     * @param string $englishDescription
     *
     * @return Axe
     */
    public function setEnglishDescription($englishDescription)
    {
        $this->englishDescription = $englishDescription;

        return $this;
    }

    /**
     * Get englishDescription
     *
     * @return string
     */
    public function getEnglishDescription()
    {
        return $this->englishDescription;
    }

    /**
     * Set frenchDescription
     *
     * @param string $frenchDescription
     *
     * @return Axe
     */
    public function setFrenchDescription($frenchDescription)
    {
        $this->frenchDescription = $frenchDescription;

        return $this;
    }

    /**
     * Get frenchDescription
     *
     * @return string
     */
    public function getFrenchDescription()
    {
        return $this->frenchDescription;
    }

    /**
     * Set frenchSummary
     *
     * @param string $frenchSummary
     *
     * @return Axe
     */
    public function setFrenchSummary($frenchSummary)
    {
        $this->frenchSummary = $frenchSummary;

        return $this;
    }

    /**
     * Get frenchSummary
     *
     * @return string
     */
    public function getFrenchSummary()
    {
        return $this->frenchSummary;
    }

    /**
     * Set englishSummary
     *
     * @param string $englishSummary
     *
     * @return Axe
     */
    public function setEnglishSummary($englishSummary)
    {
        $this->englishSummary = $englishSummary;

        return $this;
    }

    /**
     * Get englishSummary
     *
     * @return string
     */
    public function getEnglishSummary()
    {
        return $this->englishSummary;
    }

    
    
    
    
    
    
    
        /**
     * Constructor
     */
    public function __construct()
    {
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add project
     *
     * @param \Bdtln\ProjectBundle\Entity\Project $project
     *
     * @return Axe
     */
    public function addProject(\Bdtln\ProjectBundle\Entity\Project $project)
    {
        $this->projects[] = $project;

        return $this;
    }

    /**
     * Remove project
     *
     * @param \Bdtln\ProjectBundle\Entity\Projet $project
     */
    public function removeProject(\Bdtln\ProjectBundle\Entity\Projet $project)
    {
        $this->projects->removeElement($project);
    }

    /**
     * Get projects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjects()
    {
        return $this->projects;
    }
    
    
    /**
     * hasProject test is this axe own the project
     * @param \Bdtln\ProjectBundle\Entity\Project $project the project that we want test
     * @return boolean true if $project is in this axe
     */
    public function hasProject( \Bdtln\ProjectBundle\Entity\Project $project ) {
        $allProjects = $this->getProjects();
        
        for ( $i = 0; $i < count($allProjects); $i++ ) {
            if ( $allProjects[$i] == $project )
                return true;
        }
        return false;
    }
    
}
