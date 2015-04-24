<?php

namespace Bdtln\ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="Bdtln\ProjectBundle\Entity\ProjectRepository")
 */
class Project
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
     * frenchTitle represent the french title of the project
     * @var string
     *
     * @ORM\Column(name="french_title", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = "2",
     *      max = "255",
     *      minMessage = "The french title should be longer than {{ limit }} characters",
     *      maxMessage = "The french title not be longer than {{ limit }} characters"
     * )
     */
    private $frenchTitle;

    /**
     * englishTitle represent the english title of the project
     * @var string
     *
     * @ORM\Column(name="english_title", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = "2",
     *      max = "255",
     *      minMessage = "The englih title should be longer than {{ limit }} characters",
     *      maxMessage = "The english title not be longer than {{ limit }} characters"
     * )
     */
    private $englishTitle;



    /**
     * frenchSummary is a french summary of project, it will be displayed in a list for example
     * @var string
     *
     * @ORM\Column(name="french_summary", type="string", length=255)
     * @Assert\Length(
     *      min = "20",
     *      max = "255",
     *      minMessage = "The french summary should be longer than {{ limit }} characters",
     *      maxMessage = "The french summary not be longer than {{ limit }} characters"
     * )
     */
    private $frenchSummary;

    
    /**
     * englishSummary is an english summary of project, it will be displayed in a list for example
     * @var string
     *
     * @ORM\Column(name="english_summary", type="string", length=255)
     * @Assert\Length(
     *      min = "20",
     *      max = "255",
     *      minMessage = "The english summary should be longer than {{ limit }} characters",
     *      maxMessage = "The english summary not be longer than {{ limit }} characters"
     * )
     */
    private $englishSummary;
    
    
    
    /**
     * frenchDescription represent the french description of the project, it will be displayed on the
     * page project
     * @var string
     *
     * @ORM\Column(name="french_description", type="text")
     */
    private $frenchDescription;
    
    /**
     * englishDescription represent the english description of the project, it will be displayed on the
     * page project
     * @var string
     *
     * @ORM\Column(name="english_description", type="text")
     */
    private $englishDescription;

    /**
     * beginningDate represent the date of beginning of the project
     * @var \DateTime
     *
     * @ORM\Column(name="beginning_date", type="date")
     * @Assert\DateTime()
     */
    private $beginningDate;

    /**
     * endingDate represent the date of ending of the project
     * @var \DateTime
     *
     * @ORM\Column(name="ending_date", type="date", nullable=true)
     * @Assert\DateTime()
     */
    private $endingDate;

    /**
     * files represent all the files linked to the project
     * 
     * @var ArrayCollection 
     * 
     * @ORM\OneToMany(targetEntity="Bdtln\ProjectBundle\Entity\File", mappedBy="project", cascade={"persist", "remove"})
     */
    private $files;
    
    /**
     * slug represent the sluf of a project, it will be displayed in the URL
     * 
     * @var string
     * 
     * @Gedmo\Slug(fields={"englishTitle"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;
    
    /**
     * axes represent the axes to whome belong to the project
     * @var ArrayCollection 
     * @ORM\ManyToMany(targetEntity="Bdtln\AxeBundle\Entity\Axe")
     */
    private $axes;
    
    
    public function __construct() {
        $this->beginningDate = new \DateTime();
    }

    
    
    
    
    
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
     * Set beginningDate
     *
     * @param \DateTime $beginningDate
     *
     * @return Project
     */
    public function setBeginningDate($beginningDate)
    {
        $this->beginningDate = $beginningDate;

        return $this;
    }

    /**
     * Get beginningDate
     *
     * @return \DateTime
     */
    public function getBeginningDate()
    {
        return $this->beginningDate;
    }

    /**
     * Set endingDate
     *
     * @param \DateTime $endingDate
     *
     * @return Project
     */
    public function setEndingDate($endingDate)
    {
        $this->endingDate = $endingDate;

        return $this;
    }

    /**
     * Get endingDate
     *
     * @return \DateTime
     */
    public function getEndingDate()
    {
        return $this->endingDate;
    }
    
    

    /**
     * Set frenchSummary
     *
     * @param string $frenchSummary
     *
     * @return Project
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
     * @return Project
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
     * Set frenchDescription
     *
     * @param string $frenchDescription
     *
     * @return Project
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
     * Set englishDescription
     *
     * @param string $englishDescription
     *
     * @return Project
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
     * Add file
     *
     * @param \Bdtln\ProjectBundle\Entity\File $file
     *
     * @return Project
     */
    public function addFile(\Bdtln\ProjectBundle\Entity\File $file)
    {
        $this->files[] = $file;
        $file->setProject($this);

        return $this;
    }

    /**
     * Remove file
     *
     * @param \Bdtln\ProjectBundle\Entity\File $file
     */
    public function removeFile(\Bdtln\ProjectBundle\Entity\File $file)
    {
        $this->files->removeElement($file);
    }

    /**
     * Get files
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Set frenchTitle
     *
     * @param string $frenchTitle
     *
     * @return Project
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
     * @return Project
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Project
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
     * Add axe
     *
     * @param \Bdtln\AxeBundle\Entity\Axe $axe
     *
     * @return Axe
     */
    public function addAxe(\Bdtln\AxeBundle\Entity\Axe $axe)
    {
        $this->axes[] = $axe;

        return $this;
    }

    /**
     * Remove axe
     *
     * @param \Bdtln\AxeBundle\Entity\Axe $axe
     */
    public function removeAxe(\Bdtln\AxeBundle\Entity\Axe $axe)
    {
        $this->axes->removeElement($axe);
    }

    /**
     * Get axes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAxes()
    {

        
        
        
        
        return $this->axes;
    }
    
    
    
    
    
    
    
    
}
