<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Enum\GenreEnum;
use App\Factory\BookFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $book = new Book();
        $book->setTitle("Das erste Buch");
        $book->setAuthor("Joe");
        $book->setPages(200);
        $book->setPublisher("Westermann");
        $book->setPublisherEmail("westermann@web.de");
        $book->setPublishedAt(new \DateTime("now"));
        $book->setGenre([GenreEnum::Crime]);


        BookFactory::createMany(100);

        $manager->persist($book);
        $manager->flush();
    }
}
