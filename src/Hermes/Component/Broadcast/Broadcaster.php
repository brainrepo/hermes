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

namespace Hermes\Component\Broadcast;

use Hermes\Component\Broadcast\Event\ChannelCreatedEvent;
use Hermes\Component\Broadcast\Event\SubscriptionEndedEvent;
use Hermes\Component\Broadcast\Event\SubscriptionStartedEvent;
use Hermes\Component\Broadcast\Exception\AddressNotFoundException;
use Hermes\Component\Broadcast\Model\ChannelInterface;
use Hermes\Component\Broadcast\Model\MessageInterface;
use Hermes\Component\Broadcast\Model\ReceiverInterface;
use Hermes\Component\Broadcast\Model\Subscription;
use Hermes\Component\Broadcast\Model\TransportInterface;
use Hermes\Component\Broadcast\Repository\ChannelRepository;
use Hermes\Component\Broadcast\Repository\TransportRepository;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Broadcaster
{
    /**
     * @var TransportRepository
     */
    protected $transportRepository;

    /**
     * @var ChannelRepository
     */
    protected $channelRepository;

    /**
     * @var EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * Broadcaster constructor.
     *
     * @param TransportRepository $transportRepository
     * @param ChannelRepository   $channelRepository
     * @param EventDispatcher     $eventDispatcher
     */
    public function __construct(
        TransportRepository $transportRepository,
        ChannelRepository $channelRepository,
        EventDispatcher $eventDispatcher
    ) {
        $this->transportRepository = $transportRepository;
        $this->channelRepository = $channelRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param TransportInterface $transport
     */
    public function addTransport(TransportInterface $transport)
    {
        $this->transportRepository->add($transport);
    }

    /**
     * @param ChannelInterface $channel
     */
    public function addChannel(ChannelInterface $channel)
    {
        $this->channelRepository->add($channel);
    }

    public function subscribe(ReceiverInterface $receiver, $transportName, $channelName)
    {
        try {
            $address = $receiver->getAddressByTransport($transportName);
            $subscription = new Subscription($address, $transportName);

            $this->eventDispatcher->dispatch('hermes.broadcast.channel.subscription.started', new SubscriptionStartedEvent($subscription));

            $eventDispatcher = $this->eventDispatcher;
            $this->channelRepository->findOneOrCreate($channelName, function (ChannelInterface $channel) use ($eventDispatcher) {
                $eventDispatcher->dispatch('hermes.broadcast.channel.create', new ChannelCreatedEvent($channel));
            })->addSubscription($subscription);

            $this->eventDispatcher->dispatch('hermes.broadcast.channel.subscription.ended', new SubscriptionEndedEvent($subscription));
        } catch (AddressNotFoundException $exception) {
            throw new AddressNotFoundException(sprintf("I can't subscribe this receiver because it have not a valid address for %s transport", $transportName));
        }
    }

    public function broadcast(MessageInterface $message, $channelName)
    {
        //todo: to be implemented

        //nei transport spool butto i messaggi

        //spullo i transport
        //$channel->getSubscriptionsByTransport()
    }

    public function flush()
    {
        //todo: to be implemented
    }
}
