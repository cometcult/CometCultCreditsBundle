<?php

namespace CometCult\CreditsBundle\Manager;

use CometCult\CreditsBundle\Document\Credit;

use Doctrine\ODM\MongoDB\DocumentManager;

class CreditsManager implements CreditsManagerInterface
{
    protected $dm;

    /**
     * CreditsManager constructor
     *
     * @param DocumentManager $dm
     */
    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    /**
     * Create Credit instance
     *
     * @param int    $amount  amount
     * @param string $ownerId ownerId
     *
     * @return Credit
     */
    public function createCredit($amount, $ownerId)
    {
        $credit = new Credit();
        $credit->setOwnerId($ownerId);
        $credit->setAmount($amount);

        return $credit;
    }

    /**
     * Update credit and persist in store
     *
     * @param Credit $credit
     *
     * @return Credit
     */
    public function updateCredit(Credit $credit)
    {
        $this->dm->persist($credit);
        $this->dm->flush();

        return $credit;
    }

    /**
     * Get curent credit balance
     *
     * @param string $ownerId
     *
     * @return int
     */
    public function getCreditBalance($ownerId)
    {
        $credit = $this->getCreditByOwnerId($ownerId);

        return $credit ? $credit->getAmount() : 0;
    }

    /**
     * Add amount to current credit
     *
     * @param int    $amount  amount
     * @param string $ownerId ownerId
     *
     * @return Credit
     */
    public function addCredit($amount, $ownerId)
    {
        $credit = $this->getCreditByOwnerId($ownerId);
        if (empty($credit)) {
            $credit = $this->createCredit(0, $ownerId);
        }

        $currentAmount = $credit->getAmount();
        $amount = $currentAmount + $amount;
        $credit->setAmount($amount);
        $this->updateCredit($credit);

        return $credit;
    }

    /**
     * Subtract amount from current credit
     *
     * @param int    $amount  amount
     * @param string $ownerId ownerId
     *
     * @return Credit
     */
    public function subtractCredit($amount, $ownerId)
    {
        $credit = $this->getCreditByOwnerId($ownerId);
        if (empty($credit)) {
            $credit = $this->createCredit(0, $ownerId);
        }

        $currentAmount = $credit->getAmount();
        $amount = $currentAmount - $amount;
        $credit->setAmount($amount);
        $this->updateCredit($credit);

        return $credit;
    }

    private function getCreditByOwnerId($ownerId)
    {
        $credit = $this->dm
            ->getRepository('CometCultCreditsBundle:Credit')
            ->findOneBy(array('ownerId' => $ownerId));

        return $credit;
    }
}
