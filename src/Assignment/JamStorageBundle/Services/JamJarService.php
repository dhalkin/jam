<?php

namespace Assignment\JamStorageBundle\Services;

use Doctrine\ORM\EntityManager;
use Assignment\JamStorageBundle\Entity\JamJar;

class JamJarService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @param JamJar $jamJar
     * @param $amount
     */
    public function createAdditional(JamJar $jamJar, $amount)
    {
        $amount = (int) $amount;
        for ($i = 0; $i < $amount; $i++) {
            $addingJamJar = clone $jamJar;
            $this->entityManager->persist($addingJamJar);
        }

        $this->entityManager->flush();
    }
}
