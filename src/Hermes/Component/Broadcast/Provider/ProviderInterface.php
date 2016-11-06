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

namespace Hermes\Component\Broadcast\Provider;

use Hermes\Component\Broadcast\Message\RawMessageInterface;
use Hermes\Component\Broadcast\Receiver\AddressInterface;

interface ProviderInterface
{
    public function getTransportClass();

    //TODO: define specific address for transport
    /**
     * @param RawMessageInterface $messageInterface
     * @param AddressInterface[]  $addresses
     * @param int                 $attempts
     */
    public function send(RawMessageInterface $messageInterface, $addresses, $attempts = 3);
}
