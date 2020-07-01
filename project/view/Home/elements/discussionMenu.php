<!-- 
need: 
    $corresp => User witch who the urrent user is chatting
    $discu => current user's discussion with participants and messages setted
-->
<a data-menuDiscuId="<?= $discu->getDiscuID() ?>" href="javascript:void(0)" class="w3-bar-item w3-button w3-border-bottom test w3-hover-light-grey" onclick="openMail('<?= $discu->getDiscuID() ?>');w3_close();">
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