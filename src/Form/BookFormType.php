<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Supplier;
use App\Enum\GenreEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)

            ->add('author', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'fullName',])

            ->add('genre', EnumType::class, ['class' => GenreEnum::class,
                'expanded' => true,
                'multiple' => true
            ])

            ->add('pages', IntegerType::class)

            ->add('publisher', TextType::class)

            ->add('publisherEmail', EmailType::class)

            ->add('publishedAt', DateType::class, [
                'widget' => 'single_text',
            ])

            ->add('suppliers', EntityType::class, [
                'class' => Supplier::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
                'by_reference' => false,
            ])

            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success d-flex justify-content-end',
                ],
                'label' => '<i class="fa-solid fa-save me-2"></i> Speichern',
                'label_html' => true,
            ])

            ->add('reset', ResetType::class, [
                'attr' => [
                    'class' => 'btn btn-success d-flex justify-content-end',
                ],
                'label' => '<i class="fa-solid fa-undo me-2"></i> Zurücksetzen',
                'label_html' => true,
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'book_item',
        ]);
    }
}
