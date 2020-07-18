<?php
require_once 'controller/ControllerSecure.php';
require_once 'model/Discussion.php';
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $ctcPseu pseudo of a user's contact
 * @param string $dataAttribut: attributs "data-..." to put on button
 */
$btnId = 'removeContact' . Discussion::generateDateCode(25);
?>
<td><button id="<?= $btnId ?>" <?= $dataAttribut ?> onclick="removeContact('<?= $btnId ?>', '<?= ControllerSecure::KEY_PSEUDO ?>', '<?= $ctcPseu; ?>')" class="standard-button red-button remove-button-default-att">supprimer</button></td>