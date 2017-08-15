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
use RPGBundle\Exception\AbsentProfileException;
use Symfony\Component\Validator\Validator\RecursiveValidator;

/**
 * Class ProfileService
 */
class ProfileService
{
    private $manager;
    private $validator;

    /**
     * ProfileService constructor.
     *
     * @param EntityManager      $manager
     * @param RecursiveValidator $validator
     */
    public function __construct(EntityManager $manager, RecursiveValidator $validator)
    {
        $this->manager = $manager;
        $this->validator = $validator;
    }

    /**
     * Creates new profile with initial values.
     *
     * @param string $name
     * @param string $heroName
     *
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
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

    /**
     * Returns all profiles from storage.
     *
     * @return array
     */
    public function getProfiles(): array
    {
        $profiles = $this->manager->getRepository('RPGBundle:Profile')->findAll();
        if (!$profiles) {
            return [];
        }

        return $profiles;
    }

    /**
     * Get profile instance by its name from storage
     *
     * @param string $name
     *
     * @return Profile
     *
     * @throws AbsentProfileException
     */
    public function getProfile(string $name)
    {
        $profile = $this->manager->getRepository('RPGBundle:Profile')->findOneBy(['name' => $name]);
        if (!$profile) {
            throw new AbsentProfileException(sprintf('There is no profile with this name %s', $name));
        }

        return $profile;
    }
}
