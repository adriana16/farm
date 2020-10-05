<?php

namespace FarmBundle\Service;


use Doctrine\ORM\EntityManagerInterface;
use FarmBundle\Entity\Auction;
use FarmBundle\Entity\Bid;
use Predis\Client;
use Symfony\Component\Lock\Factory;
use Symfony\Component\Lock\Lock;
use Symfony\Component\Lock\Store\RedisStore;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuctionService
{
    private $em;
    private $validator;

    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator)
    {
        $this->em = $em;
        $this->validator = $validator;
    }

    /**
     * @param Auction $auction
     * @param Bid $bid
     *
     * @return Auction|null|array
     */
    public function bidOnAuction(Auction $auction, Bid $bid)
    {
        // Check if another bidder is not bidding in the same time
        $lock = $this->getLockOnAuction($auction);

        if (!$lock->acquire()) {

            return ['Your bid cannot be processed now. Try again later!'];
        }

        $errors = $this->validator->validate($bid);

        if (!empty($errors)) {
            $errorMessages = [];

            /** @var ConstraintViolation $error */
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }

            return $errorMessages;
        }

        // Save bid
        $bid->setCreatedAt(new \DateTime('now'));
        $this->em->persist($bid);
        $this->em->flush();

        $lock->release();

        return $auction;
    }

    /**
     * @param Auction $auction
     *
     * @return Lock
     */
    private function getLockOnAuction(Auction $auction)
    {
        $store = new RedisStore(new Client());
        $factory = new Factory($store);

        return $factory->createLock(sprintf("%s_%s", Auction::class, $auction->getId()));
    }
}