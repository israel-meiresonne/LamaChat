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
                        <img src="content/images/static/default-user-picture.png">
                    </div>
                </div>
                <div class="img_text_down-text-div">
                    <span>Bob_Mak</span>
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
        <a href="javascript:void(0)" class="w3-bar-item w3-button w3-border-bottom test w3-hover-light-grey" onclick="openMail('Borge');w3_close();">
            <div class="w3-container">
                <img class="w3-round w3-margin-right" src="content/images/static/default-user-picture.png" style="width:15%;"><span class="w3-opacity w3-large">Borge Refsnes</span>
                <h6>Subject: Remember Me</h6>
                <p>Hello, i just wanted to let you know that i'll be home at...</p>
            </div>
        </a>
        <a href="javascript:void(0)" class="w3-bar-item w3-button w3-border-bottom test w3-hover-light-grey" onclick="openMail('Jane');w3_close();">
            <div class="w3-container">
                <img class="w3-round w3-margin-right" src="content/images/static/default-user-picture.png" style="width:15%;"><span class="w3-opacity w3-large">Jane Doe</span>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
            </div>
        </a>
        <a href="javascript:void(0)" class="w3-bar-item w3-button w3-border-bottom test w3-hover-light-grey" onclick="openMail('John');w3_close();">
            <div class="w3-container">
                <img class="w3-round w3-margin-right" src="content/images/static/default-user-picture.png" style="width:15%;"><span class="w3-opacity w3-large">John Doe</span>
                <p>Welcome!</p>
            </div>
        </a>
    </div>
    <a href="#" class="w3-bar-item w3-button"><i class="fa fa-paper-plane w3-margin-right"></i>Sent</a>
    <a href="#" class="w3-bar-item w3-button"><i class="fa fa-hourglass-end w3-margin-right"></i>Drafts</a>
    <a href="#" class="w3-bar-item w3-button"><i class="fa fa-trash w3-margin-right"></i>Trash</a>
</nav>

<!-- Modal that pops up when you click on "New Message" -->
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
                                <img id="edit_img" src="content/images/static/default-user-picture.png">
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
                    <span class="data-key_value-value">Bob_Mak</span>
                </div>
                <div class="data-key_value-wrap">
                    <span class="data-key_value-key">prénom:</span>
                    <span class="data-key_value-value">bob</span>
                </div>
                <div class="data-key_value-wrap">
                    <span class="data-key_value-key">nom:</span>
                    <span class="data-key_value-value">makinson</span>
                </div>
                <div class="data-key_value-wrap">
                    <span class="data-key_value-key">status:</span>
                    <span class="data-key_value-value">Aliquam convallis sollicitudin purus. Praesent aliquam, enim at fermentum mollis, ligula massa adipiscing nisl, ac euismod nibh nisl eu lectus. Fusce vulputate sem at sapien. Vivamus leo. Aliquam euismod libero eu enim. Nulla nec felis sed leo placerat imperdiet.</span>
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
                        <li>
                            <div class="data-key_value-wrap">
                                <span class="data-key_value-key">date de naissance:</span>
                                <span class="data-key_value-value">30 juin 1997</span>
                            </div>
                        </li>
                        <li>
                            <div class="data-key_value-wrap">
                                <span class="data-key_value-key">activité:</span>
                                <span class="data-key_value-value">comptable</span>
                            </div>
                        </li>
                        <li>
                            <div class="data-key_value-wrap">
                                <span class="data-key_value-key">hobbit:</span>
                                <span class="data-key_value-value">basketball</span>
                            </div>
                        </li>
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
                    <tr>
                        <td>
                            <button id="search_button" class="img-button remove-button-default-att">
                                <img src="content/images/static/default-user-picture.png">
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
                                <img src="content/images/static/default-user-picture.png">
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
                                <img src="content/images/static/default-user-picture.png">
                            </button>
                        </td>
                        <td><span>TOMTOM</span></td>
                        <td><button id="sign_in_button" for="sign_in_button_form" class="standard-button red-button remove-button-default-att">supprimer</button></td>
                        <td>
                            <button id="sign_in_button" for="sign_in_button_form" class="standard-button orange-button remove-button-default-att">bloquer</button>
                        </td>
                        <td><button id="sign_in_button" for="sign_in_button_form" class="standard-button blue-button remove-button-default-att">écrire</button></td>
                    </tr>
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
                            <div class="msg_sender-placeholder">Entrer pseuajouterdo, nom ou prénom</div>
                            <div class="msg_sender-input" contenteditable="true"></div>
                        </div>
                    </div>
                </div>
                <table class="contact-table">
                    <tr>
                        <td>
                            <button id="search_button" class="img-button remove-button-default-att">
                                <img src="content/images/static/default-user-picture.png">
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
                                <img src="content/images/static/default-user-picture.png">
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
                                <img src="content/images/static/default-user-picture.png">
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

    <div id="Borge" class="msg-window w3-container person">
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
        <img class="w3-round w3-animate-top" src="content/images/static/default-user-picture.png" style="width:20%;">
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
        <img class="w3-round w3-animate-top" src="content/images/static/default-user-picture.png" style="width:20%;">
        <h5 class="w3-opacity">Subject: None</h5>
        <h4><i class="fa fa-clock-o"></i> From John Doe, Sep 23, 2015.</h4>
        <a class="w3-button w3-light-grey">Reply<i class="w3-margin-left fa fa-mail-reply"></i></a>
        <a class="w3-button w3-light-grey">Forward<i class="w3-margin-left fa fa-arrow-right"></i></a>
        <hr>
        <p>Welcome.</p>
        <p>That's it!</p>
    </div>

</div>

<script>
    // var openInbox = document.getElementById("myBtn");
    // openInbox.click();

    // function w3_open() {
    //     document.getElementById("mySidebar").style.display = "block";
    //     document.getElementById("myOverlay").style.display = "block";
    // }

    // function w3_close() {
    //     document.getElementById("mySidebar").style.display = "none";
    //     document.getElementById("myOverlay").style.display = "none";
    // }

    // function myFunc(id) {
    //     var x = document.getElementById(id);
    //     if (x.className.indexOf("w3-show") == -1) {
    //         x.className += " w3-show";
    //         x.previousElementSibling.className += " w3-red";
    //     } else {
    //         x.className = x.className.replace(" w3-show", "");
    //         x.previousElementSibling.className =
    //             x.previousElementSibling.className.replace(" w3-red", "");
    //     }
    // }

    // openMail("Borge")

    // discusion-container function openMail(personName) {
    //     var i;
    //     var x = documentdiscusion-container .getElementsByClassName("person");
    //     for (i = 0; i < x.length; i++) {
    //         x[i].style.display = "none";
    //     }
    //     x = document.getElementsByClassName("test");
    //     for (i = 0; i < x.length; i++) {
    //         x[i].className = x[i].className.replace(" w3-light-grey", "");
    //     }
    //     documentdiscusion-container .getElementById(personName).style.display = "block";
    //     event.currentTarget.className += " w3-light-grey";
    // }
</script>

<script>
    // var openTab = document.getElementById("firstTab");
    // openTab.click();
</script>