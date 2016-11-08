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

interface MessageInterface
{
    /**
     * @param string $transportClass
     *
     * @return RawMessageInterface
     */
    public function getMessageByTransport($transportClass);

    /**
     * @param RawMessageInterface $message
     * @param string              $transportClass
     */
    public function addMessage(RawMessageInterface $message, $transportClass);

    /**
     * @return string
     */
    public function getText();
}
