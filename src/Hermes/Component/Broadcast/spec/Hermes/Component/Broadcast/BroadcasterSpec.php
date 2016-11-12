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
use Hermes\Component\Broadcast\Event\BroadcastFlushEvent;
use Hermes\Component\Broadcast\Event\SubscriptionEvent;
use Hermes\Component\Broadcast\Exception\AddressNotFoundException;
use Hermes\Component\Broadcast\Message\MessageInterface;
use Hermes\Component\Broadcast\Receiver\ReceiverInterface;
use Hermes\Component\Broadcast\Repository\SubscriptionRepositoryInterface;
use Hermes\Component\Broadcast\Repository\TransportRepositoryInterface;
use Hermes\Component\Broadcast\Sms\SmsTransport;
use Hermes\Component\Broadcast\Subscription\SubscriptionFactory;
use Hermes\Component\Broadcast\Subscription\SubscriptionInterface;
use Hermes\Component\Broadcast\Transport\TransportInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Prophecy\Promise\ThrowPromise;
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
        SubscriptionFactory $subscriptionFactory
    ) {
        $this->beConstructedWith($transportRepository, $subscriptionRepository, $subscriptionFactory, $eventDispatcher);
    }

    public function it_can_subscribe(SubscriptionFactory $subscriptionFactory, ReceiverInterface $receiver, SubscriptionInterface $subscription, EventDispatcher $eventDispatcher)
    {
        $subscriptionFactory->create($receiver, 'ios.push_notification', 'brainrepo_soccer_friends', 153723263)->willReturn($subscription);
        $this->subscribe($receiver, 'ios.push_notification', 'brainrepo_soccer_friends', 153723263);
        $eventDispatcher->dispatch(SubscriptionEvent::STARTED, Argument::any())->shouldHaveBeenCalled();
        $eventDispatcher->dispatch(SubscriptionEvent::ENDED, Argument::any())->shouldHaveBeenCalled();
    }

    public function it_can_fail_during_subscription(SubscriptionFactory $subscriptionFactory, ReceiverInterface $receiver, EventDispatcher $eventDispatcher)
    {
        $subscriptionFactory->create($receiver, 'ios.push_notification', 'brainrepo_soccer_friends', 153723263)->will(new ThrowPromise(new AddressNotFoundException()));
        $this->subscribe($receiver, 'ios.push_notification', 'brainrepo_soccer_friends', 153723263);
        $eventDispatcher->dispatch(SubscriptionEvent::FAILED, Argument::any())->shouldHaveBeenCalled();
    }

    public function it_can_broadcast_on_all_tranports(
        MessageInterface $message,
        EventDispatcher $eventDispatcher,
        TransportRepositoryInterface $transportRepository,
        SubscriptionRepositoryInterface $subscriptionRepository,
        SmsTransport $transportSms,
        TransportInterface $transportEmail,
        SubscriptionInterface $subscription
    ) {
        $channelId = 'brainrepo_soccer_friends';
        $transportRepository->getByTransportClasses(null)->willReturn([$transportSms, $transportEmail]);
        $subscriptionRepository->findByChannelAndTransport($channelId, get_class($transportSms->getWrappedObject()))->willReturn([$subscription]);
        $subscriptionRepository->findByChannelAndTransport($channelId, get_class($transportEmail->getWrappedObject()))->willReturn([]);
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
        SmsTransport $transportSms1,
        TransportInterface $transportEmail,
        SubscriptionInterface $subscription
    ) {
        $channelId = 'brainrepo_soccer_friends';
        $transportRepository->getByTransportClasses(['ios.push_notification'])->willReturn([$transportSms1]);
        $subscriptionRepository->findByChannelAndTransport($channelId, get_class($transportSms1->getWrappedObject()))->willReturn([$subscription]);
        $this->broadcast($message, $channelId, ['ios.push_notification']);
        $transportSms1->queue($subscription, $message)->shouldHaveBeenCalled();
        $transportEmail->queue($subscription, $message)->shouldNotHaveBeenCalled();
        $eventDispatcher->dispatch(BroadcastEvent::STARTED, Argument::any())->shouldHaveBeenCalled();
        $eventDispatcher->dispatch(BroadcastEvent::PREPARED_FOR_QUEUE, Argument::any())->shouldHaveBeenCalled();
        $eventDispatcher->dispatch(BroadcastEvent::QUEUED, Argument::any())->shouldHaveBeenCalled();
        $eventDispatcher->dispatch(BroadcastEvent::ENDED, Argument::any())->shouldHaveBeenCalled();
    }

    public function it_can_flush(TransportRepositoryInterface $transportRepository, TransportInterface $transportSms,
                                 TransportInterface $transportEmail, EventDispatcher $eventDispatcher)
    {
        $transportRepository->findAll()->willReturn([$transportSms, $transportEmail]);

        $this->flush();
        $transportSms->flush()->shouldHaveBeenCalled();
        $transportEmail->flush()->shouldHaveBeenCalled();
        $eventDispatcher->dispatch(BroadcastFlushEvent::STARTED, Argument::any())->shouldHaveBeenCalled();
        $eventDispatcher->dispatch(BroadcastFlushEvent::PREPARED_FOR_FLUSH, Argument::any())->shouldHaveBeenCalled();
        $eventDispatcher->dispatch(BroadcastFlushEvent::FLUSHED, Argument::any())->shouldHaveBeenCalled();
        $eventDispatcher->dispatch(BroadcastFlushEvent::ENDED, Argument::any())->shouldHaveBeenCalled();
    }
}
