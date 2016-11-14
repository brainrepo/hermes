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

namespace Hermes\Component\Broadcast\WebSocketsPush;

use Hermes\Component\Broadcast\Message\MessageInterface;
use Hermes\Component\Broadcast\Transport\BaseTransport;

class WebSocketPushTransport extends BaseTransport
{
    /**
     * {@inheritdoc}
     */
    protected function adaptMessage(MessageInterface $message)
    {
        $rawMessage = $message->getMessageByTransport(self::class);

        if (!$rawMessage) {
            $rawMessage = new WebSocketPushMessage($message->getText());
        }

        return $rawMessage;
    }
}
