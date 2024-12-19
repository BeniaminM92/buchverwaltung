<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Supplier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupplierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)

            ->add('address', TextType::class)

            ->add('email', EmailType::class)

            ->add('books', EntityType::class, [
                'class' => Book::class,
                'choice_label' => 'id',
                'multiple' => true,
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
            'data_class' => Supplier::class,
        ]);
    }
}
