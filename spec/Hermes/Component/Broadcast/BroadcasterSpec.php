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

namespace spec\Hermes\Component\Broadcast;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Hermes\Component\Broadcast\Receiver\ReceiverInterface;
use Hermes\Component\Broadcast\Transport\AddressInterface;
use Hermes\Component\Broadcast\Transport\TransportInterface;
use Hermes\Component\Broadcast\Channel\ChannelInterface;
use Hermes\Component\Broadcast\Channel\ChannelRepository;
use Hermes\Component\Broadcast\Transport\TransportRepository;

class BroadcasterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Hermes\Component\Broadcast\Broadcaster');
    }

    function let(TransportInterface $transport,
                 ChannelInterface $channel,
                 TransportRepository $transportRepository,
                 ChannelRepository $channelRepository,
                 EventDispatcher $eventDispatcher
    )
    {
        $channel->getName()->willReturn('soccer_team');
        $channel->addSubscription(Argument::any())->willReturn();
        $channelRepository->getById('soccer_team')->willReturn($channel);
        $channelRepository->add(Argument::any())->willReturn();

        $transport->getName()->willReturn('ios.push_notification');
        $transportRepository->add(Argument::any())->willReturn();
        $transportRepository->getById('ios.push_notification')->willReturn($transport);

        $this->beConstructedWith($transportRepository, $channelRepository, $eventDispatcher);
    }

    function it_can_add_transport(TransportInterface $transport1)
    {
        $this->addTransport($transport1);
    }

    function it_can_add_channel(ChannelInterface $channel1)
    {
        $this->addChannel($channel1);
    }

    function it_can_subscribe(
        ReceiverInterface $receiver,
        ChannelInterface $channel,
        ChannelRepository $channelRepository,
        AddressInterface $address,
        EventDispatcher $eventDispatcher
    )
    {
        $channelRepository->findOneOrCreate('soccer_team', Argument::any())->willReturn($channel);
        $receiver->getAddressByTransport('ios.push_notification')->willReturn($address);
        $eventDispatcher->dispatch('hermes.broadcast.channel.subscription.started', Argument::any())->shouldBeCalled();
        $eventDispatcher->dispatch('hermes.broadcast.channel.subscription.ended', Argument::any())->shouldBeCalled();
        $channel->addSubscription(Argument::any(), Argument::any())->shouldBeCalled();

        //Todo: find a method to define the callback to check $eventDispatcher->dispatch('hermes.broadcast.channel.create', Argument::any())->shouldBeCalled();
        $this->subscribe($receiver, 'ios.push_notification', 'soccer_team');
    }

    function it_can_fail_subscribing_an_user_without_correct_address(ReceiverInterface $receiver, ChannelInterface $channel)
    {
        $receiver->getAddressByTransport('ios.push_notification')->willThrow('Hermes\Component\Broadcast\Receiver\AddressNotFoundException');
        $this->shouldThrow('Hermes\Component\Broadcast\Receiver\AddressNotFoundException')->duringSubscribe($receiver,
            'ios.push_notification', 'soccer_team');
    }

    //todo: to be completed
//    function it_can_broadcast_messages(Message $message, TransportInterface $transport)
//    {
//
//    }
}
