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
        for ($i = 0; $i <= $amount; $i++) { // todo: wrong modification to check travis-ci integration
            $addingJamJar = clone $jamJar;
            // todo: in tests you are testing number of persist calls but not cloning
            // you can create separate clone service to test this also
            $this->entityManager->persist($addingJamJar);
        }

        $this->entityManager->flush();
    }
}
