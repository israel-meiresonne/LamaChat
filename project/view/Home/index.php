<?php
$this->title = "Discussions";
?>
<!-- Side Navigation -->
<nav class="w3-sidebar w3-bar-block w3-collapse w3-white w3-animate-left w3-card" style="z-index:3;width:320px;" id="mySidebar">
    <div class="menu-container">
        <div class="profile">
            <div class="img_text_down-wrap">
                <div class="img_text_down-img-div">
                    <div class="img_text_down-img-inner">
                        <img src="content/images/user-profile/<?= $user->getPicture() ?>">
                    </div>
                </div>
                <div class="img_text_down-text-div">
                    <span><?= $user->getPseudo() ?></span>
                </div>
            </div>
        </div>
        <div class="menu-btn menu-contact">
            <button id="contact_button" class="img-button remove-button-default-att">
                <img src="content/images/static/icons8-address-book-80.png">
            </button>
        </div>
        <div class="menu-btn menu-search">
            <button id="search_button" class="img-button remove-button-default-att">
                <img src="content/images/static/icons8-search-64.png">
            </button>
        </div>
        <div class="menu-btn menu-setting">
            <button id="setting_button" class="img-button remove-button-default-att">
                <img src="content/images/static/icons8-settings-128.png">
            </button>
        </div>
    </div>
    <a href="javascript:void(0)" onclick="w3_close()" title="Close Sidemenu" class="w3-bar-item w3-button w3-hide-large w3-large">Close <i class="fa fa-remove"></i></a>
    <a href="javascript:void(0)" class="w3-bar-item w3-button w3-dark-grey w3-button w3-hover-black w3-left-align" onclick="">New Message <i class="w3-padding fa fa-pencil"></i></a>
    <a id="myBtn" onclick="myFunc('Demo1')" href="javascript:void(0)" class="w3-bar-item w3-button"><i class="fa fa-inbox w3-margin-right"></i>Inbox (3)<i class="fa fa-caret-down w3-margin-left"></i></a>

    <div id="Demo1" class="w3-hide w3-animate-left">
        <?php
        /**
         * @var User
         */
        $user = $user;
        $discussions = $user->getDiscussions();
        // var_dump($discussions);
        foreach ($discussions as $discu) :
            $corresp = $discu->getCorrespondent($user->getPseudo());
        ?>

            <a href="javascript:void(0)" class="w3-bar-item w3-button w3-border-bottom test w3-hover-light-grey" onclick="openMail('<?= $discu->getDiscuID() ?>');w3_close();">
                <div class="w3-container">
                    <img class="w3-round w3-margin-right" src="content/images/user-profile/<?= $corresp->getPicture() ?>" style="width:15%;"><span class="w3-opacity w3-large"><?= $corresp->getFirstname() . " " . $corresp->getLastname() ?></span>
                    <?php
                    $discuName = $discu->getDiscuName();
                    if (!empty($discuName)) : ?>
                        <h6>sujet: <?= $discuName ?></h6>
                    <?php endif ?>
                    <p><?= $discu->getMsgPreview() ?></p>
                </div>
            </a>
        <?php endforeach; ?>
        <!-- <a href="javascript:void(0)" class="w3-bar-item w3-button w3-border-bottom test w3-hover-light-grey" onclick="openMail('Borge');w3_close();">
            <div class="w3-container">
                <img class="w3-round w3-margin-right" src="content/images/user-profile/default-user-picture.png" style="width:15%;"><span class="w3-opacity w3-large">Borge Refsnes</span>
                <h6>Subject: Remember Me</h6>
                <p>Hello, i just wanted to let you know that i'll be home at...</p>
            </div>
        </a>
        <a href="javascript:void(0)" class="w3-bar-item w3-button w3-border-bottom test w3-hover-light-grey" onclick="openMail('Jane');w3_close();">
            <div class="w3-container">
                <img class="w3-round w3-margin-right" src="content/images/user-profile/default-user-picture.png" style="width:15%;"><span class="w3-opacity w3-large">Jane Doe</span>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
            </div>
        </a>
        <a href="javascript:void(0)" class="w3-bar-item w3-button w3-border-bottom test w3-hover-light-grey" onclick="openMail('John');w3_close();">
            <div class="w3-container">
                <img class="w3-round w3-margin-right" src="content/images/user-profile/default-user-picture.png" style="width:15%;"><span class="w3-opacity w3-large">John Doe</span>
                <p>Welcome!</p>
            </div>
        </a> -->
    </div>
    <a href="#" class="w3-bar-item w3-button"><i class="fa fa-paper-plane w3-margin-right"></i>Sent</a>
    <a href="#" class="w3-bar-item w3-button"><i class="fa fa-hourglass-end w3-margin-right"></i>Drafts</a>
    <a href="#" class="w3-bar-item w3-button"><i class="fa fa-trash w3-margin-right"></i>Trash</a>
</nav>

<div id="id01" class="w3-modal" style="z-index:4">
    <div class="w3-modal-content">
        <div class="w3-container w3-padding w3-red">
            <span id="setting_close_button" class="w3-button w3-red w3-right w3-xxlarge"><i class="fa fa-remove"></i></span>
            <h2>Réglages</h2>
        </div>
        <div class="w3-panel">
            <div class="setting-content">
                <div class="edit-profile-img">
                    <div class="img_text_down-wrap">
                        <div class="img_text_down-img-div">
                            <div class="img_text_down-img-inner">
                                <img id="edit_img" src="content/images/user-profile/<?= $user->getPicture() ?>">
                            </div>
                        </div>
                        <div class="img_text_down-text-div">
                            <button id="edit_img_btn" class="standard-button blue-button remove-button-default-att">modifier</button>
                            <input id="edit_img_input" type="file" accept=".jpg, .jpeg, .png" name="profil_img">
                        </div>
                    </div>
                </div>
                <h3>profil</h3>
                <div class="data-key_value-wrap">
                    <span class="data-key_value-key">pseudo:</span>
                    <span class="data-key_value-value"><?= $user->getPseudo() ?></span>
                </div>
                <div class="data-key_value-wrap">
                    <span class="data-key_value-key">prénom:</span>
                    <span class="data-key_value-value"><?= $user->getFirstname() ?></span>
                </div>
                <div class="data-key_value-wrap">
                    <span class="data-key_value-key">nom:</span>
                    <span class="data-key_value-value"><?= $user->getLastname() ?></span>
                </div>
                <div class="data-key_value-wrap">
                    <span class="data-key_value-key">status:</span>
                    <span class="data-key_value-value"><?= $user->getStatus() ?></span>
                </div>
                <div class="more-info-title">
                    <h3>plus d'infomations</h3>
                    <div class="setting-add-info" style="display: none;">
                        <button id="setting_save_btn" class="standard-button blue-button remove-button-default-att">
                            <div class="plus_symbol-wrap">
                                <span class="plus_symbol-vertical"></span>
                                <span class="plus_symbol-horizontal"></span>
                            </div>
                        </button>
                    </div>
                </div>
                <div class="setting-job-set">
                    <ul class="remove-ul-default-att">
                        <?php
                        $infos = $user->getInformations();
                        foreach ($infos as $info => $value) : ?>
                            <li>
                                <div class="data-key_value-wrap">
                                    <span class="data-key_value-key"><?= $info ?>:</span>
                                    <span class="data-key_value-value"><?= $value ?></span>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="setting-save">
                <button id="setting_save_btn" class="standard-button blue-button remove-button-default-att">enregistrer</button>
            </div>
        </div>
    </div>
</div>

<div id="contact_window" class="w3-modal" style="z-index:4">
    <div class="w3-modal-content">
        <div class="w3-container w3-padding w3-red">
            <span id="contact_close_button" class="w3-button w3-red w3-right w3-xxlarge"><i class="fa fa-remove"></i></span>
            <h2>contacts</h2>
        </div>
        <div class="w3-panel">
            <div class="setting-content">
                <table class="contact-table">
                    <?php
                    $contacts = $user->getContacts();
                    foreach ($contacts as $contact) :
                    ?>
                        <tr>
                            <td>
                                <button class="img-button remove-button-default-att">
                                    <img src="content/images/user-profile/<?= $contact->getPicture() ?>">
                                </button>
                            </td>
                            <td><span><?= $contact->getPseudo() ?></span></td>
                            <td><button class="standard-button red-button remove-button-default-att">supprimer</button></td>
                            <?php
                            switch ($contact->getRelationship()):
                                case User::KNOW:
                            ?>
                                    <td><button class="standard-button orange-button remove-button-default-att">bloquer</button></td>
                                <?php
                                    break;
                                case User::BLOCKED:
                                ?>
                                    <td><button class="standard-button red-button remove-button-default-att">débloquer</button></td>
                            <?php
                                    break;
                            endswitch; 
                            ?>
                            <td><button class="standard-button blue-button remove-button-default-att">écrire</button></td>
                        </tr>
                    <?php endforeach; ?>
                    <!-- <tr>
                        <td>
                            <button id="search_button" class="img-button remove-button-default-att">
                                <img src="content/images/user-profile/default-user-picture.png">
                            </button>
                        </td>
                        <td><span>Bob_Mak</span></td>
                        <td><button data-contact_pseudo="" class="standard-button red-button remove-button-default-att">supprimer</button></td>
                        <td><button data-contact_pseudo="" class="standard-button orange-button remove-button-default-att">bloquer</button></td>
                        <td><button data-contact_pseudo="" class="standard-button blue-button remove-button-default-att">écrire</button></td>
                    </tr>
                    <tr>
                        <td>
                            <button id="search_button" class="img-button remove-button-default-att">
                                <img src="content/images/user-profile/default-user-picture.png">
                            </button>
                        </td>
                        <td><span>HervDon</span></td>
                        <td><button data-contact_pseudo="" class="remove_contact_btn standard-button red-button remove-button-default-att">supprimer</button></td>
                        <td><button data-contact_pseudo="" class="remove_contact_btn standard-button orange-button remove-button-default-att">bloquer</button></td>
                        <td><button data-contact_pseudo="" class="remove_contact_btn standard-button blue-button remove-button-default-att">écrire</button></td>
                    </tr>
                    <tr>
                        <td>
                            <button id="search_button" class="img-button remove-button-default-att">
                                <img src="content/images/user-profile/default-user-picture.png">
                            </button>
                        </td>
                        <td><span>TOMTOM</span></td>
                        <td><button id="sign_in_button" for="sign_in_button_form" class="standard-button red-button remove-button-default-att">supprimer</button></td>
                        <td>
                            <button id="sign_in_button" for="sign_in_button_form" class="standard-button orange-button remove-button-default-att">bloquer</button>
                        </td>
                        <td><button id="sign_in_button" for="sign_in_button_form" class="standard-button blue-button remove-button-default-att">écrire</button></td>
                    </tr> -->
                </table>
            </div>
        </div>
    </div>
</div>

<div id="search_window" class="w3-modal" style="z-index:4">
    <div class="w3-modal-content">
        <div class="w3-container w3-padding w3-red">
            <span id="search_close_button" class="w3-button w3-red w3-right w3-xxlarge"><i class="fa fa-remove"></i></span>
            <h2>recherche</h2>
        </div>
        <div class="w3-panel">
            <div class="setting-content">
                <div class="msg_sender-container">
                    <div class="msg_sender">
                        <div class="msg_sender-inner">
                            <div class="msg_sender-placeholder">Entrer pseudo, nom ou prénom</div>
                            <div class="msg_sender-input" contenteditable="true"></div>
                        </div>
                    </div>
                </div>
                <table class="contact-table">
                    <tr>
                        <td>
                            <button id="search_button" class="img-button remove-button-default-att">
                                <img src="content/images/user-profile/default-user-picture.png">
                            </button>
                        </td>
                        <td><span>Bob_Mak</span></td>
                        <td><button id="sign_in_button" for="sign_in_button_form" class="standard-button green-button remove-button-default-att">ajouter</button></td>
                        <td><button id="sign_in_button" for="sign_in_button_form" class="standard-button orange-button remove-button-default-att">bloquer</button></td>
                        <td><button id="sign_in_button" for="sign_in_button_form" class="standard-button blue-button remove-button-default-att">écrire</button></td>
                    </tr>
                    <tr>
                        <td>
                            <button id="search_button" class="img-button remove-button-default-att">
                                <img src="content/images/user-profile/default-user-picture.png">
                            </button>
                        </td>
                        <td><span>HervDon</span></td>
                        <td><button data-contact_pseudo="" class="remove_contact_btn standard-button green-button remove-button-default-att">ajouter</button></td>
                        <td><button data-contact_pseudo="" class="remove_contact_btn standard-button orange-button remove-button-default-att">bloquer</button></td>
                        <td><button data-contact_pseudo="" class="remove_contact_btn standard-button blue-button remove-button-default-att">écrire</button></td>
                    </tr>
                    <tr>
                        <td>
                            <button id="search_button" class="img-button remove-button-default-att">
                                <img src="content/images/user-profile/default-user-picture.png">
                            </button>
                        </td>
                        <td><span>TOMTOM</span></td>
                        <td><button id="sign_in_button" for="sign_in_button_form" class="standard-button green-button remove-button-default-att">ajouter</button></td>
                        <td><button id="sign_in_button" for="sign_in_button_form" class="standard-button orange-button remove-button-default-att">bloquer</button></td>
                        <td><button id="sign_in_button" for="sign_in_button_form" class="standard-button blue-button remove-button-default-att">écrire</button></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Overlay effect when opening the side navigation on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="Close Sidemenu" id="myOverlay"></div>

<!-- Page content -->
<div class="w3-main" style="margin-left:320px;">
    <i class="fa fa-bars w3-button w3-white w3-hide-large w3-xlarge w3-margin-left w3-margin-top" onclick="w3_open()"></i>
    <a href="javascript:void(0)" class="w3-hide-large w3-red w3-button w3-right w3-margin-top w3-margin-right" onclick="document.getElementById('id01').style.display='block'"><i class="fa fa-pencil"></i></a>
    <?php foreach ($discussions as $discu) : ?>
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
    <?php endforeach; ?>

    <!-- <div id="Borge" class="msg-window w3-container person">
        <div class="msg-background"></div>
        <div class="msg-window-inner">
            <div class="msg-wrap">
                <div class="msg-date">
                    <span>mercredi 23 juin 2020</span>
                </div>
            </div>
            <div class="msg-wrap">
                <div class="msg-text msg-left">
                    <span>🤬Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec🥶</span>
                    <div class="msg-info">
                        <div class="msg-info-inner">
                            <span class="msg-time">19:17</span>
                            <div class="msg-status">
                                <div class="v_symbol-wrap">
                                    <span class="v_symbol-vertical"></span>
                                    <span class="v_symbol-horizontal"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="msg-wrap">
                <div class="msg-wrap-inner">
                    <div class="msg-text msg-right">
                        <span>Ut velit mauris, egestas sed, gravida nec, ornare ut, mi.🤬</span>
                        <div class="msg-info">
                            <div class="msg-info-inner">
                                <span class="msg-time">19:17</span>
                                <div class="msg-status">
                                    <div class="o_symbol-wrap">
                                        <div class="o_symbol infiny_rotate"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="msg-wrap">
                <div class="msg-wrap-inner">
                    <div class="msg-text msg-right">
                        <span>🤬Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec🥶</span>
                        <div class="msg-info">
                            <div class="msg-info-inner">
                                <span class="msg-time">19:17</span>
                                <div class="msg-status">
                                    <div class="v_symbol-wrap">
                                        <span class="v_symbol-vertical"></span>
                                        <span class="v_symbol-horizontal"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

    <div id="Jane" class="discusion-container w3-container person">
        <br>
        <img class="w3-round w3-animate-top" src="content/images/user-profile/default-user-picture.png" style="width:20%;">
        <h5 class="w3-opacity">Subject: None</h5>
        <h4><i class="fa fa-clock-o"></i> From Jane Doe, Sep 25, 2015.</h4>
        <a class="w3-button w3-light-grey">Reply<i class="w3-margin-left fa fa-mail-reply"></i></a>
        <a class="w3-button w3-light-grey">Forward<i class="w3-margin-left fa fa-arrow-right"></i></a>
        <hr>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        <p>Forever yours,<br>Jane</p>
    </div>

    <div id="John" class="discusion-container w3-container person">
        <br>
        <img class="w3-round w3-animate-top" src="content/images/user-profile/default-user-picture.png" style="width:20%;">
        <h5 class="w3-opacity">Subject: None</h5>
        <h4><i class="fa fa-clock-o"></i> From John Doe, Sep 23, 2015.</h4>
        <a class="w3-button w3-light-grey">Reply<i class="w3-margin-left fa fa-mail-reply"></i></a>
        <a class="w3-button w3-light-grey">Forward<i class="w3-margin-left fa fa-arrow-right"></i></a>
        <hr>
        <p>Welcome.</p>
        <p>That's it!</p>
    </div> -->

</div>