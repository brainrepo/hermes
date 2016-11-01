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

namespace Hermes\Component\Broadcast\Channel\Events;


use Hermes\Component\Broadcast\Channel\ChannelInterface;
use Symfony\Component\EventDispatcher\Event;

class ChannelEvent extends Event
{
    /**
     * @var ChannelInterface
     */
    protected $channel;

    /**
     * ChannelEvent constructor.
     * @param ChannelInterface $channel
     */
    public function __construct(ChannelInterface $channel)
    {
        $this->channel = $channel;
    }
}