<?php

namespace spec\CometCult\CreditsBundle\Document;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreditSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('CometCult\CreditsBundle\Document\Credit');
    }
}
