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

use Hermes\Component\Broadcast\Model\SubscriptionInterface;
use Hermes\Component\Broadcast\Model\TransportInterface;

interface SubscriptionRepositoryInterface
{
    /**
     * @param SubscriptionInterface $subscription
     *
     * @return mixed
     */
    public function add(SubscriptionInterface $subscription);

    /**
     * @param string             $channelId
     * @param TransportInterface $transport
     *
     * @return SubscriptionInterface[]
     */
    public function findByChannelAndTransport($channelId, TransportInterface $transport);
}
