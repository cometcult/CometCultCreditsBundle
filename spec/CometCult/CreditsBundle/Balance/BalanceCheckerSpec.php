<?php

namespace spec\CometCult\CreditsBundle\Balance;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BalanceCheckerSpec extends ObjectBehavior
{
    /**
     * @param Doctrine\ODM\MongoDB\DocumentManager $documentManager
     */
    function let($documentManager)
    {
        $this->beConstructedWith($documentManager, array(
            'min_threshold' => 20,
            'max_threshold' => 100
        ));
    }

    function it_should_be_a_balance_checker()
    {
        $this->shouldHaveType('CometCult\CreditsBundle\Balance\BalanceCheckerInterface');
    }

    /**
     * @param CometCult\CreditsBundle\Document\Credit $credit
     * @param Doctrine\ODM\MongoDB\DocumentManager    $documentManager
     * @param Doctrine\ODM\MongoDB\DocumentRepository $creditRepository
     */
    function it_should_return_credit_balance($credit, $documentManager, $creditRepository)
    {
        $documentManager
            ->getRepository('CometCultCreditsBundle:Credit')
            ->shouldBeCalled()
            ->willReturn($creditRepository);

        $creditRepository
            ->findOneBy(array('ownerId' => '123abc'))
            ->shouldBeCalled()
            ->willReturn($credit);

        $credit
            ->getAmount()
            ->shouldBeCalled()
            ->willReturn(200);

        $this->getCreditBalance('123abc')->shouldReturn(200);
    }

    /**
     * @param CometCult\CreditsBundle\Document\Credit $credit
     * @param Doctrine\ODM\MongoDB\DocumentManager    $documentManager
     * @param Doctrine\ODM\MongoDB\DocumentRepository $creditRepository
     */
    function it_should_return_credit_balance_zero_when_no_credit($credit, $documentManager, $creditRepository)
    {
        $documentManager
            ->getRepository('CometCultCreditsBundle:Credit')
            ->shouldBeCalled()
            ->willReturn($creditRepository);

        $creditRepository
            ->findOneBy(array('ownerId' => '123abc'))
            ->shouldBeCalled()
            ->willReturn(null);

        $this->getCreditBalance('123abc')->shouldReturn(0);
    }

    /**
     * @param CometCult\CreditsBundle\Document\Credit $credit
     * @param Doctrine\ODM\MongoDB\DocumentManager    $documentManager
     * @param Doctrine\ODM\MongoDB\DocumentRepository $creditRepository
     */
    function it_should_say_if_the_minimal_credit_threshold_has_been_reached($credit, $documentManager, $creditRepository)
    {
        $documentManager
            ->getRepository('CometCultCreditsBundle:Credit')
            ->shouldBeCalled()
            ->willReturn($creditRepository);

        $creditRepository
            ->findOneBy(array('ownerId' => '123abc'))
            ->shouldBeCalled()
            ->willReturn($credit);

        $credit
            ->getAmount()
            ->shouldBeCalled()
            ->willReturn(10);

        $this->hasLowCreditBalance('123abc')->shouldReturn(true);
        $this->hasHighCreditBalance('123abc')->shouldReturn(false);
    }

    /**
     * @param CometCult\CreditsBundle\Document\Credit $credit
     * @param Doctrine\ODM\MongoDB\DocumentManager    $documentManager
     * @param Doctrine\ODM\MongoDB\DocumentRepository $creditRepository
     */
    function it_should_say_if_the_maximal_credit_threshold_has_been_reached($credit, $documentManager, $creditRepository)
    {
        $documentManager
            ->getRepository('CometCultCreditsBundle:Credit')
            ->shouldBeCalled()
            ->willReturn($creditRepository);

        $creditRepository
            ->findOneBy(array('ownerId' => '123abc'))
            ->shouldBeCalled()
            ->willReturn($credit);

        $credit
            ->getAmount()
            ->shouldBeCalled()
            ->willReturn(110);

        $this->hasLowCreditBalance('123abc')->shouldReturn(false);
        $this->hasHighCreditBalance('123abc')->shouldReturn(true);
    }
}
