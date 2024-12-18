<?php

namespace App\DataFixtures;


use App\Factory\AuthorFactory;
use App\Factory\BookFactory;
use App\Factory\SupplierFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        AuthorFactory::createMany(25);

        BookFactory::createMany(40, function () {
            return['author'=> AuthorFactory::random()];
        });

        SupplierFactory::createMany(10, function () {
            return['books'=> BookFactory::randomRange(2, 10)];
        });

        $manager->flush();
    }
}
