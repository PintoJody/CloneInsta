<?php

namespace App\Form;

use App\Entity\Posts;
use phpDocumentor\Reflection\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class PostsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('posts_picture', FileType::class, [
                'label' => 'Déposer l\'image',
                'multiple' => false,
                'mapped' => false,
                'required' => true,
            ])
            ->add('posts_place')
            ->add('posts_describe')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Posts::class,
        ]);
    }
}
