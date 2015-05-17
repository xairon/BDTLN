<?php

namespace Bdtln\ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AttachedFile
 *
 * @ORM\Table(name="attached_file")
 * @ORM\Entity(repositoryClass="Bdtln\ProjectBundle\Entity\AttachedFileRepository")
 */
class AttachedFile
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
     *
     * @var File
     * @Assert\File(
     * mimeTypes={"application/zip", "application/octet-stream", "application/x-rar-compressed", "application/x-gzip"},
     * mimeTypesMessage = "Only zip, rar, gz granted"
     * )
     */
    private $file;
    
    
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
    
    
        public function getFile()
    {
        return $this->file;
    }
    
    
    public function setFile( File $file ) {
        $this->file = $file;
        return $this;
    }
    
    
    
    /**
     * upload upload a file onto server
     * 
     */
    public function upload($title)
    {
        //If there is no file
        if ($this->file === null)
            return;
        
        $extension = $this->file->guessExtension();
        if ( !$extension )
            $extension = '.bin';
        
        $this->path = time().'.'.$extension;
        $this->title = $title;
        $this->file->move($this->getUploadRootDir(), $this->path);        
    }
    
    /**
     * getUploadDir give the path to photo directory
     * @return string path for browser to photos
     */
    public function getUploadDir() {
        return 'uploads/attached_files';
    }
    
    /**
     * getUploadRootDir five the path to photo directory
     * @return string path for our code to photos
     */
    public function getUploadRootDir() {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
    
    /**
     * deleteFile delete a file
     * @param string $url url of file
     */
    public function deleteFile() {
        if ( $this->path != null )
            unlink($this->getUploadRootDir().'/'.$this->path);
    }
    
    
}

