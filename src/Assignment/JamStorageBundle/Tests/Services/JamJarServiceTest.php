<?php

namespace Assignment\JamStorageBundle\Tests\Services;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Assignment\JamStorageBundle\Services\JamJarService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Assignment\JamStorageBundle\Entity\JamJar;


/**
 * Class JamJarServiceTest
 *
 * @group unit
 */
class JamJarServiceTest extends WebTestCase
{

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var JamJarService
     */
    private $jamJarService;

    /**
     * @var EntityRepository
     */
    private $jamJarRepository;

    /**
     * @var currentCount
     */
    private $currentCount;

    public function setUp()
    {
        $client = self::createClient();
        $container = $client->getContainer();

        $this->jamJarService = $container->get('jam_jar');
        $this->entityManager = $container->get('doctrine')->getManager();
        $this->jamJarRepository = $this->entityManager->getRepository('AssignmentJamStorageBundle:JamJar');
        $this->entityManager->beginTransaction();
        $this->currentCount = count($this->jamJarRepository->findAll());
    }

    public function successProvider()
    {
        return [
            [1],
            [2]
        ];
    }

    /**
     * @dataProvider successProvider
     */
    public function testCreateAdditionalSuccess($amount)
    {
        $this->jamJarService->createAdditional($this->createNewJamJar(), $amount);

        $this->assertEquals(
            $this->currentCount + $amount,
            count($this->jamJarRepository->findAll())
        );
    }

    public function failProvider()
    {
        return [
            [-1],
            [null],
            [''],
            [0]
        ];
    }

    /**
     * @dataProvider failProvider
     */
    public function testCloneJamsFail($amount)
    {

        $this->jamJarService->createAdditional($this->createNewJamJar(), $amount);

        $this->assertEquals(
            $this->currentCount,
            count($this->jamJarRepository->findAll())
        );
    }


    public function createNewJamJar()
    {
        $jamJar = new JamJar();
        $jamType = $this->entityManager->getRepository('AssignmentJamStorageBundle:JamType')->findOneByName('Apricot');
        $year = $this->entityManager->getRepository('AssignmentJamStorageBundle:Year')->findOneByName('2013');

        $jamJar->setType($jamType);
        $jamJar->setYear($year);
        $jamJar->setComment('test comment');

        return $jamJar;
    }

    public function tearDown()
    {
        $this->entityManager->rollback();
    }
}
