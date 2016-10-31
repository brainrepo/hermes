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

namespace Hermes\Component\Broadcast\Receiver;


use Hermes\Component\Broadcast\Transport\AddressInterface;

interface ReceiverInterface
{
    /**
     * @param string $TransportName
     * @return AddressInterface
     * @throws AddressNotFoundException
     */
    public function getAddressByTransport($TransportName);
}