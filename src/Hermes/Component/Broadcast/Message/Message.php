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

namespace Hermes\Component\Broadcast\Message;

class Message implements MessageInterface
{
    private $rawMessages = [];

    private $text;

    /**
     * Message constructor.
     *
     * @param $text
     */
    public function __construct($text)
    {
        $this->text = $text;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessageByTransport($transportClass)
    {
        if (!key_exists($transportClass, $this->rawMessages)) {
            return null;
        }

        return $this->rawMessages[$transportClass];
    }

    /**
     * {@inheritdoc}
     */
    public function addMessage(RawMessageInterface $message, $transportClass)
    {
        $this->rawMessages[$transportClass] = $message;
    }

    /**
     * {@inheritdoc}
     */
    public function getText()
    {
        return $this->text;
    }
}
