<?php

namespace FarmBundle\Form;

use Doctrine\ORM\EntityManagerInterface;
use FarmBundle\Entity\Auction;
use FarmBundle\Entity\Bid;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class BidType extends AbstractType
{
    private $bidRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->bidRepository = $em->getRepository(Bid::class);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Auction $auction */
        $auction = $options['auction'];
        $lastBid = $this->bidRepository->getLastBidForAuction($auction);
        $startingAmount = $lastBid
            ? $lastBid->getAmount() + $auction->getStep()
            : $auction->getPrice()
        ;

        $builder
            ->add('amount', IntegerType::class, [
                'attr' => [
                    'min' => $startingAmount,
                    'step' => $auction->getStep(),
                ],
                'data' => $startingAmount,
                'constraints' => [
                    new Assert\NotNull(),
                ]
            ])
//            ->add('save', SubmitType::class, [
//                'label' => 'Bid',
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'auction' => Auction::class,
            'data_class' => Bid::class,
        ]);
    }
}
