<?php
$this->title = "S'inscrire"/* Se Connecter*/;
?>

<div class="bgimg w3-display-container w3-animate-opacity w3-text-white">
    <div class="esi-logo-container">
        <div class="img-text-wrap">
            <div class="img-text-img">
                <img src="content/images/static/logo-esi.png">
            </div>
            <div class="img-text-div">
                <div class="data-key_value-wrap">
                    <span class="data-key_value-key">matricule:</span>
                    <span class="data-key_value-value">53298</span>
                </div>
                <div class="data-key_value-wrap">
                    <span class="data-key_value-key">nom:</span>
                    <span class="data-key_value-value">meiresonne</span>
                </div>
                <div class="data-key_value-wrap">
                    <span class="data-key_value-key">prénom:</span>
                    <span class="data-key_value-value">israel</span>
                </div>
            </div>
        </div>
    </div>
    <div class="window-display-middle">
        <div class="form-switcher-container">
            <div class="switcher-button-div">
                <button id="sign_up_switcher" data-window_id="sign_up_window" class="switcher-button standard-button blue-button-focus remove-button-default-att">nouveau membre</button>
            </div>
            <div class="switcher-button-div">
                <button id="sign_in_switcher" data-window_id="sign_in_window" class="switcher-button standard-button blue-button-unfocus remove-button-default-att">déjà membre</button>
            </div>
        </div>
        <div class="form-container">
            <div id="sign_up_window" class="sign_form-container">
                <form id="sign_up_form" class="sign_form">
                    <div class="input-set">
                        <div class="input-container">
                            <div class="input-wrap">
                                <label class="input-label" for="sign_up_pseudo">pseudo</label>
                                <input id="sign_up_pseudo" class="input-tag" type="text" name="pseudo" placeholder="pseudo">
                                <p class="comment"></p>
                            </div>
                        </div>
                        <div class="input-container">
                            <div class="input-wrap">
                                <label class="input-label" for="sign_up_firstname">prénom</label>
                                <input id="sign_up_firstname" class="input-tag" type="text" name="firstname" placeholder="prénom">
                                <p class="comment"></p>
                            </div>
                        </div>
                        <div class="input-container">
                            <div class="input-wrap">
                                <label class="input-label" for="sign_up_lastname">nom</label>
                                <input id="sign_up_lastname" class="input-tag" type="text" name="lastname" placeholder="nom">
                                <p class="comment"></p>
                            </div>
                        </div>
                        <div class="input-container">
                            <div class="input-wrap">
                                <label class="input-label" for="sign_up_password">mot de passe</label>
                                <input id="sign_up_password" class="input-tag" type="password" name="password" placeholder="mot de passe">
                                <p class="comment"></p>
                            </div>
                        </div>
                    </div>

                </form>
                <div class="sign_form-button-div">
                    <button id="sign_up_button" for="sign_up_form" class="standard-button blue-button remove-button-default-att">s'inscrire</button>
                </div>
            </div>
            <div id="sign_in_window" class="sign_form-container display_none">
                <form id="sign_in_button_form" class="sign_form">
                    <div class="input-set">
                        <div class="input-container">
                            <div class="input-wrap">
                                <label class="input-label" for="sign_up_pseudo">pseudo</label>
                                <input id="sign_up_pseudo" class="input-tag" type="text" name="pseudo" placeholder="pseudo">
                                <p class="comment"></p>
                            </div>
                        </div>
                        <div class="input-container">
                            <div class="input-wrap">
                                <label class="input-label" for="sign_up_password">mot de passe</label>
                                <input id="sign_up_password" class="input-tag" type="password" name="password" placeholder="mot de passe">
                                <p class="comment"></p>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="sign_form-button-div">
                    <button id="sign_in_button" for="sign_in_button_form" class="standard-button blue-button remove-button-default-att">se connecter</button>
                </div>
            </div>
        </div>
    </div>
</div>