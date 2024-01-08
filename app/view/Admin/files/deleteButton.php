<?php
require_once 'model/User.php';
require_once 'model/Discussion.php';
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param User $user user to display
 * 
 */
$removeId = "delete" . Discussion::generateDateCode(25);
if ($user->getPermission() == User::PERMIT_DELETED) :
?>
    <td><button id="<?= $removeId ?>" onclick="restoreUser('<?= $removeId ?>', '<?= $user->getPseudo() ?>')" class="standard-button green-button remove-button-default-att">restaurer</button></td>
<?php else : ?>
    <td><button id="<?= $removeId ?>" onclick="deleteUser('<?= $removeId ?>', '<?= $user->getPseudo() ?>')" class="standard-button red-button remove-button-default-att">supprimer</button></td>
<?php endif; ?>