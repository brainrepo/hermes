<?php
/**
 *
 *  This file is part of the Hermes package.
 *
 *  (c) Mauro Murru (Brainrepo)  <murru7@gmail.com>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 */

namespace spec\Hermes\Component\Broadcast\Channel\Events;

use Hermes\Component\Broadcast\Channel\ChannelInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ChannelEventSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Hermes\Component\Broadcast\Channel\Events\ChannelEvent');
    }

    function let(ChannelInterface $channel)
    {
        $this->beConstructedWith($channel);
    }
}