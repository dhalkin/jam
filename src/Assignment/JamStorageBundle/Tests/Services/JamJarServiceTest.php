<?php

namespace Assignment\JamStorageBundle\Tests\Services;

use Assignment\JamStorageBundle\Services\JamJarService;

/**
 * Class JamJarServiceTest
 *
 * @group unit
 */
class JamJarServiceTest extends \PHPUnit_Framework_TestCase
{
    const TEST_COUNT = 5;

    private $entityManagerMock;

    public function setUp()
    {
        $this->entityManagerMock =
            $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
    }


    public function testCreateAdditional()
    {
        $jamJar = $this->getMock('\Assignment\JamStorageBundle\Entity\JamJar');
        $this->entityManagerMock->expects($this->exactly(self::TEST_COUNT))
            ->method('persist')
            // todo: equalTo doesn't give you garantee about real cloning.
            // e.g. you can pass same object here w/o any errors see service class
            ->with($this->equalTo($jamJar))
            ->will($this->returnValue(true));

        $this->entityManagerMock->expects($this->once())
            ->method('flush')
            ->will($this->returnValue(true));

        $jamJarService = new JamJarService($this->entityManagerMock);
        $jamJarService->createAdditional($jamJar, self::TEST_COUNT);
    }
}
