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


namespace Hermes\Component\Broadcast\Channel;

use Hermes\Component\Broadcast\Transport\AddressInterface;

class Subscription implements SubscriptionInterface
{
    /**
     * @var AddressInterface
     */
    private $address;

    /**
     * @var string
     */
    private $transportId;

    /**
     * Subscription constructor.
     * @param AddressInterface $address
     * @param string $transportId
     */
    public function __construct(AddressInterface $address, $transportId)
    {
        $this->address = $address;
        $this->transportId = $transportId;
    }

    /**
     * @return AddressInterface
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getTransportId()
    {
        return $this->transportId;
    }

}
