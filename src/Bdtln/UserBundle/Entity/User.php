<?php

namespace Bdtln\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Bdtln\UserBundle\Entity\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     *
     * @var string
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $firstName;

    /**
     *
     * @var string
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $lastName;
    
    /**
     *
     * @var string
     * @ORM\Column(name="french_biography", type="string", length=255)
     */
    private $frenchBiography;
    
    
    /**
     *
     * @var string
     * @ORM\Column(name="english_biography", type="string", length=255)
     */
    private $englishBiography;
    
    
    
    /**
     *
     * @var DateTime
     * @ORM\Column(name="date_register", type="date")
     */
    private $dateRegister;

    /**
     *
     * @var DateTime
     * @ORM\Column(name="date_leaving", type="date", nullable=true)
     */
    private $dateLeaving;
    

    
    
    public function __construct() {
        parent::__construct();
        $this->dateRegister = new \DateTime();
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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set franch biography
     *
     * @param string $frenchBiography
     *
     * @return User
     */
    public function setFrenchBiography($frenchBiography)
    {
        $this->frenchBiography = $frenchBiography;

        return $this;
    }

    /**
     * Get french biography
     *
     * @return string
     */
    public function getFrenchBiography()
    {
        return $this->frenchBiography;
    }
    
    /**
     * Set franch biography
     *
     * @param string $frenchBiography
     *
     * @return User
     */
    public function setEnglishBiography($englishBiography)
    {
        $this->englishBiography = $englishBiography;

        return $this;
    }

    /**
     * Get english biography
     *
     * @return string
     */
    public function getEnglishBiography()
    {
        return $this->englishBiography;
    }

    /**
     * Set dateRegister
     *
     * @param \DateTime $dateRegister
     *
     * @return User
     */
    public function setDateRegister($dateRegister)
    {
        $this->dateRegister = $dateRegister;

        return $this;
    }

    /**
     * Get dateRegister
     *
     * @return \DateTime
     */
    public function getDateRegister()
    {
        return $this->dateRegister;
    }
    
    
    
    
    
    
    /**
     * Set dateLeaving
     *
     * @param \DateTime $dateLeaving
     *
     * @return User
     */
    public function setDateLeaving($dateLeaving)
    {
        $this->dateLeaving = $dateLeaving;

        return $this;
    }

    /**
     * Get dateLeaving
     *
     * @return \DateTime
     */
    public function getDateLeaving()
    {
        return $this->dateLeaving;
    }
    
    
    
    
    
}
