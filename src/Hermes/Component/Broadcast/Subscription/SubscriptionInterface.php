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

use Hermes\Component\Broadcast\Receiver\AddressInterface;

interface SubscriptionInterface
{
    /**
     * Get specific address fot this transport method subscription.
     *
     * @return AddressInterface
     */
    public function getAddress();

    /**
     * @return string
     */
    public function getTransportClass();

    /**
     * @return string
     */
    public function getChannelId();
}
