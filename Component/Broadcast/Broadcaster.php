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
use Hermes\Component\Broadcast\Channel\Subscription;
use Hermes\Component\Broadcast\Message\Message;
use Hermes\Component\Broadcast\Receiver\AddressNotFoundException;
use Hermes\Component\Broadcast\Receiver\ReceiverInterface;
use Hermes\Component\Broadcast\Transport\TransportInterface;
use Hermes\Component\Broadcast\Channel\ChannelNotFoundException;

class Broadcaster
{

    /**
     * @var array
     */
    protected $transports = array();

    /**
     * @var array
     */
    protected $channels = array();


    /**
     * Broadcaster constructor.
     * @param array $transportArray
     * @param array $channelArray
     */
    public function __construct($transportArray = array(), $channelArray = array())
    {
        //Todo: use monolog to log errors
        //Todo: use event hendler
        $this->transports = $transportArray;
        $this->channels = $channelArray;
    }

    /**
     * @param TransportInterface $transport
     */
    public function addTransport(TransportInterface $transport)
    {
        $this->transports[$transport->getName()] = $transport;
    }

    /**
     * @param ChannelInterface $channel
     */
    public function addChannel(ChannelInterface $channel)
    {
        $this->channels[$channel->getName()] = $channel;
    }

    public function subscribe(ReceiverInterface $receiver, $transportName, $channelName)
    {
        try {
            $address = $receiver->getAddressByTransport($transportName);
            $subscription = new Subscription($address, $transportName);

            if (!array_key_exists($channelName, $this->channels)) {
                $this->channels[$channelName] = new Channel($channelName);
            }

            $this->channels[$channelName]->addSubscription($subscription);

        } catch (AddressNotFoundException $exception) {
            throw new AddressNotFoundException(sprintf("I can't subscrive this receiver because it have not a valid address for %s transport", $transportName));
        }
    }

    public function broadcast(Message $message, $channelName)
    {
        //todo: to be implemented
        $channel = $this->getChannelByName($channelName);


        //nei transport spool butto i messaggi

        //spullo i transport
        //$channel->getSubscriptionsByTransport()
    }

    public function flush()
    {
        //todo: to be implemented
    }

    /**
     * @param $name
     * @return Channel
     * @throws ChannelNotFoundException
     */
    private function getChannelByName($name)
    {
        if (!array_key_exists($name, $this->channels)) {
            throw new ChannelNotFoundException(sprintf('There is not %s channel.', $name));
        }

        return $this->channels[$name];
    }
}
