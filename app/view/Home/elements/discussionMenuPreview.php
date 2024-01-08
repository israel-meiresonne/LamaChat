<?php

/**
 * @param string $text message to display
 * @param boolean $isNew class to add on message
 */
$isNew = (isset($isNew)) ? $isNew : false;
?>

<div class="msg-preview">
    <span class="<?= $isNew ?>"><?= $text ?></span>
    <?php if($isNew): ?>
    <div class="notif infinity_fade">
    </div>
    <?php endif; ?>
</div>