<?php

namespace Assignment\JamStorageBundle\DataFixtures\ORM;

use Hautelook\AliceBundle\Alice\DataFixtureLoader;
use Nelmio\Alice\Fixtures;

class JamStorageLoader extends DataFixtureLoader
{
    /**
     * {@inheritDoc}
     */
    protected function getFixtures()
    {
        return  array(
            __DIR__ . '/jam.yml',

        );
    }

    public function jamName()
    {
        $names = array(
            'Apricot', 'Raspberries', 'Cherry-plum'
        );

        return $names[array_rand($names)];
    }
}
