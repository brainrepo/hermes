<?php

/**
 *
 *  This file is part of the Hermes package.
 *
 *  (c) Mauro Murru (Brainrepo) <murru7@gmail.com>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 */


namespace Hermes\Component\Broadcast\Channel\Events;

use Hermes\Component\Broadcast\Channel\SubscriptionInterface;
use Symfony\Component\EventDispatcher\Event;

class SubscriptionEvent extends Event
{
    /**
     * @var SubscriptionInterface
     */
    protected $subscription;

    /**
     * ChannelEvent constructor.
     * @param SubscriptionInterface $subscription
     */
    public function __construct(SubscriptionInterface $subscription)
    {
        $this->subscription = $subscription;
    }
}