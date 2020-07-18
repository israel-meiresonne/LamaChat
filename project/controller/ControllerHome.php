<?php

require_once 'ControllerSecure.php';

class ControllerHome extends ControllerSecure
{
    public const CTR_NAME = "home";

    /**
     * ControllerHome's actions
     * @var string
     */
    public const ACTION_SEARCH_CONTACT = "home/searchContact";
    public const ACTION_ADD_CONTACT = "home/addContact";
    public const ACTION_REMOVE_CONTACT = "home/removeContact";
    public const ACTION_BLOCK_CONTACT = "home/blockContact";
    public const ACTION_UNLOCK_CONTACT = "home/unlockContact";
    public const ACTION_WRITE_CONTACT = "home/writeContact";
    public const ACTION_GET_CONTACT_TABLE = "home/getContactTable";

    /**
     * Access key for actions's responses
     * @var string
     */
    public const RSP_WRITE_MENU = "menu";
    public const RSP_WRITE_DISCU_FEED = "discuFeed";
    public const RSP_SEARCH_KEY = "searchWord";

    public function __construct()
    {
    }

    public function index()
    {
        $this->secureSession();
        $this->user->setProperties();
        $this->user->setDiscussions();
        $this->user->setContacts();
        $this->generateView(array("user" => $this->user));
    }

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
        $this->checkData(self::PSEUDO, self::KEY_PSEUDO, $_POST[self::KEY_PSEUDO], $response, true);
        if (!($response->containError())) {
            $pseudo = $_POST[self::KEY_PSEUDO];
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
        $this->checkData(self::PSEUDO, self::KEY_PSEUDO, $_POST[self::KEY_PSEUDO], $response, true);
        if (!($response->containError())) {
            $pseudo = $_POST[self::KEY_PSEUDO];
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
        $this->checkData(self::PSEUDO, self::KEY_PSEUDO, $_POST[self::KEY_PSEUDO], $response, true);
        if (!($response->containError())) {
            $pseudo = $_POST[self::KEY_PSEUDO];
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
        $this->checkData(self::PSEUDO, self::KEY_PSEUDO, $_POST[self::KEY_PSEUDO], $response, true);
        if (!($response->containError())) {
            $pseudo = $_POST[self::KEY_PSEUDO];
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
        $this->checkData(self::PSEUDO, self::KEY_PSEUDO, $_POST[self::KEY_PSEUDO], $response, true);
        if (!($response->containError())) {
            $pseudo = $_POST[self::KEY_PSEUDO];
            $this->user->setProperties();
            $discu = $this->user->writeContact($pseudo, $response);
            if ((!empty($discu)) && (!$response->containError())) {
                $corresp = $discu->getCorrespondent($this->user->getPseudo());
                ob_start();
                require 'view/Home/elements/discussionMenu.php';
                $discuMenu = ob_get_clean();

                $user = $this->user;
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
            ob_start();
            require 'view/Home/elements/contactTable.php';
            $ctcTable = ob_get_clean();
            $response->addResult(self::ACTION_GET_CONTACT_TABLE, $ctcTable);
        } else {
            $ctcTable = "Aucun résultat!";
        }
        echo json_encode($response->getAttributs());
    }
}
