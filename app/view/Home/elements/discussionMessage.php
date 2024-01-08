<?php

require_once 'model/User.php';
require_once 'model/Message.php';

/**
 * @param User $user current user
 * @param Message $message message to display
 */
$msgSender = $message->getSender();
$msgSideClass = ($user->getPseudo() == $msgSender->getPseudo()) ? "msg-right" : "msg-left";
$msgStatus = $message->getStatus();
switch ($message->getType()):
    case Message::MSG_TYPE_TEXT:
?>
        <div class="msg-wrap" data-sender="<?= $msgSender->getPseudo() ?>" data-msgid="<?= $message->getMessageID() ?>" data-msgstatus="<?= $msgStatus ?>">
            <div class="msg-text <?= $msgSideClass ?>">
                <span><?= $message->getMessage() ?></span>
                <div class="msg-info">
                    <div class="msg-info-inner">
                        <span class="msg-time"><?= $message->getHour(); ?></span>
                        <div class="msg-status">
                            <?php
                            if ($user->getPseudo() == $msgSender->getPseudo()) :
                                switch ($msgStatus):
                                    case Message::MSG_STATUS_SEND:
                            ?>
                                        <div class="o_symbol-wrap">
                                            <div class="o_symbol infiny_rotate"></div>
                                        </div>
                                    <?php
                                        break;
                                    case Message::MSG_STATUS_READ:
                                        require 'view/Home/elements/discussionMessageStatusRead.php';
                                    ?>
                            <?php
                                endswitch;
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php break; ?>
<?php
endswitch;
