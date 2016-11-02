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

namespace spec\Hermes\Component\Broadcast\Event;

use Hermes\Component\Broadcast\Event\BroadcastEvent;
use Hermes\Component\Broadcast\Model\MessageInterface;
use PhpSpec\ObjectBehavior;

class BroadcastEventSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(BroadcastEvent::class);
    }

    public function let(MessageInterface $message)
    {
        $transport = 'ios.push_notification';
        $this->beConstructedWith($message, $transport);
    }
}
