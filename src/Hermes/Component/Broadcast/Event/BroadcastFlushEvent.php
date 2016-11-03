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

use Hermes\Component\Broadcast\Model\TransportInterface;
use Symfony\Component\EventDispatcher\Event;

class BroadcastFlushEvent extends Event
{
    const STARTED = 'hermes.broadcast.broadcast.flush_process.started';
    const PREPARED_FOR_FLUSH = 'hermes.broadcast.flushed';
    const FLUSHED = 'hermes.broadcast.flushed';
    const ENDED = 'hermes.broadcast.broadcast.flush_process.ended';

    /**
     * @var TransportInterface
     */
    protected $transport;

    /**
     * BroadcastFlushEvent constructor.
     *
     * @param $transport
     */
    public function __construct($transport = null)
    {
        $this->transport = $transport;
    }
}
