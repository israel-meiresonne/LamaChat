<?php
require_once 'model/Discussion.php';
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $ctcPseu pseudo of a user's contact
 * @param string $dataAttribut: attributs "data-..." to put on button
 */
$btnId = 'removeContact' . Discussion::generateDateCode(25);
?>
<td><button id="<?= $btnId ?>" <?= $dataAttribut ?> onclick="removeContact('<?= $btnId ?>', '<?= User::KEY_PSEUDO ?>', '<?= $ctcPseu; ?>')" class="standard-button red-button remove-button-default-att">supprimer</button></td>