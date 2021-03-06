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

namespace Hermes\Component\Broadcast\Receiver;

use Hermes\Component\Broadcast\Exception\AddressNotFoundException;

interface ReceiverInterface
{
    /**
     * @param string $transportClass
     *
     * @return AddressInterface
     *
     * @throws AddressNotFoundException
     */
    public function getAddressByTransport($transportClass);
}
