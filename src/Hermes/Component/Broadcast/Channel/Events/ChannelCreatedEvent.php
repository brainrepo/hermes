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


namespace Hermes\Component\Broadcast\Channel\Events;

use Hermes\Component\Broadcast\Channel\ChannelInterface;

class ChannelCreatedEvent extends ChannelEvent
{

    /**
     * ChannelCreatedEvent constructor.
     */
    public function __construct(ChannelInterface $channel)
    {
        parent::__construct($channel);
    }
}