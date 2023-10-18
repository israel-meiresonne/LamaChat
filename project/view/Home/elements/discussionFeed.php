<?php
require_once 'model/User.php';
require_once 'model/Discussion.php';
require_once 'model/Message.php';
/**
 * @param User $user current user
 * @param Discussion $discu current user's discussion with participants
 */
$discuID = $discu->getDiscuID();
?>
<div id="<?= $discuID ?>" class="msg-window w3-container person">
    <div class="msg-background"></div>
    <div class="msg-window-inner">
        <div class="msg-window-feed">
            <?php
            /**
             * @var Message[]
             */
            $messages = $discu->getMessages();
            $date = null;
            foreach ($messages as $message) :
                if ($date != $message->getFormatDate()) :
                    $date = $message->getFormatDate();
            ?>
                    <div class="msg-wrap">
                        <div class="msg-date">
                            <span><?= $date ?></span>
                        </div>
                    </div>
            <?php
                endif;
                require 'view/Home/elements/discussionMessage.php';
            endforeach;
            ?>
        </div>
    </div>
    <div class="msg_sender-container">
        <div class="msg_sender">
            <?php
            $btnTxtId = Discussion::generateDateCode(25);
            ?>
            <div class="msg_sender-inner">
                <div class="msg_sender-placeholder">Entrer votre message</div>
                <div class="msg_sender-input" data-btnId="<?= $btnTxtId ?>" contenteditable="true"></div>
            </div>
        </div>
        <div class="msg_sender-button-set">
            <div class="msg_sender-button-div">

                <button id="<?= $btnTxtId ?>" class="img-button remove-button-default-att" onclick="sendMessage('<?= $discuID ?>')">
                    <img src="content/images/static/icons8-email-send-96.png">
                </button>
            </div>
        </div>
    </div>
</div>