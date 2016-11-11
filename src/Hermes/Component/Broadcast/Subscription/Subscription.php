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

class Subscription implements SubscriptionInterface
{
    /**
     * @var AddressInterface
     */
    private $address;

    /**
     * @var string
     */
    private $transportClass;

    /**
     * @var string
     */
    private $channelId;

    /**
     * @var int
     */
    private $lifetime;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * Subscription constructor.
     *
     * @param AddressInterface $address
     * @param string           $transportClass
     * @param string           $channelId
     * @param int              $lifetime
     */
    public function __construct(AddressInterface $address, $transportClass, $channelId, $lifetime)
    {
        $this->address = $address;
        $this->transportClass = $transportClass;
        $this->channelId = $channelId;
        $this->lifetime = $lifetime;
        $this->createdAt = new \DateTime();
    }

    /**
     * Return the address for the specific transports.
     *
     * @return AddressInterface
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getTransportClass()
    {
        return $this->transportClass;
    }

    /**
     * @return string
     */
    public function getChannelId()
    {
        return $this->channelId;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        $now = new \DateTime();
        $dateInterval = $now->diff($this->createdAt);
        $lifetimeInterval = new \DateInterval('PT' . $this->lifetime . 'S');

        return $lifetimeInterval >= $dateInterval;
    }
}
