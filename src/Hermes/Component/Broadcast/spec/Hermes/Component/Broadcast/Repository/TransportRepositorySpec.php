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

namespace spec\Hermes\Component\Broadcast\Repository;

use Hermes\Component\Broadcast\Repository\TransportRepository;
use Hermes\Component\Broadcast\Sms\SmsTransport;
use Hermes\Component\Broadcast\Transport\BaseTransport;
use Hermes\Component\Broadcast\Transport\TransportInterface;
use PhpSpec\ObjectBehavior;

class TransportRepositorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(TransportRepository::class);
    }

    public function it_can_add_transport(TransportInterface $transport)
    {
        $this->add($transport->getWrappedObject());
        $this->getByClass(get_class($transport->getWrappedObject()))->shouldReturn($transport);
    }

    public function it_can_get_transport_by_classes(TransportInterface $transport, SmsTransport $transport1, BaseTransport $baseTransport)
    {
        $this->add($transport->getWrappedObject());
        $this->add($transport1->getWrappedObject());
        $this->getByTransportClasses([get_class($transport->getWrappedObject()), get_class($transport1->getWrappedObject())])->shouldReturn([$transport->getWrappedObject(), $transport1->getWrappedObject()]);
    }

    public function it_can_find_all(TransportInterface $transport, SmsTransport $transport1, BaseTransport $baseTransport)
    {
        $this->add($transport->getWrappedObject());
        $this->add($transport1->getWrappedObject());
        $this->add($baseTransport->getWrappedObject());

        $this->findAll()->shouldHaveCount(3);
    }
}
