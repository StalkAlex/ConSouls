<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 12.08.2017
 * Time: 15:21
 */

namespace RPGBundle\Service;


use Doctrine\ORM\EntityManager;
use RPGBundle\Entity\Profile;

class ProfileService
{
    private $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
        $this->validator = $this->get('validator');
    }

    public function createProfile(string $name, string $heroName)
    {
        $newProfile = new Profile();
        $newProfile->setName($name);
//        $newProfile->setHero(get_class($hero));
        $this->manager->persist($newProfile);
        $this->manager->flush();
    }

}