<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 11.08.2017
 * Time: 20:32
 */

namespace RPGBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Entity(repositoryClass="RPGBundle\Repository\GameRepository")
 * @ORM\Table(name="game")
 */
class Game
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Profile", inversedBy="games")
     */
    public $profile;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

}