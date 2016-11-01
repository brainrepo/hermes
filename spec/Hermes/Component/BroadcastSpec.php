<?php

namespace spec\Hermes\Component;

use Hermes\Component\Broadcast;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BroadcastSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Broadcast::class);
    }
}
