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

namespace spec\Hermes\Component\Broadcast\WebSocketsPush;

use Hermes\Component\Broadcast\WebSocketsPush\WebSocketPushMessage;
use Hermes\Component\Broadcast\WebSocketsPush\WebSocketPushTransport;
use PhpSpec\ObjectBehavior;

class WebSocketPushMessageSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(WebSocketPushMessage::class);
    }

    public function let()
    {
        $this->beConstructedWith('text');
    }

    public function it_can_get_text()
    {
        $this->getText()->shouldReturn('text');
    }

    public function it_can_return_transport()
    {
        $this->getTransport()->shouldReturn(WebSocketPushTransport::class);
    }
}
