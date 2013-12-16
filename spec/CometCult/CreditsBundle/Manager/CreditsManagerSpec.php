<?php

namespace spec\CometCult\CreditsBundle\Manager;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreditsManagerSpec extends ObjectBehavior
{
    /**
     * @param Doctrine\ODM\MongoDB\DocumentManager $documentManager
     */
    function let($documentManager)
    {
        $this->beConstructedWith($documentManager);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('CometCult\CreditsBundle\Manager\CreditsManager');
    }

    function it_should_create_credit()
    {
        $this
            ->createCredit(200, '123abc')
            ->shouldHaveType('CometCult\CreditsBundle\Document\Credit');
    }

    /**
     * @param CometCult\CreditsBundle\Document\Credit $credit
     * @param Doctrine\ODM\MongoDB\DocumentManager    $documentManager
     */
    function it_should_update_credit($credit, $documentManager)
    {
        $credit
            ->getOwnerId()
            ->willReturn('123abc');

        $documentManager
            ->persist($credit)
            ->shouldBeCalled();

        $documentManager
            ->flush()
            ->shouldBeCalled();

        $this
            ->updateCredit($credit)
            ->shouldHaveType('CometCult\CreditsBundle\Document\Credit');
    }

    /**
     * @param CometCult\CreditsBundle\Document\Credit $credit
     * @param Doctrine\ODM\MongoDB\DocumentManager    $documentManager
     * @param Doctrine\ODM\MongoDB\DocumentRepository $creditRepository
     */
    function it_should_add_credit($credit, $documentManager, $creditRepository)
    {
        $documentManager
            ->getRepository('CometCultCreditsBundle:Credit')
            ->shouldBeCalled()
            ->willReturn($creditRepository);

        $documentManager
            ->persist($credit)
            ->shouldBeCalled();

        $documentManager
            ->flush()
            ->shouldBeCalled();

        $creditRepository
            ->findOneBy(array('ownerId' => '123abc'))
            ->shouldBeCalled()
            ->willReturn($credit);

        $credit
            ->getAmount()
            ->shouldBeCalled()
            ->willReturn(100);

        $credit
            ->setAmount(150)
            ->shouldBeCalled();

        $this
            ->addCredit(50, '123abc')
            ->shouldHaveType('CometCult\CreditsBundle\Document\Credit');
    }

    /**
     * @param Doctrine\ODM\MongoDB\DocumentManager    $documentManager
     * @param Doctrine\ODM\MongoDB\DocumentRepository $creditRepository
     */
    function it_should_create_new_credit_when_adding_on_non_existing_owner_id(
        $documentManager,
        $creditRepository
    )
    {
        $documentManager
            ->getRepository('CometCultCreditsBundle:Credit')
            ->shouldBeCalled()
            ->willReturn($creditRepository);

        $documentManager
            ->persist(Argument::type('CometCult\CreditsBundle\Document\Credit'))
            ->shouldBeCalled();

        $documentManager
            ->flush()
            ->shouldBeCalled();

        $creditRepository
            ->findOneBy(array('ownerId' => 'doesntExist123'))
            ->shouldBeCalled()
            ->willReturn(null);

        $this
            ->addCredit(50, 'doesntExist123')
            ->shouldHaveType('CometCult\CreditsBundle\Document\Credit');
    }

    /**
     * @param CometCult\CreditsBundle\Document\Credit $credit
     * @param Doctrine\ODM\MongoDB\DocumentManager    $documentManager
     * @param Doctrine\ODM\MongoDB\DocumentRepository $creditRepository
     */
    function it_should_subtract_credit($credit, $documentManager, $creditRepository)
    {
        $documentManager
            ->getRepository('CometCultCreditsBundle:Credit')
            ->shouldBeCalled()
            ->willReturn($creditRepository);

        $documentManager
            ->persist($credit)
            ->shouldBeCalled();

        $documentManager
            ->flush()
            ->shouldBeCalled();

        $creditRepository
            ->findOneBy(array('ownerId' => '123abc'))
            ->shouldBeCalled()
            ->willReturn($credit);

        $credit
            ->getAmount()
            ->shouldBeCalled()
            ->willReturn(200);

        $credit
            ->setAmount(150)
            ->shouldBeCalled();

        $this
            ->subtractCredit(50, '123abc')
            ->shouldHaveType('CometCult\CreditsBundle\Document\Credit');
    }

    /**
     * @param CometCult\CreditsBundle\Document\Credit $credit
     * @param Doctrine\ODM\MongoDB\DocumentManager    $documentManager
     * @param Doctrine\ODM\MongoDB\DocumentRepository $creditRepository
     */
    function it_should_return_credit_by_owner_id($credit, $documentManager, $creditRepository)
    {
        $documentManager
            ->getRepository('CometCultCreditsBundle:Credit')
            ->shouldBeCalled()
            ->willReturn($creditRepository);

        $creditRepository
            ->findOneBy(array('ownerId' => '123abc'))
            ->shouldBeCalled()
            ->willReturn($credit);

        $this
            ->getCreditByOwnerId('123abc')
            ->shouldReturn($credit);
    }

    /**
     * @param CometCult\CreditsBundle\Document\Credit $credit
     * @param Doctrine\ODM\MongoDB\DocumentManager    $documentManager
     */
    function it_should_reload_credit($credit, $documentManager)
    {
        $documentManager
            ->refresh($credit)
            ->shouldBeCalled();
        $this
            ->reloadCredit($credit)
            ->shouldHaveType('CometCult\CreditsBundle\Document\Credit');
    }
}
