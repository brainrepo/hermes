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

namespace Hermes\Component\Broadcast\Repository;

use Hermes\Component\Broadcast\Exception\TransportAlreadyExistsException;
use Hermes\Component\Broadcast\Transport\TransportInterface;

class TransportRepository implements TransportRepositoryInterface
{
    protected $transports = [];

    /**
     * @param TransportInterface $transport
     *
     * @throws TransportAlreadyExistsException
     */
    public function add(TransportInterface $transport)
    {
        $transportClass = get_class($transport);
        if (!key_exists($transportClass, $this->transports)) {
            $this->transports[$transportClass] = $transport;
        } else {
            throw new TransportAlreadyExistsException();
        }
    }

    public function getByClass($transportClass)
    {
        if (!key_exists($transportClass, $this->transports)) {
            return null;
        }

        return $this->transports[$transportClass];
    }

    public function getByTransportClasses($allowedTransports = null)
    {
        $returnTransports = [];

        if ($allowedTransports == null) {
            return $returnTransports;
        }

        foreach ($allowedTransports as $allowedTransport) {
            if ($this->getByClass($allowedTransport) != null) {
                $returnTransports[] = $this->getByClass($allowedTransport);
            }
        }

        return $returnTransports;
    }

    public function findAll()
    {
        return $this->transports;
    }
}
