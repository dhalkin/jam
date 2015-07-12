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
        // todo: it's better to use random element right in yml file, no need to create custom functions
        $names = array(
            'Apricot', 'Raspberries', 'Cherry-plum'
        );

        return $names[array_rand($names)];
    }
}
