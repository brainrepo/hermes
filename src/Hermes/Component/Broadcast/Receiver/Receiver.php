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

class Receiver implements ReceiverInterface
{
    /**
     * @var array
     */
    private $addresses = [];

    /**
     * Receiver constructor.
     *
     * @param array $addresses
     */
    public function __construct(array $addresses)
    {
        $this->addresses = $addresses;
    }

    /**
     * {@inheritdoc}
     */
    public function getAddressByTransport($transportClass)
    {
        if (!key_exists($transportClass, $this->addresses)) {
            return null;
        }

        return $this->addresses[$transportClass];
    }
}
