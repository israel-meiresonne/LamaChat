<?php

require_once 'ControllerSecure.php';
require_once 'model/Chart.php';

class ControllerAdmin extends ControllerSecure
{
    public const ACTION_PARDON_USER = "admin/pardonUser";
    public const ACTION_BANISH_USER = "admin/banishUser";
    public const ACTION_DELETE_USER = "admin/deleteUser";
    public const ACTION_RESTORE_USER = "admin/retsoreUser";

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
        $users = User::getUsers();
        $pseudo = $this->user->getPseudo();
        $users[$pseudo] = null;
        unset($users[$pseudo]);
        $nbDiscussion = Discussion::getNbDiscussion();
        $chatChart = Discussion::discussionPerTime("chat_board", self::FUNC_DAY);
        $nbMessage = Message::getNbMessage();
        $msgChart = Message::messagePerTime("message_board", self::FUNC_DAY);

        $datas = [
            "user" => $this->user,
            "users" => $users,
            "nbUser" => $nbUser,
            "nbDiscussion" => $nbDiscussion,
            "nbMessage" => $nbMessage,
            "msgChart" => $msgChart,
            "chatChart" => $chatChart,
        ];
        $this->generateView($datas);
    }

    /**
     * Update user's permission to 'user'
     */
    public function pardonUser()
    {
        $this->secureSession();
        $response = new Response();
        $this->checkData(self::PSEUDO, User::KEY_PSEUDO, $_POST[User::KEY_PSEUDO], $response);
        if (!$response->containError()) {
            $pseudo = $this->request->getParameter(User::KEY_PSEUDO);
            $this->updatePermission($response, $pseudo, User::PERMIT_USER, 'view/Admin/files/banishButton.php');
        }
        echo json_encode($response->getAttributs());
    }

    /**
     * Update user's permission to 'banished'
     */
    public function banishUser()
    {
        $this->secureSession();
        $response = new Response();
        $this->checkData(self::PSEUDO, User::KEY_PSEUDO, $_POST[User::KEY_PSEUDO], $response);
        if (!$response->containError()) {
            $pseudo = $this->request->getParameter(User::KEY_PSEUDO);
            $this->updatePermission($response, $pseudo, User::PERMIT_BANISHED, 'view/Admin/files/banishButton.php');
        }
        echo json_encode($response->getAttributs());
    }

    /**
     * Delete user
     */
    public function deleteUser()
    {
        $this->secureSession();
        $response = new Response();
        $this->checkData(self::PSEUDO, User::KEY_PSEUDO, $_POST[User::KEY_PSEUDO], $response);
        if (!$response->containError()) {
            $pseudo = $this->request->getParameter(User::KEY_PSEUDO);
            $this->updatePermission($response, $pseudo, User::PERMIT_DELETED, 'view/Admin/files/deleteButton.php');
        }
        echo json_encode($response->getAttributs());
    }

    /**
     * Restore a deleted user
     */
    public function retsoreUser()
    {
        $this->secureSession();
        $response = new Response();
        $this->checkData(self::PSEUDO, User::KEY_PSEUDO, $_POST[User::KEY_PSEUDO], $response);
        if (!$response->containError()) {
            $pseudo = $this->request->getParameter(User::KEY_PSEUDO);
            $this->updatePermission($response, $pseudo, User::PERMIT_USER, 'view/Admin/files/deleteButton.php');
        }
        echo json_encode($response->getAttributs());
    }

    /**
     * Update user's permission
     */
    private function updatePermission(Response $response, $pseudo, $permi, $file)
    {
        $this->user->updatePermission($response, $pseudo, $permi);
        if (!$response->containError()) {
            $user = $this->user->getUser($pseudo);
            ob_start();
            require $file;
            $btn = ob_get_clean();
            $response->addResult(User::PERMIT_ADMIN, $btn);
            $response->addResult(User::KEY_PERMISSION, $permi);
        }
    }
}
