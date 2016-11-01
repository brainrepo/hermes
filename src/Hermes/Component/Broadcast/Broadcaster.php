<?php

/**
 *
 *  This file is part of the Hermes package.
 *
 *  (c) Mauro Murru (Brainrepo) <murru7@gmail.com>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 */

namespace Hermes\Component\Broadcast;

use Hermes\Component\Broadcast\Channel\Channel;
use Hermes\Component\Broadcast\Channel\ChannelInterface;
use Hermes\Component\Broadcast\Channel\ChannelRepository;
use Hermes\Component\Broadcast\Channel\ChannelNotFoundException;
use Hermes\Component\Broadcast\Channel\Events\ChannelCreatedEvent;
use Hermes\Component\Broadcast\Channel\Events\ChannelEvent;
use Hermes\Component\Broadcast\Channel\Events\SubscriptionEndedEvent;
use Hermes\Component\Broadcast\Channel\Events\SubscriptionEvent;
use Hermes\Component\Broadcast\Channel\Events\SubscriptionStartedEvent;
use Hermes\Component\Broadcast\Channel\Subscription;
use Hermes\Component\Broadcast\Message\Message;
use Hermes\Component\Broadcast\Receiver\AddressNotFoundException;
use Hermes\Component\Broadcast\Receiver\ReceiverInterface;
use Hermes\Component\Broadcast\Transport\TransportInterface;
use Hermes\Component\Broadcast\Transport\TransportRepository;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Monolog\Logger;

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
     * @param TransportRepository $transportRepository
     * @param ChannelRepository $channelRepository
     * @param EventDispatcher $eventDispatcher
     */
    public function __construct(
        TransportRepository $transportRepository,
        ChannelRepository $channelRepository,
        EventDispatcher $eventDispatcher
    )
    {
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

    public function broadcast(Message $message, $channelName)
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
