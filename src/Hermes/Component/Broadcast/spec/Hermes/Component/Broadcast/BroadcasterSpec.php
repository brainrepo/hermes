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

namespace spec\Hermes\Component\Broadcast;

use Hermes\Component\Broadcast\Broadcaster;
use Hermes\Component\Broadcast\Event\BroadcastEvent;
use Hermes\Component\Broadcast\Event\SubscriptionEvent;
use Hermes\Component\Broadcast\Factory\SubscriptionFactory;
use Hermes\Component\Broadcast\Model\MessageInterface;
use Hermes\Component\Broadcast\Model\ReceiverInterface;
use Hermes\Component\Broadcast\Model\SubscriptionInterface;
use Hermes\Component\Broadcast\Model\TransportInterface;
use Hermes\Component\Broadcast\Repository\SubscriptionRepositoryInterface;
use Hermes\Component\Broadcast\Repository\TransportRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcher;

class BroadcasterSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Broadcaster::class);
    }

    public function let(
        TransportRepositoryInterface $transportRepository,
        SubscriptionRepositoryInterface $subscriptionRepository,
        EventDispatcher $eventDispatcher,
        SubscriptionFactory $subscriptionFactory,
        TransportInterface $transportSms,
        TransportInterface $transportEmail
    )
    {
        $this->beConstructedWith($transportRepository, $subscriptionRepository, $subscriptionFactory, $eventDispatcher);
    }

    public function it_can_subscribe(SubscriptionFactory $subscriptionFactory, ReceiverInterface $receiver, SubscriptionInterface $subscription, EventDispatcher $eventDispatcher)
    {
        $subscriptionFactory->create($receiver, 'ios.push_notification', 'brainrepo_soccer_friends', 153723263)->willReturn($subscription);
        $this->subscribe($receiver, 'ios.push_notification', 'brainrepo_soccer_friends', 153723263);
        $eventDispatcher->dispatch(SubscriptionEvent::STARTED, Argument::any())->shouldHaveBeenCalled();
        $eventDispatcher->dispatch(SubscriptionEvent::ENDED, Argument::any())->shouldHaveBeenCalled();
    }

    public function it_can_broadcast_on_all_tranports(
        MessageInterface $message,
        EventDispatcher $eventDispatcher,
        TransportRepositoryInterface $transportRepository,
        SubscriptionRepositoryInterface $subscriptionRepository,
        TransportInterface $transportSms,
        TransportInterface $transportEmail,
        SubscriptionInterface $subscription
    )
    {
        $channelId = 'brainrepo_soccer_friends';
        $transportRepository->getByTransportIds(null)->willReturn(array($transportSms, $transportEmail));
        $subscriptionRepository->findByChannelAndTransport($channelId, $transportSms)->willReturn(array($subscription));
        $subscriptionRepository->findByChannelAndTransport($channelId, $transportEmail)->willReturn(array());
        $this->broadcast($message, $channelId, null);
        $transportSms->queue($subscription, $message)->shouldHaveBeenCalled();
        $transportEmail->queue($subscription, $message)->shouldNotHaveBeenCalled();
        $eventDispatcher->dispatch(BroadcastEvent::STARTED, Argument::any())->shouldHaveBeenCalled();
        $eventDispatcher->dispatch(BroadcastEvent::PREPARED_FOR_QUEUE, Argument::any())->shouldHaveBeenCalled();
        $eventDispatcher->dispatch(BroadcastEvent::QUEUED, Argument::any())->shouldHaveBeenCalled();
        $eventDispatcher->dispatch(BroadcastEvent::ENDED, Argument::any())->shouldHaveBeenCalled();
    }

    public function it_can_broadcast_on_only_one_transport(
        MessageInterface $message,
        EventDispatcher $eventDispatcher,
        TransportRepositoryInterface $transportRepository,
        SubscriptionRepositoryInterface $subscriptionRepository,
        TransportInterface $transportPush,
        TransportInterface $transportEmail,
        SubscriptionInterface $subscription
    )
    {
        $channelId = 'brainrepo_soccer_friends';
        $transportRepository->getByTransportIds(array('ios.push_notification'))->willReturn(array($transportPush));
        $subscriptionRepository->findByChannelAndTransport($channelId, $transportPush)->willReturn(array($subscription));
        $this->broadcast($message, $channelId, array('ios.push_notification'));
        $transportPush->queue($subscription, $message)->shouldHaveBeenCalled();
        $transportEmail->queue($subscription, $message)->shouldNotHaveBeenCalled();
        $eventDispatcher->dispatch(BroadcastEvent::STARTED, Argument::any())->shouldHaveBeenCalled();
        $eventDispatcher->dispatch(BroadcastEvent::PREPARED_FOR_QUEUE, Argument::any())->shouldHaveBeenCalled();
        $eventDispatcher->dispatch(BroadcastEvent::QUEUED, Argument::any())->shouldHaveBeenCalled();
        $eventDispatcher->dispatch(BroadcastEvent::ENDED, Argument::any())->shouldHaveBeenCalled();
    }
}
