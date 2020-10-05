<?php

namespace FarmBundle\Form;

use FarmBundle\Entity\Box;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class BoxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices'  => Box::TYPE_ARR,
                'required' => true,
                'label'    => 'Box type',
            ])
            ->add('boxProducts', CollectionType::class, [
                'entry_type' => BoxProductType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
                'constraints' => [
                    new Assert\Count([
                        'min' => 1,
                        'minMessage' => 'You must specify at least product!',
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Box::class,
        ]);
    }
}
