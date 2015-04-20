<?php

namespace Bdtln\ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * File
 *
 * @ORM\Table(name="file")
 * @ORM\Entity(repositoryClass="Bdtln\ProjectBundle\Entity\FileRepository")
 */
class File
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
     * path represennt the path of the file on the server
     * 
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, unique=true)
     */
    private $path;

    /**
     * title represent the file title
     * 
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    
    /**
     * project represent the project it belong to
     * 
     * @var Project 
     * 
     * @ORM\ManyToOne(targetEntity="Bdtln\ProjectBundle\Entity\Project", inversedBy="files")
     * @ORM\JoinColumn(nullable=false);
     */
    private $project;
    
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
     * Set path
     *
     * @param string $path
     *
     * @return File
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return File
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    
    /**
     * getProject get the project the file belong to
     * @return \Bdtln\ProjectBundle\Entity\Project
     */
    public function getProject() {
        return $this->project;
    }
    
    /**
     * setProject set the project the file belong to
     * @param \Bdtln\ProjectBundle\Entity\Project $project
     * @return \Bdtln\ProjectBundle\Entity\File $this
     */
    public function setProject(\Bdtln\ProjectBundle\Entity\Project $project) {
        $this->project = $project;
        return $this;
    }
    
    
}

