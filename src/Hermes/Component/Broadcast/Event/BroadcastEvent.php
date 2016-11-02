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

namespace Hermes\Component\Broadcast\Event;

use Hermes\Component\Broadcast\Model\MessageInterface;
use Symfony\Component\EventDispatcher\Event;

class BroadcastEvent extends Event
{

    const STARTED = "hermes.broadcast.broadcast.started";
    const PREPARED_FOR_QUEUE = 'hermes.broadcast.message.prepared_for_queued';
    const QUEUED = 'hermes.broadcast.message.queued';
    const ENDED = 'hermes.broadcast.broadcast.ended';
    /**
     * @var MessageInterface
     */
    protected $message;
    /**
     * @var string
     */
    protected $channelId;

    /**
     * BroadcastEvent constructor.
     *
     * @param MessageInterface $message
     * @param string           $channelId
     */
    public function __construct(MessageInterface $message, $channelId)
    {
        $this->message = $message;
        $this->channelId = $channelId;
    }
}
