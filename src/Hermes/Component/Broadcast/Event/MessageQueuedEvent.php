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

use Hermes\Component\Broadcast\Message\MessageInterface;
use Symfony\Component\EventDispatcher\Event;

class MessageQueuedEvent extends Event
{
    /**
     * @var MessageInterface
     */
    protected $message;

    /**
     * @var string
     */
    protected $channelId;

    /**
     * @var string
     */
    protected $transportId;

    /**
     * MessageQueuedEvent constructor.
     *
     * @param MessageInterface $message
     * @param $channelId
     * @param $transportId
     */
    public function __construct(MessageInterface $message, $channelId, $transportId)
    {
        $this->message = $message;
        $this->channelId = $channelId;
        $this->transportId = $transportId;
    }
}
