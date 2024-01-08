<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param User $user a user to display's informations
 */
?>
<div class="setting-content">
    <div class="edit-profile-img">
        <div class="img_text_down-wrap">
            <div class="img_text_down-img-div">
                <div class="img_text_down-img-inner">
                    <img id="edit_img" src="content/images/user-profile/<?= $user->getPicture() ?>">
                </div>
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
        <span class="data-key_value-key">date de naissance:</span>
        <span class="data-key_value-value"><?= $user->getBirthdate() ?></span>
        <p class="comment"></p>
    </div>
    <div class="data-key_value-wrap">
        <span class="data-key_value-key">status:</span>
        <span class="data-key_value-value"><?= $user->getStatus() ?></span>
    </div>
    <div class="more-info-title">
        <h3>plus d'infomations</h3>
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