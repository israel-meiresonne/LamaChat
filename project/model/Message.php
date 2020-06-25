<?php

/**
 * This class represents a Discussion
 */
class Message
{
    /**
     * Holds the message's identifiant
     * @var string
     */
    private $msgID;

    /**
     * Holds the message's sender
     * @var User
     */
    private $from;

    /**
     * Holds the message's type(text, picture, file, audio,...)
     * @var string
     */
    private $type;

    /**
     * Holds the message's message
     * @var string
     */
    private $msg;

    /**
     * Holds message's send date
     * @var string
     */
    private $setDate;
}
