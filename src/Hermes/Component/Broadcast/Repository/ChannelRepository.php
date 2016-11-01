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

use Doctrine\Common\Persistence\ObjectRepository;
use Hermes\Component\Broadcast\Model\ChannelInterface;

interface ChannelRepository extends ObjectRepository
{
    public function add(ChannelInterface $channel);
    public function getById($identifier);

    /**
     * @param $identifier
     * @param \Closure $callback
     *
     * @return ChannelInterface
     */
    public function findOneOrCreate($identifier, \Closure $callback);
}
