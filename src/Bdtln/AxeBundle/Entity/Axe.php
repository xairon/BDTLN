<?php

namespace Bdtln\AxeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = "2",
     *      max = "255",
     *      minMessage = "The french title should be longer than {{ limit }} characters",
     *      maxMessage = "The french title not be longer than {{ limit }} characters")
     */
    private $frenchTitle;
    
    
    /**
     * englishTtitle represent the english title of the axe
     * @var string
     *
     * @ORM\Column(name="english_title", type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = "2",
     *      max = "255",
     *      minMessage = "The english title should be longer than {{ limit }} characters",
     *      maxMessage = "The english title should not be longer than {{ limit }} characters")
     */
    private $englishTitle;

    /**
     * englishDescription represent the english axe's description, it will be displayed on the axe page
     * 
     * @var string
     *
     * @ORM\Column(name="english_description", type="text")
     * @Assert\NotBlank()
     */
    private $englishDescription;
    
    /**
     * frenchDescription represent the french axe's description, it will be displayed on the axe page
     * 
     * @var string
     *
     * @ORM\Column(name="french_description", type="text")
     * @Assert\NotBlank()
     */
    private $frenchDescription;

    /**
     * frenchSummary represent the french axe's summary, it will be displayed on the axe's list
     * 
     * @var string
     *
     * @ORM\Column(name="french_summary", type="string", length=255)
     * @Assert\Length(
     *      min = "20",
     *      max = "255",
     *      minMessage = "The french summary should be longer than {{ limit }} characters",
     *      maxMessage = "The french summary should not be longer than {{ limit }} characters")
     */
    private $frenchSummary;

    /**
     * englishSummary represent the english axe's summary, it will be displayed on the axe's list
     * 
     * @var string
     *
     * @ORM\Column(name="english_summary", type="string", length=255)
     * @Assert\Length(
     *      min = "20",
     *      max = "255",
     *      minMessage = "The english summary should be longer than {{ limit }} characters",
     *      maxMessage = "The english summary not be longer than {{ limit }} characters")
     */
    private $englishSummary;
    
    
    /**
     * projects represent all the projects in the axe
     * @var ArrayCollection 
     * @ORM\ManyToMany(targetEntity="Bdtln\ProjectBundle\Entity\Project", cascade={"remove"})
     */
    private $projects;
    
    /**
     * slug represent the slug of the axe
     * @var string 
     * @Gedmo\Slug(fields={"englishTitle"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;
    
    
    
    /**
     * managers represent all the managers of the axe
     *@ORM\ManyToMany(targetEntity="Bdtln\UserBundle\Entity\User")
     * @ORM\JoinTable(name="axe_manager",
     *       joinColumns={@ORM\JoinColumn(name="axe", referencedColumnName="id")},
     *       inverseJoinColumns={@ORM\JoinColumn(name="user", referencedColumnName="id")})
     */
    private $managers;
    
    
    
    
    
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
    public function removeProject(\Bdtln\ProjectBundle\Entity\Project $project)
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
    

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Axe
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add manager
     *
     * @param \Bdtln\UserBundle\Entity\User $manager
     *
     * @return Axe
     */
    public function addManager(\Bdtln\UserBundle\Entity\User $manager)
    {
        $this->managers[] = $manager;

        return $this;
    }

    /**
     * Remove manager
     *
     * @param \Bdtln\UserBundle\Entity\User $manager
     */
    public function removeManager(\Bdtln\UserBundle\Entity\User $manager)
    {
        $this->managers->removeElement($manager);
    }

    /**
     * Get managers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getManagers()
    {
        return $this->managers;
    }
}
