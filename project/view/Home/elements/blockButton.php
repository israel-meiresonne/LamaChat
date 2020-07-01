<?php
switch ($relationship):
    case User::KNOW:
?>
        <td><button onclick="blockContact('<?= ControllerSecure::KEY_PSEUDO ?>', '<?= $ctcPseu; ?>')" class="standard-button orange-button remove-button-default-att">bloquer</button></td>
    <?php
        break;
    case User::BLOCKED:
    ?>
        <td><button onclick="unlockContact('<?= ControllerSecure::KEY_PSEUDO ?>', '<?= $ctcPseu; ?>')" class="standard-button red-button remove-button-default-att">débloquer</button></td>
<?php
        break;
endswitch;
?>