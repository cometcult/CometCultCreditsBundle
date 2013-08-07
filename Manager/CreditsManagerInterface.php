<?php

namespace CometCult\CreditsBundle\Manager;

use CometCult\CreditsBundle\Document\Credit;

interface CreditsManagerInterface
{
    /**
     * @param int    $amount  amount
     * @param string $ownerId ownerId
     *
     * @return Credit
     */
    public function createCredit($amount, $ownerId);

    /**
     * @param Credit $credit
     *
     * @return Credit
     */
    public function updateCredit(Credit $credit);

    /**
     * @param string $ownerId
     *
     * @return int
     */
    public function getCreditBalance($ownerId);

    /**
     * @param int    $amount  amount
     * @param string $ownerId ownerId
     *
     * @return Credit
     */
    public function addCredit($amount, $ownerId);

    /**
     * @param int    $amount  amount
     * @param string $ownerId ownerId
     *
     * @return Credit
     */
    public function subtractCredit($amount, $ownerId);
}
