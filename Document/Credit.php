<?php

namespace CometCult\CreditsBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Credit
{
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;

    /**
     * @MongoDB\Int
     */
    protected $amount;

    /**
     * @MongoDB\String
     * @MongoDB\UniqueIndex
     */
    protected $ownerId;

    /**
     * Set unique id of owner entity
     *
     * @param string $ownerId
     *
     * @return Credit
     */
    public function setOwnerId($ownerId)
    {
        $this->ownerId = $ownerId;

        return $this;
    }

    /**
     * Get owner id
     *
     * @return string
     */
    public function getOwnerId()
    {
        return $this->ownerId();
    }

    /**
     * Set amount of credit
     *
     * @param int $amount
     *
     * @return Credit
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get credit amount
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Get credit id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}
