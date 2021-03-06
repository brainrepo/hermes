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

use Hermes\Component\Broadcast\Transport\TransportInterface;

interface TransportRepositoryInterface
{
    public function add(TransportInterface $transport);
    public function getByClass($argument1);

    /**
     * Return by transports id, if is null return all transports.
     *
     * @param array $allowedTransports
     *
     * @return array
     */
    public function getByTransportClasses($allowedTransports = null);

    public function findAll();
}
