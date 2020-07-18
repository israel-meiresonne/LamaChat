<!-- 
need: 
    $ctcPseu => pseudo of a user's contact
    $relationship => relationship of a contact with the current user
-->
<?php
require_once 'model/Discussion.php';
$btnId = 'relationStatus' . Discussion::generateDateCode(25);
switch ($relationship):
    case User::KNOW:
?>
        <td><button id="<?= $btnId ?>" onclick="blockContact('<?= $btnId ?>', '<?= ControllerSecure::KEY_PSEUDO ?>', '<?= $ctcPseu; ?>')" class="standard-button orange-button remove-button-default-att">bloquer</button></td>
    <?php
        break;
    case User::BLOCKED:
    ?>
        <td><button id="<?= $btnId ?>" onclick="unlockContact('<?= $btnId ?>', '<?= ControllerSecure::KEY_PSEUDO ?>', '<?= $ctcPseu; ?>')" class="standard-button red-button remove-button-default-att">débloquer</button></td>
    <?php
        break;
    default:
    ?>
        <td><button id="<?= $btnId ?>" onclick="blockContact('<?= $btnId ?>', '<?= ControllerSecure::KEY_PSEUDO ?>', '<?= $ctcPseu; ?>')" class="standard-button orange-button remove-button-default-att">bloquer</button></td>
<?php
endswitch;
?>