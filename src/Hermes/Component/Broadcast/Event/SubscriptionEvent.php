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

namespace Hermes\Component\Broadcast\Event;

use Hermes\Component\Broadcast\Subscription\SubscriptionInterface;
use Symfony\Component\EventDispatcher\Event;

class SubscriptionEvent extends Event
{
    const STARTED = 'hermes.broadcast.subscription.started';
    const ENDED = 'hermes.broadcast.subscription.ended';
    const FAILED = 'hermes.broadcast.subscription.failed';

    /**
     * @var SubscriptionInterface
     */
    protected $subscription;

    /**
     * SubscriptionEvent constructor.
     *
     * @param SubscriptionInterface $subscription
     */
    public function __construct(SubscriptionInterface $subscription)
    {
        $this->subscription = $subscription;
    }
}
