<?php

namespace spec\Hermes\Component\Broadcast;

use Hermes\Component\Broadcast\Channel\SubscriptionInterface;
use Hermes\Component\Broadcast\Receiver\ReceiverInterface;
use Hermes\Component\Broadcast\Transport\AddressInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Hermes\Component\Broadcast\Transport\TransportInterface;
use Hermes\Component\Broadcast\Channel\ChannelInterface;
use Hermes\Component\Broadcast\Message\Message;

class BroadcasterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Hermes\Component\Broadcast\Broadcaster');
    }

    function let(TransportInterface $transport, ChannelInterface $channel)
    {
        $channel->getName()->willReturn('soccer_team');
        $channel->addSubscription(Argument::any())->willReturn();
        $transport->getName()->willReturn('onesignal');
        $transportArray = array('onesignal' => $transport);
        $channelArray = array('soccer_team' => $channel);
        $this->beConstructedWith($transportArray, $channelArray);
    }

    function it_can_add_transport(TransportInterface $transport1)
    {
        $this->addTransport($transport1);
    }

    function it_can_add_channel(ChannelInterface $channel1)
    {
        $this->addChannel($channel1);
    }

    function it_can_subscribe(ReceiverInterface $receiver, ChannelInterface $channel, AddressInterface $address)
    {
        $receiver->getAddressByTransport('onesignal')->willReturn($address);
        $this->subscribe($receiver, 'onesignal', 'soccer_team');
        $channel->addSubscription(Argument::any())->shouldBeCalled();
    }

    function it_can_fail_subscribing_an_user_without_correct_address(ReceiverInterface $receiver, ChannelInterface $channel)
    {
        $receiver->getAddressByTransport('onesignal')->willThrow('Hermes\Component\Broadcast\Receiver\AddressNotFoundException');
        $this->shouldThrow('Hermes\Component\Broadcast\Receiver\AddressNotFoundException')->duringSubscribe($receiver,
            'onesignal', 'soccer_team');
    }

    function it_can_broadcast_messages(Message $message, TransportInterface $transport)
    {
        //todo: to be completed
    }
}
