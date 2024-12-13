<?php

namespace App\Form;

use App\Entity\Book;
use App\Enum\GenreEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)

            ->add('author', TextType::class)

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

//            ->add('save', SubmitType::class)
//
//            ->add('reset', ResetType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
