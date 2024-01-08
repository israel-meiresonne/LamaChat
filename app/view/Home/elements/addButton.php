<?php
require_once 'model/Discussion.php';
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $ctcPseu pseudo of a user's contact
 */
$btnId = 'addContact' . Discussion::generateDateCode(25);
?>

<td><button id="<?= $btnId ?>" onclick="addContact('<?= $btnId ?>', '<?= User::KEY_PSEUDO ?>', '<?= $ctcPseu; ?>')" class="standard-button green-button remove-button-default-att">ajouter</button></td>