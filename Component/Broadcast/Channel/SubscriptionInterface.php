<?php
/**
 *
 *  This file is part of the Hermes package.
 *
 *  (c) Mauro Murru (Brainrepo)  <murru7@gmail.com>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 */

namespace Hermes\Component\Broadcast\Channel;


use Hermes\Component\Broadcast\Transport\AddressInterface;

interface SubscriptionInterface
{

    /**
     * @return AddressInterface
     */
    public function getAddress();

    /**
     * @return string
     */
    public function getTransportId();
}