<?php

namespace Bdtln\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="Bdtln\UserBundle\Entity\CategoryRepository")
 */
class Category
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
     * @ORM\Column(name="frenchTitle", type="string", length=255)
     * @Assert\Length(
     *      min = "2",
     *      max = "80",
     *      minMessage = "The french title should be longer than {{ limit }} characters",
     *      maxMessage = "The french title should not be longer than {{ limit }} characters"
     * )
     */
    private $frenchTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="englishTitle", type="string", length=255)
     * @Assert\Length(
     *      min = "2",
     *      max = "80",
     *      minMessage = "The english title should be longer than {{ limit }} characters",
     *      maxMessage = "The english title should not be longer than {{ limit }} characters"
     * )
     */
    private $englishTitle;


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
     * @return Category
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
     * @return Category
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
}

