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

namespace Hermes\Component\Broadcast\Repository;

use Hermes\Component\Broadcast\Subscription\SubscriptionInterface;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    private $subscriptions = [];

    public function add(SubscriptionInterface $subscription)
    {
        $this->subscriptions[] = $subscription;
    }

    public function findByChannelAndTransport($channelId, $transportClass)
    {
        $array = array_filter($this->subscriptions, function (SubscriptionInterface $subscription) use ($channelId, $transportClass) {
            return $subscription->getTransportClass() == $transportClass && $subscription->getChannelId() == $channelId;
        });

        return $array;
    }
}
