<?php

namespace App\Form;

use App\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthorFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fname', TextType::class)

            ->add('lname', TextType::class)

            ->add('birthdate', BirthdayType::class, [
                'widget' => 'single_text',
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
            'data_class' => Author::class,
        ]);
    }
}
