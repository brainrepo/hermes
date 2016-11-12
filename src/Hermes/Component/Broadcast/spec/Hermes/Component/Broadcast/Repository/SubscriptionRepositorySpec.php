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

namespace spec\Hermes\Component\Broadcast\Repository;

use Hermes\Component\Broadcast\Repository\SubscriptionRepository;
use Hermes\Component\Broadcast\Subscription\SubscriptionInterface;
use PhpSpec\ObjectBehavior;

class SubscriptionRepositorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(SubscriptionRepository::class);
    }

    public function it_can_add_subscription(SubscriptionInterface $subscription)
    {
        $this->add($subscription);
    }

    public function it_can_find_by_channel_and_transport(SubscriptionInterface $subscription)
    {
        $this->add($subscription);
        $subscription->getTransportClass()->willReturn('SmsTransportClass');
        $subscription->getChannelId()->willReturn('brinrepo_football_team');
        $this->findByChannelAndTransport('brinrepo_football_team', 'SmsTransportClass')->shouldReturn([$subscription]);
    }
}
