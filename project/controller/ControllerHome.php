<?php

require_once 'ControllerSecure.php';
require_once 'model/Discussion.php';
require_once 'model/Message.php';

class ControllerHome extends ControllerSecure
{
    public const CTR_NAME = "home";

    /**
     * ControllerHome's actions
     * @var string
     */
    public const ACTION_MESSAGE = "message";
    public const ACTION_BANISHED = "banished";
    public const ACTION_DELETED = "deleted";
    public const ACTION_SEARCH_CONTACT = "home/searchContact";
    public const ACTION_ADD_CONTACT = "home/addContact";
    public const ACTION_REMOVE_CONTACT = "home/removeContact";
    public const ACTION_BLOCK_CONTACT = "home/blockContact";
    public const ACTION_UNLOCK_CONTACT = "home/unlockContact";
    public const ACTION_WRITE_CONTACT = "home/writeContact";
    public const ACTION_GET_CONTACT_TABLE = "home/getContactTable";
    public const ACTION_SIGN_OUT = "home/signOut";
    public const ACTION_REMOVE_DISCU = "home/removeDiscussion";
    public const ACTION_OPEN_PROFILE = "home/getProfile";
    public const ACTION_UPDATE_PROFILE = "home/updateProfile";
    public const ACTION_SEND_MSG = "home/sendMessage";
    public const ACTION_UPDATE_FEED = "home/updateFeed";
    public const ACTION_UPDATE_HOME = "home/updateHome";
    public const ACTION_READ_MSG = "home/readMessage";

    /**
     * Access key for actions's responses
     * @var string
     */
    // public const RSP_GET_NOTIF = "getnitif"; // don't forget
    public const RSP_WRITE_MENU = "menu";
    public const RSP_WRITE_DISCU_FEED = "discuFeed";
    public const RSP_SEARCH_KEY = "searchWord";

    public const CONTACT_WINDOW_ID = "contact_window";
    public const SEARCH_WINDOW_ID = "search_window";

    public function index()
    {
        $this->secureSession();
        $this->user->setProperties();
        $this->user->setDiscussions();
        $this->user->setContacts();
        $this->generateView(array("user" => $this->user));
    }

    public function banished()
    {
        $this->secureSession();
        $datas = [
            "message" => "ce compte a été bani"
        ];
        $this->generateView($datas, self::ACTION_MESSAGE);
    }

    public function deleted()
    {
        $this->secureSession();
        $datas = [
            "message" => "ce compte n'existe plus"
        ];
        $this->generateView($datas, self::ACTION_MESSAGE);
    }

    /**
     * Sign out the current user
     */
    public function signOut()
    {
        $this->secureSession();
        $response = new Response();
        $this->destroyAccess();
        $webRoot = Configuration::get("webRoot", "/");
        $response->addResult(self::ACTION_SIGN_OUT, $webRoot . ControllerSign::CTR_NAME);
        echo json_encode($response->getAttributs());
    }

    /**
     * Look for contact
     */
    public function searchContact()
    {
        $this->secureSession();
        $response = new Response();
        $this->checkData(self::KEY_SEARCH, self::RSP_SEARCH_KEY, $_POST[self::RSP_SEARCH_KEY], $response);
        if (!($response->containError())) {
            $search = $_POST[self::RSP_SEARCH_KEY];
            $this->user->setProperties();
            $contacts = $this->user->searchContact($search, $response);
            if ((!$response->containError())) {
                if (count($contacts) > 0) {
                    $dataAttribut = "data-window='search_window'";
                    $windId = self::SEARCH_WINDOW_ID;
                    ob_start();
                    require 'view/Home/elements/contactTable.php';
                    $ctcTable = ob_get_clean();
                } else {
                    $ctcTable = "Aucun résultat!";
                }
                $response->addResult(self::RSP_SEARCH_KEY, $ctcTable);
            }
        }
        echo json_encode($response->getAttributs());
    }

    /**
     * Perform an add of a new contact to the current user
     */
    public function addContact()
    {
        $this->secureSession();
        $response = new Response();
        $this->checkData(self::PSEUDO, User::KEY_PSEUDO, $_POST[User::KEY_PSEUDO], $response, true);
        if (!($response->containError())) {
            $pseudo = $_POST[User::KEY_PSEUDO];
            $this->user->setProperties();
            $this->user->addContact($pseudo, $response);
            if (!($response->containError())) {
                $ctcPseu = $pseudo;
                $dataAttribut = "data-window='search_window'";
                // $relationship = User::BLOCKED;
                ob_start();
                require 'view/Home/elements/removeButton.php';
                $button = ob_get_clean();
                $response->addResult(self::ACTION_ADD_CONTACT, $button);
            }
        }
        echo json_encode($response->getAttributs());
    }

    /**
     * Perform an remove of a contact from the current user
     */
    public function removeContact()
    {
        $this->secureSession();
        $response = new Response();
        $this->checkData(self::PSEUDO, User::KEY_PSEUDO, $_POST[User::KEY_PSEUDO], $response, true);
        if (!($response->containError())) {
            $pseudo = $_POST[User::KEY_PSEUDO];
            $this->user->setProperties();
            $this->user->removeContact($pseudo, $response);
            if (!$response->containError()) {
                $ctcPseu = $pseudo;
                ob_start();
                require 'view/Home/elements/addButton.php';
                $button = ob_get_clean();
                $response->addResult(self::ACTION_ADD_CONTACT, $button);
            }
        }
        echo json_encode($response->getAttributs());
    }

    /**
     * Perform a blockage of a contact from the current user
     */
    public function blockContact()
    {
        $this->secureSession();
        $response = new Response();
        $this->checkData(self::PSEUDO, User::KEY_PSEUDO, $_POST[User::KEY_PSEUDO], $response, true);
        if (!($response->containError())) {
            $pseudo = $_POST[User::KEY_PSEUDO];
            $this->user->setProperties();
            $this->user->blockContact($pseudo, $response);
            if (!($response->containError())) {
                $ctcPseu = $pseudo;
                $relationship = User::BLOCKED;
                ob_start();
                require 'view/Home/elements/blockButton.php';
                $button = ob_get_clean();
                $response->addResult(self::ACTION_BLOCK_CONTACT, $button);
            }
        }
        echo json_encode($response->getAttributs());
    }

    /**
     * Perform a un lock of a contact from the current user
     */
    public function unlockContact()
    {
        $this->secureSession();
        $response = new Response();
        $this->checkData(self::PSEUDO, User::KEY_PSEUDO, $_POST[User::KEY_PSEUDO], $response, true);
        if (!($response->containError())) {
            $pseudo = $_POST[User::KEY_PSEUDO];
            $this->user->setProperties();
            $this->user->unlockContact($pseudo, $response);
            if (!($response->containError())) {
                $ctcPseu = $pseudo;
                $relationship = User::KNOW;
                ob_start();
                require 'view/Home/elements/blockButton.php';
                $button = ob_get_clean();
                $response->addResult(self::ACTION_UNLOCK_CONTACT, $button);
            }
        }
        echo json_encode($response->getAttributs());
    }

    /**
     * Create a new discussion between current user and his contact
     */
    public function writeContact()
    {
        $this->secureSession();
        $response = new Response();
        $this->checkData(self::PSEUDO, User::KEY_PSEUDO, $_POST[User::KEY_PSEUDO], $response, true);
        if (!($response->containError())) {
            $pseudo = $_POST[User::KEY_PSEUDO];
            $this->user->setProperties();
            $discu = $this->user->writeContact($pseudo, $response);
            if ((!empty($discu)) && (!$response->containError())) {
                $user = $this->user;
                $corresp = $discu->getCorrespondent($this->user->getPseudo());
                ob_start();
                require 'view/Home/elements/discussionMenu.php';
                $discuMenu = ob_get_clean();

                ob_start();
                require 'view/Home/elements/discussionFeed.php';
                $discuFeed = ob_get_clean();

                $response->addResult(Discussion::DISCU_ID, $discu->getDiscuID());
                $response->addResult(self::RSP_WRITE_MENU, $discuMenu);
                $response->addResult(self::RSP_WRITE_DISCU_FEED, $discuFeed);
            }
        }
        echo json_encode($response->getAttributs());
    }

    public function removeDiscussion()
    {
        $this->secureSession();
        $response = new Response();
        $this->checkData(self::ALPHA_NUMERIC, Discussion::DISCU_ID, $_POST[Discussion::DISCU_ID], $response, true);
        if (!$response->containError()) {
            $discuID = $_POST[Discussion::DISCU_ID];
            $this->user->setProperties();
            $this->user->removeDiscussion($discuID, $response);
            if (!$response->containError()) {
                $response->addResult(self::ACTION_REMOVE_DISCU, $discuID);
            }
        }
        echo json_encode($response->getAttributs());
    }

    /**
     * Provide the contact table
     */
    public function getContactTable()
    {
        $this->secureSession();
        $response = new Response();
        $this->user->setProperties();
        $this->user->setContacts();
        $contacts = $this->user->getContacts();
        if (count($contacts) > 0) {
            $dataAttribut = "data-window='contact_window'";
            $windId = self::CONTACT_WINDOW_ID;
            ob_start();
            require 'view/Home/elements/contactTable.php';
            $ctcTable = ob_get_clean();
            $response->addResult(self::ACTION_GET_CONTACT_TABLE, $ctcTable);
        } else {
            $message = "Vous n'avez aucun contact";
            ob_start();
            require 'view/Home/message.php';
            $messageHtml = ob_get_clean();
            $response->addResult(self::ACTION_GET_CONTACT_TABLE, $messageHtml);
        }
        echo json_encode($response->getAttributs());
    }

    /**
     * Provide a user's profile window content
     */
    public function getProfile()
    {
        $this->secureSession();
        $response = new Response();
        $this->checkData(self::PSEUDO, User::KEY_PSEUDO, $_POST[User::KEY_PSEUDO], $response, true);
        if (!$response->containError()) {
            $pseudo = $_POST[User::KEY_PSEUDO];
            $user = new User($pseudo);
            ob_start();
            require 'view/Home/elements/profileWindowContent.php';
            $profile = ob_get_clean();
            $response->addResult(self::ACTION_OPEN_PROFILE, $profile);
        }
        echo json_encode($response->getAttributs());
    }

    /**
     * Update user's profile
     */
    public function updateProfile()
    {
        $this->secureSession();
        $response = new Response();
        ($this->request->existingParameter(User::KEY_PSEUDO)) ? $this->checkData(self::PSEUDO, User::KEY_PSEUDO, $_POST[User::KEY_PSEUDO], $response) : null;
        ($this->request->existingParameter(User::KEY_FIRSTNAME)) ? $this->checkData(self::NAME, User::KEY_FIRSTNAME, $_POST[User::KEY_FIRSTNAME], $response) : null;
        ($this->request->existingParameter(User::KEY_LASTNAME)) ? $this->checkData(self::NAME, User::KEY_LASTNAME, $_POST[User::KEY_LASTNAME], $response) : null;
        ($this->request->existingParameter(User::KEY_STATUS)) ? $this->checkData(self::TEXT, User::KEY_STATUS, $_POST[User::KEY_STATUS], $response, false, User::STATUS_MAX_LENGTH) : null;
        ($this->request->existingParameter(User::KEY_PICTURE)) ? $this->checkData(self::FILE, User::KEY_PICTURE, $_FILES[User::KEY_PICTURE]['name'], $response) : null;
        ($this->request->existingParameter(User::KEY_BIRTHDATE)) ? $this->checkData(self::DATE, User::KEY_BIRTHDATE, $_POST[User::KEY_BIRTHDATE], $response) : null;

        $infoInputs = array_keys($this->user->getInfosInputName());
        if (count($infoInputs) > 0) {
            foreach ($infoInputs as $input) {
                if ($this->request->existingParameter($input)) {
                    $this->checkData(self::TEXT, $input, $this->request->getParameter($input), $response, false, User::INFO_MAX_LENGTH);
                }
            }
        }
        if (!$response->containError()) {
            $this->user->updateProperties($response, $this->request);
        }
        echo json_encode($response->getAttributs());
    }

    /**
     * To send textual a message
     */
    public function sendMessage()
    {
        $this->secureSession();
        $response = new Response();
        if ($this->request->existingParameter(Message::KEY_MESSAGE)) {
            $text = $this->request->getParameter(Message::KEY_MESSAGE);
            $this->checkData(self::TEXT, Message::KEY_MESSAGE, $text, $response, true, Message::MSG_MAX_LENGTH);
            $this->checkData(self::ALPHA_NUMERIC, Discussion::DISCU_ID, $_POST[Discussion::DISCU_ID], $response, true);
            if (!$response->containError()) {
                $discuID = $this->request->getParameter(Discussion::DISCU_ID);
                $message = $this->user->sendMessage($response, $discuID, $text);
                if (!$response->containError()) {
                    $user = $this->user;
                    ob_start();
                    require 'view/Home/elements/discussionMessage.php';
                    $msgHtml = ob_get_clean();

                    $text = $message->getPreview();
                    // $isNew = true;
                    ob_start();
                    require 'view/Home/elements/discussionMenuPreview.php';
                    $preview = ob_get_clean();
                    // $preview = "</p>" . $message->getPreview() . "</p>";

                    $response->addResult(self::ACTION_SEND_MSG, $msgHtml);
                    $response->addResult(Discussion::DISCU_ID, $discuID);
                    $response->addResult(Message::KEY_LAST_MSG, $preview);
                }
            }
        }
        echo json_encode($response->getAttributs());
    }

    /**
     * To mark all messages from a discussion as read
     */
    public function readMessage()
    {
        $this->secureSession();
        $response = new Response();
        $this->checkData(self::ALPHA_NUMERIC, Discussion::DISCU_ID, $_POST[Discussion::DISCU_ID], $response, true);
        if (!$response->containError()) {
            $discuID = $this->request->getParameter(Discussion::DISCU_ID);
            $this->user->readMessage($response, $discuID);
        }
        echo json_encode($response->getAttributs());
    }

    /**
     * To update feed's messages
     */
    public function updateHome()
    {
        $this->secureSession();
        $response = new Response();
        $status = ($this->request->existingParameter(Message::KEY_STATUS)) ? json_decode($this->request->getParameter(Message::KEY_STATUS)) : [];
        $lasts = ($this->request->existingParameter(Message::KEY_LAST_MSG)) ? json_decode($this->request->getParameter(Message::KEY_LAST_MSG)) : [];
        $discuIDs = ($this->request->existingParameter(Discussion::KEY_NEW_DISCU)) ? json_decode($this->request->getParameter(Discussion::KEY_NEW_DISCU)) : [];

        $toUpdate = [];
        if (isset($status)) {
            foreach ($status as $discuID => $msgIDs) {
                $ids = $this->user->checkMessageStatus($response, Message::MSG_STATUS_READ, $discuID, $msgIDs);
                (!empty($ids)) ? $toUpdate[$discuID] = $ids : null;
                // $toUpdate = array_merge($toUpdate, $ids);
            }
        }

        $foreignLastMsgs = [];
        $lastMsgs = [];
        if (isset($lasts)) {
            foreach ($lasts as $discuID => $msgID) {
                // $discussion = $this->user->getDiscussion($discuID);
                // var_dump($msgID);
                // $msgSetDate = $discussion->getMessage($msgID)->getSetDate();
                if (!empty($msgID)) {
                    $discussion = $this->user->getDiscussion($discuID);
                    $msgSetDate = $discussion->getMessage($msgID)->getSetDate();
                } else {
                    $msgSetDate = date('Y-m-d H:i:s', 0);
                }
                $messages = $this->user->getLastForeignMessages($response, $discuID, $msgSetDate);
                (count($messages) > 0) ? $foreignLastMsgs[$discuID] = $messages : null;
                // $foreignLastMsgs[$discuID] = $messages;

                $lastMsg = $this->user->getLastMessage($response, $discuID, $msgSetDate);
                (!empty($lastMsg)) ? $lastMsgs[$discuID] = $lastMsg : null;
            }
        }

        $newDiscus = [];
        if (isset($discuIDs)) {
            $newDiscus = $this->user->getNewDiscussions($discuIDs);
        }

        if (!$response->containError()) {
            (count($toUpdate) > 0) ? $response->addResult(Message::KEY_MSG_ID, $toUpdate) : null;
            (count($foreignLastMsgs) > 0) ? $response->addResult(Message::KEY_MESSAGE, $foreignLastMsgs) : null;
            (count($lastMsgs) > 0) ? $response->addResult(Message::KEY_LAST_MSG, $lastMsgs) : null;
            (count($newDiscus) > 0) ? $response->addResult(Discussion::KEY_NEW_DISCU, $newDiscus) : null;
            $response->addResult(Discussion::generateDateCode(25), "ok");
            $user = $this->user;
            $pseudo = $user->getPseudo();

            if ($response->existResult(Message::KEY_MSG_ID)) {
                // $newStatus = $response->getResult(Message::KEY_MSG_ID);
                ob_start();
                require 'view/Home/elements/discussionMessageStatusRead.php';
                $read = ob_get_clean();
                $response->addResult(Message::MSG_STATUS_READ, $read);
            }

            if ($response->existResult(Message::KEY_MESSAGE)) {
                $newForeignMsg = $response->getResult(Message::KEY_MESSAGE);
                $discuHtml = [];
                foreach ($newForeignMsg as $discuID => $messages) {
                    $msgHtmls = [];
                    foreach ($messages as $message) {
                        ob_start();
                        require 'view/Home/elements/discussionMessage.php';
                        $msgHtml = ob_get_clean();
                        array_push($msgHtmls, $msgHtml);
                    }
                    $discuHtml[$discuID] = $msgHtmls;
                }
                $response->addResult(Message::KEY_MESSAGE, $discuHtml);
            }

            if ($response->existResult(Message::KEY_LAST_MSG)) {
                $messages = $response->getResult(Message::KEY_LAST_MSG);
                $previews = [];
                foreach ($messages as $discuID => $message) {
                    $text = $message->getPreview();
                    $isNew = true;
                    ob_start();
                    require 'view/Home/elements/discussionMenuPreview.php';
                    $previews[$discuID] = ob_get_clean();
                }
                $response->addResult(Message::KEY_LAST_MSG, $previews);
            }

            if ($response->existResult(Discussion::KEY_NEW_DISCU)) {
                $discussions = $response->getResult(Discussion::KEY_NEW_DISCU);
                $discusHtml = [];
                foreach ($discussions as $unix => $discu) {

                    $corresp = $discu->getCorrespondent($pseudo);
                    ob_start();
                    require 'view/Home/elements/discussionMenu.php';
                    $navabar = ob_get_clean();

                    ob_start();
                    require 'view/Home/elements/discussionFeed.php';
                    $feed = ob_get_clean();
                    $discusHtml[$unix][Discussion::KEY_DISCU_MENU] = $navabar;
                    $discusHtml[$unix][Discussion::KEY_DISCU_FEED] = $feed;
                }
                $response->addResult(Discussion::KEY_NEW_DISCU, $discusHtml);
            }
        }



        // $response->addResult("key", $_POST);
        echo json_encode($response->getAttributs());
    }
}
