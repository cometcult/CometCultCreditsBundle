<?php

namespace CometCult\CreditsBundle\Manager;

use CometCult\CreditsBundle\Document\Credit;

use Doctrine\ODM\MongoDB\DocumentManager;

class CreditsManager implements CreditsManagerInterface
{
    /**
     * @var DocumentManager
     */
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
     * {@inheritdoc}
     */
    public function createCredit($amount, $ownerId)
    {
        $credit = new Credit();
        $credit->setOwnerId($ownerId);
        $credit->setAmount($amount);

        return $credit;
    }

    /**
     * {@inheritdoc}
     */
    public function updateCredit(Credit $credit)
    {
        $this->dm->persist($credit);
        $this->dm->flush();

        return $credit;
    }

    /**
     * {@inheritdoc}
     */
    public function reloadCredit(Credit $credit)
    {
        $this->dm->refresh($credit);

        return $credit;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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

    /**
     * {@inheritdoc}
     */
    public function getCreditByOwnerId($ownerId)
    {
        $credit = $this->dm
            ->getRepository('CometCultCreditsBundle:Credit')
            ->findOneBy(array('ownerId' => $ownerId));

        return $credit;
    }
}
