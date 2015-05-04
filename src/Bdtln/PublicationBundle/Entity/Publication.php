<?php

namespace Bdtln\PublicationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Publication
 *
 * @ORM\Table(name="publication")
 * @ORM\Entity(repositoryClass="Bdtln\PublicationBundle\Entity\PublicationRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Publication
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_publication", type="datetime")
     */
    private $datePublication;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_last_update", type="datetime", nullable=true)
     */
    private $dateLastUpdate;
    
    
    /**
     * The person who post the publication
     * 
     * @var \Bdtln\UserBundle\Entity\User
     * 
     * @ORM\ManyToOne(targetEntity="Bdtln\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;


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
     * Set title
     *
     * @param string $title
     *
     * @return Publication
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
     * Set content
     *
     * @param string $content
     *
     * @return Publication
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set datePublication
     *
     * @param \DateTime $datePublication
     *
     * @return Publication
     */
    public function setDatePublication(\DateTime $datePublication)
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    /**
     * Get datePublication
     *
     * @return \DateTime
     */
    public function getDatePublication()
    {
        return $this->datePublication;
    }

    /**
     * Set owner
     *
     * @param \Bdtln\UserBundle\Entity\User $owner
     *
     * @return Publication
     */
    public function setOwner(\Bdtln\UserBundle\Entity\User $owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \Bdtln\UserBundle\Entity\User
     */
    public function getOwner()
    {
        return $this->owner;
    }
   
    
   /**
     * Set dateLastUpdate
     *
     * @param \DateTime $dateLastUpdate
     *
     * @return Publication
     */
    public function setDateLastUpdate($dateLastUpdate)
    {
        $this->dateLastUpdate = $dateLastUpdate;

        return $this;
    }

    /**
     * Get dateLastUpdate
     *
     * @return \DateTime
     */
    public function getDateLastUpdate()
    {
        return $this->dateLastUpdate;
    }
    
    
    /**
     * preInsert set the date of publication before insertion
     * @ORM\PrePersist()
     */
    public function preInsert() {
        $this->datePublication = new \DateTime();
    }
    
    /**
     * preUpdate set the date of last update before update
     * @ORM\PreUpdate()
     */
    public function preUpdate() {
        $this->dateLastUpdate = new \DateTime();
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
