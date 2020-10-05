<?php

namespace FarmBundle\Validator\Constraints;

use Doctrine\ORM\EntityManagerInterface;
use FarmBundle\Entity\Auction;
use FarmBundle\Repository\BidRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class BidValidator extends ConstraintValidator
{
    /** @var BidRepository  */
    private $bidRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->bidRepository = $em->getRepository(\FarmBundle\Entity\Bid::class);
    }

    /**
     * @param \FarmBundle\Entity\Bid $bid
     * @param Constraint $constraint
     */
    public function validate($bid, Constraint $constraint)
    {
        $auction = $bid->getAuction();
        $lastBid = $this->bidRepository->getLastBidForAuction($auction);
        $lastBidAmount = $lastBid ? $lastBid->getAmount() : $auction->getPrice();

        if ($bid->getAmount() <= $lastBidAmount) {
            $this->context->buildViolation($constraint->amountMessage)
                ->setTranslationDomain('messages')
                ->setParameter('{{ value }}', $lastBidAmount)
                ->atPath("amount")
                ->addViolation();
        }

        if ($auction->getEndDate() < new \DateTime('now') || $auction->getStatus() !== Auction::STATUS_OPEN) {
            $this->context->buildViolation($constraint->expiredMessage)
                ->setTranslationDomain('messages')
                ->atPath("amount")
                ->addViolation();
        }
    }
}