<?php
require_once 'model/User.php';
require_once 'model/Discussion.php';
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $ctcPseu pseudo of a user's contact
 * @param string $relationship relationship of a contact with the current user
 */
$btnId = 'relationStatus' . Discussion::generateDateCode(25);
switch ($relationship):
    case User::KNOW:
?>
        <td><button id="<?= $btnId ?>" onclick="blockContact('<?= $btnId ?>', '<?= User::KEY_PSEUDO ?>', '<?= $ctcPseu; ?>')" class="standard-button orange-button remove-button-default-att">bloquer</button></td>
    <?php
        break;
    case User::BLOCKED:
    ?>
        <td><button id="<?= $btnId ?>" onclick="unlockContact('<?= $btnId ?>', '<?= User::KEY_PSEUDO ?>', '<?= $ctcPseu; ?>')" class="standard-button red-button remove-button-default-att">débloquer</button></td>
    <?php
        break;
    default:
    ?>
        <td><button id="<?= $btnId ?>" onclick="blockContact('<?= $btnId ?>', '<?= User::KEY_PSEUDO ?>', '<?= $ctcPseu; ?>')" class="standard-button orange-button remove-button-default-att">bloquer</button></td>
<?php
endswitch;
?>