<?php
require_once 'model/User.php';
$this->title = "Discussions";
$discussions = $user->getDiscussions();
$nbDiscu = count($discussions);
$discuTitle = ($nbDiscu > 0) ? "Discussions (" . $nbDiscu . ")" : "Discussion (" . $nbDiscu . ")";
?>
<script>
    const SENDER = "<?= $user->getPseudo() ?>";
</script>
<!-- Side Navigation -->
<nav class="w3-sidebar w3-bar-block w3-collapse w3-white w3-animate-left w3-card" style="z-index:3;width:320px;" id="mySidebar">
    <div class="menu-container">
        <div class="profile">
            <div class="img_text_down-wrap">
                <div class="img_text_down-img-div">
                    <div class="img_text_down-img-inner">
                        <img id="user_menu_profile" src="content/images/user-profile/<?= $user->getPicture() ?>" onclick="openProfile('<?= User::KEY_PSEUDO ?>', '<?= $user->getPseudo() ?>')">
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
    <!-- <a href="javascript:void(0)" class="w3-bar-item w3-button w3-dark-grey w3-button w3-hover-black w3-left-align" onclick="">New Message <i class="w3-padding fa fa-pencil"></i></a> -->
    <button id="log_out_btn" class="w3-bar-item w3-button"><i class="fa fa-sign-out" aria-hidden="true"></i>Se déconnecter</button>
    <a id="myBtn" onclick="myFunc('Demo1')" href="javascript:void(0)" class="w3-bar-item w3-button"><i class="fa fa-inbox w3-margin-right"></i><?= $discuTitle ?><i class="fa fa-caret-down w3-margin-left"></i></a>

    <div id="Demo1" class="w3-hide w3-animate-left">
        <?php
        /**
         * @var User
         */
        $user = $user;
        // $discussions = $user->getDiscussions();
        // var_dump($discussions);
        foreach ($discussions as $discu) :
            $corresp = $discu->getCorrespondent($user->getPseudo());
        ?>

            <?php
            ob_start();
            require 'elements/discussionMenu.php';
            echo ob_get_clean();
            ?>

        <?php endforeach; ?>
    </div>
</nav>

<div id="id01" class="w3-modal" style="z-index:4">
    <div class="w3-modal-content">
        <div class="w3-container w3-padding w3-red">
            <span id="setting_close_button" class="w3-button w3-red w3-right w3-xxlarge"><i class="fa fa-remove"></i></span>
            <h2>Réglages</h2>
        </div>
        <div class="w3-panel">
            <div class="setting-content">
                <?php if ($user->getPermission() == User::PERMIT_ADMIN) : ?>
                    <a href="admin" class="standard-button green-button remove-button-default-att" style="padding:5px">baculer vers page d'administration</a>
                    <hr>
                <?php endif; ?>
                <div class="edit-profile-img">
                    <div class="img_text_down-wrap">
                        <div class="img_text_down-img-div">
                            <div class="img_text_down-img-inner">
                                <img id="edit_img" src="content/images/user-profile/<?= $user->getPicture() ?>">
                            </div>
                        </div>
                        <div class="img_text_down-text-div">
                            <button id="edit_img_btn" class="standard-button blue-button remove-button-default-att">modifier</button>
                            <input id="edit_img_input" type="file" accept="<?= User::picExtensionsToString() ?>" name="<?= User::KEY_PICTURE ?>">
                            <p class="comment"></p>
                        </div>
                    </div>
                </div>
                <h3>profil</h3>
                <div class="data-key_value-wrap">
                    <span class="data-key_value-key">pseudo:</span>
                    <span class="data-key_value-value" name="<?= User::KEY_PSEUDO ?>"><?= $user->getPseudo() ?></span>
                    <p class="comment"></p>
                </div>
                <div class="data-key_value-wrap">
                    <span class="data-key_value-key">prénom:</span>
                    <span class="data-key_value-value" name="<?= User::KEY_FIRSTNAME ?>"><?= $user->getFirstname() ?></span>
                    <p class="comment"></p>
                </div>
                <div class="data-key_value-wrap">
                    <span class="data-key_value-key">nom:</span>
                    <span class="data-key_value-value" name="<?= User::KEY_LASTNAME ?>"><?= $user->getLastname() ?></span>
                    <p class="comment"></p>
                </div>
                <div class="data-key_value-wrap">
                    <span class="data-key_value-key">date de naissance:</span>
                    <span class="data-key_value-value" name="<?= User::KEY_BIRTHDATE ?>"><?= $user->getBirthdate() ?></span>
                    <p class="comment"></p>
                </div>
                <div class="data-key_value-wrap">
                    <span class="data-key_value-key">status:</span>
                    <span class="data-key_value-value" name="<?= User::KEY_STATUS ?>"><?= $user->getStatus() ?></span>
                    <p class="comment"></p>
                </div>
                <div class="more-info-title">
                    <h3>plus d'infomations</h3>
                    <!-- <div class="setting-add-info" style="display: none;">
                        <button id="setting_save_btn" class="standard-button blue-button remove-button-default-att">
                            <div class="plus_symbol-wrap">
                                <span class="plus_symbol-vertical"></span>
                                <span class="plus_symbol-horizontal"></span>
                            </div>
                        </button>
                    </div> -->
                </div>
                <div class="setting-job-set">
                    <ul class="remove-ul-default-att">
                        <?php
                        $infos = $user->getInformations();
                        foreach ($infos as $info => $value) : ?>
                            <li>
                                <div class="data-key_value-wrap">
                                    <span class="data-key_value-key"><?= $info ?>:</span>
                                    <span class="data-key_value-value" name="<?= User::valueToInputName($info) ?>"><?= $value ?></span>
                                    <p class="comment"></p>
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
                <?php
                $contacts = $user->getContacts();
                $dataAttribut = "data-window='contact_window'";
                ob_start();
                require "elements/contactTable.php";
                echo ob_get_clean();
                ?>

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
                            <div id="search_contact_input" class="msg_sender-input" contenteditable="true"></div>
                        </div>
                    </div>
                </div>
                <table class="contact-table">

                </table>
            </div>
        </div>
    </div>
</div>

<div id="user_profile" class="w3-modal" style="z-index:4">
    <div class="w3-modal-content">
        <div class="w3-container w3-padding w3-red">
            <span id="profile_close_button" class="w3-button w3-red w3-right w3-xxlarge"><i class="fa fa-remove"></i></span>
            <h2>profile</h2>
        </div>
        <div class="w3-panel">

        </div>
    </div>
</div>

<!-- Overlay effect when opening the side navigation on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="Close Sidemenu" id="myOverlay"></div>

<!-- Page content -->
<div id="discussion_feed" class="w3-main" style="margin-left:320px;">
    <i class="burger-btn fa fa-bars w3-button w3-white w3-hide-large w3-xlarge w3-margin-left w3-margin-top" onclick="w3_open()"></i>
    <!-- <a href="javascript:void(0)" class="w3-hide-large w3-red w3-button w3-right w3-margin-top w3-margin-right" onclick="document.getElementById('id01').style.display='block'"><i class="fa fa-pencil"></i></a> -->
    <div class="content w3-main">
        <?php foreach ($discussions as $discu) : ?>
            <?php
            ob_start();
            require 'elements/discussionFeed.php';
            echo ob_get_clean();
            ?>


        <?php endforeach; ?>
    </div>
</div>