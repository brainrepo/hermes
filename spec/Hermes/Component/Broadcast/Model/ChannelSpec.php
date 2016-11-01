<?php

/*
 * This file is part of the Hermes package.
 *
 * Copyright (c) 2014-2016 Mauro Murru Brainrepo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Mauro Murru Brainrepo <murru7@gmail.com>
 */

namespace spec\Hermes\Component\Broadcast\Model;

use Hermes\Component\Broadcast\Model\Channel;
use Hermes\Component\Broadcast\Model\SubscriptionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ChannelSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Channel::class);
    }

    function let()
    {
        $this->beConstructedWith('soccer_team_group');
    }

    function it_can_get_name()
    {
        $this->getName()->shouldReturn('soccer_team_group');
    }

    function it_can_add_subscription(SubscriptionInterface $subscription)
    {
        $this->addSubscription($subscription);
    }
}
