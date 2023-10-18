<?php
require_once 'model/User.php';
require_once 'model/Discussion.php';
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param User[] $contacts =>  list of user's contacts
 * @param string $dataAttribut: attributs "data-..." to put on button
 * @param string $windId id of the window
 */
?>
<table class="contact-table">
    <?php
    foreach ($contacts as $contact) :
        $ctcPseu = $contact->getPseudo();
        $relationship = $contact->getRelationship();
    ?>
        <tr>
            <td>
                <button class="img-button remove-button-default-att">
                    <img src="<?= User::PICTURE_DIR . $contact->getPicture() ?>" onclick="openProfile('<?= User::KEY_PSEUDO ?>', '<?= $contact->getPseudo() ?>')">
                </button>
            </td>
            <td><span><?= $contact->getPseudo() ?></span></td>
            <?php
            if (empty($contact->getRelationship())) {
                require 'view/Home/elements/addButton.php';
            } else {
                require 'view/Home/elements/removeButton.php';
            }
            ob_start();
            require 'blockButton.php';
            echo ob_get_clean();
            $btnId = 'relationStatus' . Discussion::generateDateCode(25);
            ?>
            <td><button id="<?= $btnId ?>" data-windCloseBtn="<?= $windId ?>" onclick="writeContact('<?= $btnId ?>', '<?= User::KEY_PSEUDO ?>', '<?= $ctcPseu; ?>')" class="standard-button blue-button remove-button-default-att">écrire</button></td>
        </tr>
    <?php endforeach; ?>
</table>