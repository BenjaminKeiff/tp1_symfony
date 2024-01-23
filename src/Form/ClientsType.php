<?php

namespace App\Form;

use App\Entity\Clients;
use App\Entity\Organizations;
use App\Entity\Positions;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('mail')
            ->add('position', EntityType::class, [
                    'class' => Positions::class,
            ])
            ->add('organization', EntityType::class, [
                    'class' => Organizations::class,
                    'multiple' => false,
                    'choice_label' => 'name',
                    'expanded' => false,
                    'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Clients::class,
        ]);
    }
}
