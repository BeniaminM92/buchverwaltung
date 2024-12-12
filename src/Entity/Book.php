<?php

namespace App\Entity;

use App\Enum\GenreEnum;
use App\Repository\BookRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[UniqueEntity("title", message: "Den Titel {{ value }} gibt es bereits!")]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank(message: 'Das darf nicht leer sein')]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[ORM\Column]
    private ?int $pages = null;

    #[ORM\Column(length: 255)]
    private ?string $publisher = null;

    #[ORM\Column(length: 255)]
    private ?string $publisherEmail = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $publishedAt = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, enumType: GenreEnum::class)]
    private array $genre = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getPages(): ?int
    {
        return $this->pages;
    }

    public function setPages(int $pages): static
    {
        $this->pages = $pages;

        return $this;
    }

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(string $publisher): static
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getPublisherEmail(): ?string
    {
        return $this->publisherEmail;
    }

    public function setPublisherEmail(string $publisherEmail): static
    {
        $this->publisherEmail = $publisherEmail;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt): static
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * @return GenreEnum[]
     */
    public function getGenre(): array
    {
        return $this->genre;
    }

    public function setGenre(array $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    // Date oder Ähnliche Typen als String ausgeben
//    public function getPublishedAtString(): string
//    {
//        $string = $this->getPublishedAt();
//        $string->format('YYYY-MM-DD');
//        return $string;
//    }

    public function getPublishedAtString(): string
    {
        // Ensure the date is not null and properly formatted
        $publishedAt = $this->getPublishedAt();
        if ($publishedAt instanceof \DateTimeInterface) {
            return $publishedAt->format('Y-m-d'); // Correct PHP date format for 'YYYY-MM-DD'
        }
        // Return an empty string or throw an exception if $publishedAt is null
        return '';
    }

}
