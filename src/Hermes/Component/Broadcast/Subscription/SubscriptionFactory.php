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

namespace Hermes\Component\Broadcast\Subscription;

use Hermes\Component\Broadcast\Exception\AddressNotFoundException;
use Hermes\Component\Broadcast\Receiver\ReceiverInterface;

class SubscriptionFactory
{
    /**
     * @param ReceiverInterface $receiver
     * @param string            $transportClass
     * @param $channelId
     * @param $lifetime
     *
     * @return Subscription
     *
     * @throws AddressNotFoundException
     */
    public function create(ReceiverInterface $receiver, $transportClass, $channelId, $lifetime)
    {
        $address = $receiver->getAddressByTransport($transportClass);

        if (!$address) {
            throw new AddressNotFoundException(sprintf('Not compatible address for %s', $transportClass));
        }

        return new Subscription($address, $transportClass, $channelId, $lifetime);
    }
}
