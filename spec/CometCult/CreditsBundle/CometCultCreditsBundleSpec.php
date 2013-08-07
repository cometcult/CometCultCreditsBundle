<?php

namespace spec\CometCult\CreditsBundle;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CometCultCreditsBundleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('CometCult\CreditsBundle\CometCultCreditsBundle');
    }
}
