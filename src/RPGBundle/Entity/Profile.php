<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 11.08.2017
 * Time: 20:32
 */

namespace RPGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use RPGBundle\Entity\Creature\Hero;

/**
 * Profile
 *
 * @ORM\Entity(repositoryClass="RPGBundle\Repository\ProfileRepository")
 * @ORM\Table(name="user")
 */
class Profile
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string")
     */
    private $name;


    /**
     * @ORM\Column(name="experience", type="integer")
     */
    private $experience;

    /**
     * @ORM\Column(name="level", type="integer")
     */
    private $level;

    /**
     * @ORM\Column(name="hero", type="string")
     */
    private $hero;

    /**
     * @ORM\OneToMany(targetEntity="Game", mappedBy="user")
     */
    private $games;

    public function __construct()
    {
        $this->games = new ArrayCollection();
        $this->level = 1;
        $this->experience = 0;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return ArrayCollection
     */
    public function getGames()
    {
        return $this->games;
    }

    /**
     * @return string
     */
    public function getHeroName()
    {
        return $this->hero;
    }

    /**
     * @param string $hero
     */
    public function setHeroName($hero)
    {
        $this->hero = $hero;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param mixed $experience
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;
    }

    /**
     * @param mixed $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }


}