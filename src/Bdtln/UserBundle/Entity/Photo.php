<?php

namespace Bdtln\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Photo
 *
 * @ORM\Table(name="photo")
 * @ORM\Entity(repositoryClass="Bdtln\UserBundle\Entity\PhotoRepository")
 */
class Photo
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
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;
    
    /**
     *
     * @var File 
     * @Assert\Image()
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
     * Set alt
     *
     * @param string $alt
     *
     * @return Photo
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Photo
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
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
     * upload upload a profile photo onto server
     * @param type $firstName the owner firstname
     * @param type $lastName the owner lastname
     * @param $photoName the name of photo
     */
    public function upload( $firstName, $lastName, $photoName= null )
    {
        //If there is no file
        if ($this->file === null)
            return;
        
        $this->url = ($photoName == null) ? time() : $photoName;
        $this->alt = $firstName. " ".$lastName;
        $this->file->move($this->getUploadRootDir(), $this->url);        
    }
    
    /**
     * getUploadDir give the path to photo directory
     * @return string path for browser to photos
     */
    public function getUploadDir() {
        return 'uploads/photos';
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
        if ( $this->url != null )
            unlink($this->getUploadRootDir().'/'.$this->url);
    }
    
}

