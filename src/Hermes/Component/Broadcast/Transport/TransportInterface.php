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

namespace Hermes\Component\Broadcast\Transport;

use Hermes\Component\Broadcast\Message\MessageInterface;
use Hermes\Component\Broadcast\Subscription\SubscriptionInterface;

interface TransportInterface
{
    public function send();
    public function getId();

    /**
     * @param SubscriptionInterface $subscriptions
     * @param MessageInterface      $message
     */
    public function queue(SubscriptionInterface $subscriptions, MessageInterface $message);

    public function flush();
}
