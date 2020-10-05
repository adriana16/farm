<?php

namespace FarmBundle\Form;

use FarmBundle\Entity\BoxProduct;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class BoxProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label'    => 'Product Name',
                'required' => true,
                'constraints' => [
                    new Assert\NotNull()
                ]
            ])
            ->add('quantity', IntegerType::class, [
                'required' => true,
                'label'    => 'Quantity',
                'constraints' => [
                    new Assert\NotNull()
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BoxProduct::class,
        ]);
    }
}
