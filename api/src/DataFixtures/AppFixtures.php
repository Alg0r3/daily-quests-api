<?php

namespace App\DataFixtures;

use App\Factory\ApiUserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ApiUserFactory::createOne(['password' => '1234']);
    }
}
