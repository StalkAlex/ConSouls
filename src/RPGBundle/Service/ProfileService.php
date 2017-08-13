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
use Symfony\Component\Validator\Validator\RecursiveValidator;

class ProfileService
{
    private $manager;
    private $validator;

    public function __construct(EntityManager $manager, RecursiveValidator $validator)
    {
        $this->manager = $manager;
        $this->validator = $validator;
    }

    public function createProfile(string $name, string $heroName)
    {
        $newProfile = new Profile();
        $newProfile->setName($name);
        $newProfile->setHeroName($heroName);

        $errors = $this->validator->validate($newProfile);
        if (count($errors)) {
            var_dump($errors);
        }
        $this->manager->persist($newProfile);
        $this->manager->flush();
    }

    public function getProfiles(): array
    {
        return $this->manager->getRepository('RPGBundle:Profile')->findAll();
    }

    public function getProfile(string $name)
    {
        return $this->manager->getRepository('RPGBundle:Profile')->findOneBy(['name' => $name]);
    }

}