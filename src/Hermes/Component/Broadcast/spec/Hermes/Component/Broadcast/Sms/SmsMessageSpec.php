<?php

namespace spec\Hermes\Component\Broadcast\Sms;

use Hermes\Component\Broadcast\Sms\SmsMessage;
use Hermes\Component\Broadcast\Sms\SmsTransport;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SmsMessageSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SmsMessage::class);
    }
    
    function let()
    {
        $this->beConstructedWith('Sms message');
    }
    
    function it_can_get_text()
    {
        $this->getText()->shouldReturn('Sms message');
    }
    
    function it_can_return_transport()
    {
        $this->getTransport()->shouldReturn(SmsTransport::class);
    }
}
