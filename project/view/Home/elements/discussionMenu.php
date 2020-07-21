<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $corresp User with who the current user is chatting
 * @param string $discu current user's discussion with participants and messages setted
 */
$btnId = "rmvBtn" . Discussion::generateDateCode(25);
$discuId = $discu->getDiscuID();
$correspPseudo = $corresp->getPseudo();
?>
<a data-menuDiscuId="<?= $discuId ?>" href="javascript:void(0)" class="w3-bar-item w3-button w3-border-bottom test w3-hover-light-grey" onclick="openMail('<?= $discuId ?>');w3_close();">
    <button id="<?= $btnId ?>" onclick="removeDiscu('<?= $btnId ?>', '<?= Discussion::DISCU_ID ?>', '<?= $discuId ?>')" class="discu-btn w3-button"><i class="fa fa-remove" aria-hidden="true"></i></button>
    <div class="w3-container">
        <img onclick="openProfile('<?= ControllerSecure::KEY_PSEUDO ?>', '<?= $correspPseudo ?>')" class="w3-round w3-margin-right" src="content/images/user-profile/<?= $corresp->getPicture() ?>" style="width:15%;"><span class="w3-opacity w3-large"><?= $corresp->getFirstname() . " " . $corresp->getLastname() ?></span>
        <?php
        $discuName = $discu->getDiscuName();
        if (!empty($discuName)) : ?>
            <h6>sujet: <?= $discuName ?></h6>
        <?php endif ?>
        <p><?= $discu->getMsgPreview() ?></p>
    </div>
</a>