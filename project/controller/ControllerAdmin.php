<?php

require_once 'ControllerSecure.php';
require_once 'model/Chart.php';

class ControllerAdmin extends ControllerSecure
{
    /**
     * Holds the sql function to get date
     */
    private const FUNC_DAY = "date";

    public function index()
    {
        $this->secureSession();
        $this->user->setProperties();
        $this->user->setDiscussions();
        $this->user->setContacts();

        $nbUser = User::getNbUsers();
        $nbDiscussion = Discussion::getNbDiscussion();
        $chatChart = Discussion::discussionPerTime("chat_board", self::FUNC_DAY);
        $nbMessage = Message::getNbMessage();
        $msgChart = Message::messagePerTime("message_board", self::FUNC_DAY);
        
        $datas = [
            "user" => $this->user,
            "nbUser" => $nbUser,
            "nbDiscussion" => $nbDiscussion,
            "nbMessage" => $nbMessage,
            "msgChart" => $msgChart,
            "chatChart" => $chatChart,
        ];
        $this->generateView($datas);
    }
}
