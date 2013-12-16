<?php

namespace CometCult\CreditsBundle\Balance;

use CometCult\CreditsBundle\Document\Credit;

use Doctrine\ODM\MongoDB\DocumentManager;

class BalanceChecker implements BalanceCheckerInterface
{
    /**
     * @var DocumentManager
     */
    protected $dm;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * CreditsManager constructor
     *
     * @param DocumentManager $dm
     * @param array $parameters
     */
    public function __construct(DocumentManager $dm, $parameters = array())
    {
        $this->dm = $dm;
        $this->parameters = $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreditBalance($ownerId)
    {
        $credit = $this->getCreditByOwnerId($ownerId);

        return $credit ? $credit->getAmount() : 0;
    }

    /**
     * {@inheritdoc}
     */
    public function hasLowCreditBalance($ownerId)
    {
        return $this->getCreditBalance($ownerId) <= $this->parameters['min_threshold'];
    }

    /**
     * {@inheritdoc}
     */
    public function hasHighCreditBalance($ownerId)
    {
        return $this->getCreditBalance($ownerId) >= $this->parameters['max_threshold'];
    }

    protected function getCreditByOwnerId($ownerId)
    {
        $credit = $this->dm
            ->getRepository('CometCultCreditsBundle:Credit')
            ->findOneBy(array('ownerId' => $ownerId));

        return $credit;
    }
}