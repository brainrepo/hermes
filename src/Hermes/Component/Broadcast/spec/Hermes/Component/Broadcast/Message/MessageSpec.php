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

namespace spec\Hermes\Component\Broadcast\Message;

use Hermes\Component\Broadcast\Message\Message;
use Hermes\Component\Broadcast\Message\RawMessageInterface;
use Hermes\Component\Broadcast\Transport\TransportInterface;
use PhpSpec\ObjectBehavior;

class MessageSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Message::class);
    }

    public function let(TransportInterface $transport)
    {
        $this->beConstructedWith('text message');
    }

    public function it_can_return_text()
    {
        $this->getText()->shouldReturn('text message');
    }

    public function it_can_get_message_by_transport(RawMessageInterface $rawMessage, TransportInterface $transport)
    {
        $this->addMessage($rawMessage, TransportInterface::class);
        $this->getMessageByTransport(TransportInterface::class)->shouldReturn($rawMessage);
        $this->getMessageByTransport(self::class)->shouldReturn(null);
    }

    public function it_can_get_null_if_rawmessage_for_this_transport_is_not_loaded(RawMessageInterface $rawMessage, TransportInterface $transport)
    {
        $this->addMessage($rawMessage, TransportInterface::class);
        $this->getMessageByTransport(TransportInterface::class)->shouldReturn($rawMessage);
        $this->getMessageByTransport(self::class)->shouldReturn(null);
    }

    public function it_can_add_raw_message(RawMessageInterface $rawMessage)
    {
        $this->addMessage($rawMessage, TransportInterface::class);
    }
}
