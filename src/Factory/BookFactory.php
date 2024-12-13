<?php

namespace App\Factory;

use App\Entity\Book;
use App\Enum\GenreEnum;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Book>
 */
final class BookFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Book::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'author' => self::faker()->name(),
            'genre' => self::faker()->randomElements(GenreEnum::cases(), self::faker()->numberBetween(1,4)),
            'pages' => self::faker()->numberBetween(100, 1500),
            'publishedAt' => self::faker()->dateTimeBetween('-100 years', '-1 years'),
            'publisher' => self::faker()->company(),
//            'publisherEmail' => self::faker()->companyEmail(),
            'title' => self::faker()->unique()->name(),
            'publisherEmail' => "",
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this->afterInstantiate(function(Book $book): void {
            $pname = str_replace(" ",'', $book->getPublisher()[0]);

            $book->setPublisherEmail(self::faker()->lastName().'@'.$pname.'.'.self::faker()->tld());
        })
        ;
    }
}
