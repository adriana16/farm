<?php

namespace FarmBundle\Form;

use FarmBundle\Entity\Auction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use FarmBundle\Validator\Constraints as CustomValidator;

class AuctionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price', NumberType::class, [
                'label' => 'Price',
                'required' => true,
                'constraints' => [
                    new Assert\NotNull(),
                ]
            ])
            ->add('buyOutPrice', NumberType::class, [
                'label' => 'Buy out price',
                'required' => true,
                'constraints' => [
                    new Assert\NotNull(),
                ]
            ])
            ->add('step', NumberType::class, [
                'label' => 'Auction step',
                'required' => true,
                'constraints' => [
                    new Assert\NotNull(),
                ]
            ])
            ->add('startDate', TextType::class, [
                'label' => 'Start Date',
                'required' => false,
                'attr' => [
                    'class' => 'form-control datepicker',
                ]
            ])
            ->add('endDate', TextType::class, [
                'label' => 'End Date',
                'required' => false,
                'attr' => [
                    'class' => 'form-control datepicker',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Auction::class,
            'constraints' => [
                new CustomValidator\Price(),
                new CustomValidator\Date(),
            ],
        ]);
    }
}
