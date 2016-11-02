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

namespace Hermes\Component\Broadcast\Factory;

use Hermes\Component\Broadcast\Model\ReceiverInterface;
use Hermes\Component\Broadcast\Model\SubscriptionInterface;

interface SubscriptionFactory
{
    /**
     * @param ReceiverInterface $receiver
     * @param string            $transportId
     * @param string            $channelId
     * @param int               $lifetime    Lifetime in seconds of the subscription
     *
     * @return SubscriptionInterface
     */
    public function create(ReceiverInterface $receiver, $transportId, $channelId, $lifetime);
}
