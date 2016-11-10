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

namespace spec\Hermes\Component\Broadcast\Sms;

use Hermes\Component\Broadcast\Sms\SmsAddress;
use PhpSpec\ObjectBehavior;

class SmsAddressSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(SmsAddress::class);
    }

    public function let()
    {
        $this->beConstructedWith('393492977246');
    }

    public function it_can_get_mobile_phone_number()
    {
        $this->getMobilePhoneNumber()->shouldReturn('393492977246');
    }
}
