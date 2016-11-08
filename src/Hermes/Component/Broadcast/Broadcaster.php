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

use Hermes\Component\Broadcast\Event\BroadcastEvent;
use Hermes\Component\Broadcast\Event\BroadcastFlushEvent;
use Hermes\Component\Broadcast\Event\MessageQueuedEvent;
use Hermes\Component\Broadcast\Event\SubscriptionEndedEvent;
use Hermes\Component\Broadcast\Event\SubscriptionEvent;
use Hermes\Component\Broadcast\Event\SubscriptionStartedEvent;
use Hermes\Component\Broadcast\Factory\SubscriptionFactory;
use Hermes\Component\Broadcast\Message\MessageInterface;
use Hermes\Component\Broadcast\Receiver\ReceiverInterface;
use Hermes\Component\Broadcast\Repository\SubscriptionRepositoryInterface;
use Hermes\Component\Broadcast\Repository\TransportRepositoryInterface;
use Hermes\Component\Broadcast\Subscription\SubscriptionInterface;
use Hermes\Component\Broadcast\Transport\TransportInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Broadcaster
{
    /**
     * @var TransportRepositoryInterface
     */
    protected $transportRepository;

    /**
     * @var SubscriptionRepositoryInterface
     */
    protected $subscriptionRepository;

    /**
     * @var SubscriptionFactory
     */
    protected $subscriptionFactory;

    /**
     * @var EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * Broadcaster constructor.
     *
     * @param TransportRepositoryInterface    $transportRepository
     * @param SubscriptionRepositoryInterface $subscriptionRepository
     * @param SubscriptionFactory             $subscriptionFactory
     * @param EventDispatcher                 $eventDispatcher
     */
    public function __construct(
        TransportRepositoryInterface $transportRepository,
        SubscriptionRepositoryInterface $subscriptionRepository,
        SubscriptionFactory $subscriptionFactory,
        EventDispatcher $eventDispatcher
    ) {
        $this->transportRepository = $transportRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->eventDispatcher = $eventDispatcher;
        $this->subscriptionFactory = $subscriptionFactory;
    }

    /**
     * @param ReceiverInterface $receiver
     * @param $transportId
     * @param $channelId
     */
    public function subscribe(ReceiverInterface $receiver, $transportId, $channelId, $lifetime)
    {
        $subscription = $this->subscriptionFactory->create($receiver, $transportId, $channelId, $lifetime);
        $this->eventDispatcher->dispatch(SubscriptionEvent::STARTED, new SubscriptionStartedEvent($subscription));
        $this->subscriptionRepository->add($subscription);
        $this->eventDispatcher->dispatch(SubscriptionEvent::ENDED, new SubscriptionEndedEvent($subscription));
    }

    /**
     * @param MessageInterface $message
     * @param $channelId
     * @param null $allowedTransports if null send on all transports
     */
    public function broadcast(MessageInterface $message, $channelId, $allowedTransports = null)
    {
        $this->eventDispatcher->dispatch(BroadcastEvent::STARTED, new BroadcastEvent($message, $channelId));

        $transports = $this->transportRepository->getByTransportIds($allowedTransports);

        array_map(function (TransportInterface $transport) use ($message, $channelId) {
            $subscriptions = $this->subscriptionRepository->findByChannelAndTransport($channelId, $transport);
            array_map(function (SubscriptionInterface $subscription) use ($message, $transport, $channelId) {
                $this->eventDispatcher->dispatch(BroadcastEvent::PREPARED_FOR_QUEUE, new MessageQueuedEvent($message, $channelId, $transport));
                $transport->queue($subscription, $message);
                $this->eventDispatcher->dispatch(BroadcastEvent::QUEUED, new MessageQueuedEvent($message, $channelId, $transport));
            }, $subscriptions);
        }, $transports);
        $this->eventDispatcher->dispatch(BroadcastEvent::ENDED, new BroadcastEvent($message, $channelId));
    }

    public function flush()
    {
        $this->eventDispatcher->dispatch(BroadcastFlushEvent::STARTED, new BroadcastFlushEvent(null));
        array_map(function (TransportInterface $transport) {
            $this->eventDispatcher->dispatch(BroadcastFlushEvent::PREPARED_FOR_FLUSH, new BroadcastFlushEvent($transport));
            $transport->flush(); //TODO: Implement error return
            $this->eventDispatcher->dispatch(BroadcastFlushEvent::FLUSHED, new BroadcastFlushEvent($transport));
        }, $this->transportRepository->findAll());
        $this->eventDispatcher->dispatch(BroadcastFlushEvent::ENDED, new BroadcastFlushEvent(null));
    }
}
