<?php

namespace CometCult\CreditsBundle\Balance;

interface BalanceCheckerInterface
{
    /**
     * @param string $ownerId
     *
     * @return int
     */
    public function getCreditBalance($ownerId);

    /**
     * @param string $ownerId
     *
     * @return boolean
     */
    public function hasLowCreditBalance($ownerId);

    /**
     * @param string $ownerId
     *
     * @return boolean
     */
    public function hasHighCreditBalance($ownerId);
}
