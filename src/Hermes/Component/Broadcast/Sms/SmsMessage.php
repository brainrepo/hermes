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


namespace Hermes\Component\Broadcast\Sms;

use Hermes\Component\Broadcast\Message\RawMessageInterface;

class SmsMessage implements RawMessageInterface
{
    /**
     * @var string
     */
    protected $text;

    /**
     * SmsMessage constructor.
     * @param string $text
     */
    public function __construct($text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getTransport()
    {
        return SmsTransport::class;
    }
}