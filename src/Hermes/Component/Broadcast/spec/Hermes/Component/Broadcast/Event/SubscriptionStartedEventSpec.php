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

namespace spec\Hermes\Component\Broadcast\Channel\Events;

use Hermes\Component\Broadcast\Event\SubscriptionStartedEvent;
use Hermes\Component\Broadcast\Model\SubscriptionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SubscriptionStartedEventSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SubscriptionStartedEvent::class);
    }

    function let(SubscriptionInterface $subscription)
    {
        $this->beConstructedWith($subscription);
    }
}