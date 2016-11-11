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


namespace Hermes\Component\Broadcast\Receiver;

use Hermes\Component\Broadcast\Exception\AddressNotFoundException;

class Receiver implements ReceiverInterface
{

    /**
     * @var array
     */
    private $addresses = [];

    /**
     * Receiver constructor.
     * @param array $addresses
     */
    public function __construct(array $addresses)
    {
        $this->addresses = $addresses;
    }

    /**
     * @inheritDoc
     */
    public function getAddressByTransport($transportClass)
    {
        if (!key_exists($transportClass, $this->addresses)) {
            return null;
        }

        return $this->addresses[$transportClass];
    }
}