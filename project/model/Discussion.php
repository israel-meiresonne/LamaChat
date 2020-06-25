<?php
/**
 * This class represents a Discussion
 */
class Discussion
{
    /**
     * Holds discussion's identifiant
     * @var string
     */
    private $discuID;

    /**
     * Holds discussion's name given by the user
     * @var string
     */
    private $discuName;

    /**
     * Holds discussion's participant
     * @var User[]
     */
    private $participants;

    /**
     * Holds discussion's creation date
     * @var string
     */
    private $setDate;

    /**
     * Holds discussion's messages
     * NOTE: use as access key the unix time of the creation date of the message
     * @var Message[]
     */
    private $messages;
}
