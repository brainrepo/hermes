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

namespace Hermes\Component\Broadcast\Sms;

use Hermes\Component\Broadcast\Receiver\AddressInterface;

class SmsAddress implements AddressInterface
{
    /**
     * @var string
     */
    private $mobilePhoneNumber;

    /**
     * SmsAddress constructor.
     *
     * @param $mobilePhoneNumber
     */
    public function __construct($mobilePhoneNumber)
    {
        $this->mobilePhoneNumber = $mobilePhoneNumber;
    }

    /**
     * @return string
     */
    public function getMobilePhoneNumber()
    {
        return $this->mobilePhoneNumber;
    }
}
