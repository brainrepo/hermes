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

use Doctrine\Common\Persistence\ObjectRepository;

interface ChannelRepository extends ObjectRepository
{
    public function add(ChannelInterface $channel);
    public function getById($identifier);


    /**
     * @param $identifier
     * @param \Closure $callback
     * @return mixed
     */
    public function findOneOrCreate($identifier, \Closure $callback);
}
