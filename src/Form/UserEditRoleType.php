<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserEditRoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('enabled', null, [
                'label' => "L'utilisateur est-il activé ?"
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    "Rédacteur" => "ROLE_REDACTEUR",
                    "Modérateur" => "ROLE_MODERATEUR",
                    "Adminstrateur" => "ROLE_ADMIN"
                ],
                "multiple" => true,
                "expanded" => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
