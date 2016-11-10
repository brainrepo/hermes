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

namespace spec\Hermes\Component\Broadcast\Sms\Provider;

use Hermes\Component\Broadcast\Message\RawMessageInterface;
use Hermes\Component\Broadcast\Sms\Provider\NexmoSmsProvider;
use Hermes\Component\Broadcast\Sms\SmsAddress;
use Hermes\Component\Broadcast\Sms\SmsTransport;
use PhpSpec\ObjectBehavior;

class NexmoSmsProviderSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(NexmoSmsProvider::class);
    }

    public function let()
    {
        $this->beConstructedWith('apikey', 'apisecret', 'from');
    }

    public function it_can_return_transport_class()
    {
        $this->getTransportClass()->shouldReturn(SmsTransport::class);
    }

    public function it_can_send(RawMessageInterface $message, SmsAddress $address1, SmsAddress $address2)
    {
        $address1->getMobilePhoneNumber()->willReturn('393492977244');
        $address2->getMobilePhoneNumber()->willReturn('393405717382');
        $message->getText()->willReturn('MESSAGE TEXT');
        $this->send($message, [$address1, $address2], 2);
    }
}
