<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ['label'=>"titre de l'article"])
            ->add('description')
            ->add('image', null, ['label' =>"source de l'image(futur upload"])
            ->add('imageAtl', null, ['label'=>"description de l'image (SEO)"])
            ->add('ispublished',null, ['label'=>"l'article doit-il etre publié"])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
