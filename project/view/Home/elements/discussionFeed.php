<!-- begin discussion feed
need: 
    $user => current user
    $discu => current user's discussion with participants and messages setted
-->
<div id="<?= $discu->getDiscuID() ?>" class="msg-window w3-container person">
    <div class="msg-background"></div>
    <div class="msg-window-inner">
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
            $msgSender = $message->getSender();
            $msgSideClass = ($user->getPseudo() == $msgSender->getPseudo()) ? "msg-right" : "msg-left";
            switch ($message->getType()):
                case Message::MSG_TYPE_TEXT:
                ?>
                    <div class="msg-wrap">
                        <div class="msg-text <?= $msgSideClass ?>">
                            <span><?= $message->getMessage() ?></span>
                            <div class="msg-info">
                                <div class="msg-info-inner">
                                    <span class="msg-time"><?= $message->getHour(); ?></span>
                                    <div class="msg-status">
                                        <?php
                                        if ($user->getPseudo() == $msgSender->getPseudo()) :
                                            switch ($message->getStatus()):
                                                case Message::MSG_STATUS_SEND:
                                        ?>
                                                    <div class="o_symbol-wrap">
                                                        <div class="o_symbol infiny_rotate"></div>
                                                    </div>
                                                <?php
                                                    break;
                                                case Message::MSG_STATUS_READ:
                                                ?>
                                                    <div class="v_symbol-wrap">
                                                        <span class="v_symbol-vertical"></span>
                                                        <span class="v_symbol-horizontal"></span>
                                                    </div>
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
        endforeach;
        ?>
    </div>
    <div class="msg_sender-container">
        <div class="msg_sender">
            <div class="msg_sender-inner">
                <div class="msg_sender-placeholder">Entrer votre message</div>
                <div class="msg_sender-input" contenteditable="true"></div>
            </div>
        </div>
        <div class="msg_sender-button-set">
            <div class="msg_sender-button-div">
                <button id="send_txt_msg" class="img-button remove-button-default-att">
                    <img src="content/images/static/icons8-email-send-96.png">
                </button>
            </div>
            <div class="msg_sender-button-div">
                <button id="send_img_msg" class="img-button remove-button-default-att">
                    <img src="content/images/static/icons8-image-100.png">
                </button>
            </div>
        </div>
    </div>
</div>
<!-- end discussion feed -->