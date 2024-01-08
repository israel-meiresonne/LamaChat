<?php
require_once 'model/User.php';
require_once 'model/Discussion.php';
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param User $user user to display
 * 
 */
$permissionId = "permission" . Discussion::generateDateCode(25);
if ($user->getPermission() == User::PERMIT_BANISHED) :
?>
    <td><button id="<?= $permissionId ?>" onclick="pardonUser('<?= $permissionId ?>', '<?= $user->getPseudo() ?>')" class="standard-button green-button remove-button-default-att">gracier</button></td>
<?php else : ?>
    <td><button id="<?= $permissionId ?>" onclick="banishUser('<?= $permissionId ?>', '<?= $user->getPseudo() ?>')" class="standard-button orange-button remove-button-default-att">banir</button></td>
<?php endif; ?>