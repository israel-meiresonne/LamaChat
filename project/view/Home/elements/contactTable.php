<!-- 
need: 
    $contacts =>  list of user with his anitialized attributs:
                - Pseudo
                - Firstname
                - Lastname
                - Picture
                - Status
                - Relationship
    $dataAttribut: attributs "data-..." to put on button

-->

<table class="contact-table">
    <?php
    require_once 'model/Discussion.php';
    // $contacts = $user->getContacts();
    foreach ($contacts as $contact) :
        $ctcPseu = $contact->getPseudo();
        $relationship = $contact->getRelationship();
    ?>
        <tr>
            <td>
                <button class="img-button remove-button-default-att">
                    <img src="content/images/user-profile/<?= $contact->getPicture() ?>" onclick="openProfile('<?= ControllerSecure::KEY_PSEUDO ?>', '<?= $contact->getPseudo() ?>')">
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
            // require 'elements/blockButton.php';
            require 'blockButton.php';
            echo ob_get_clean();
            $btnId = 'relationStatus' . Discussion::generateDateCode(25);
            ?>
            <td><button id="<?= $btnId ?>" data-windCloseBtn="contact_window" onclick="writeContact('<?= $btnId ?>', '<?= ControllerSecure::KEY_PSEUDO ?>', '<?= $ctcPseu; ?>')" class="standard-button blue-button remove-button-default-att">écrire</button></td>
        </tr>
    <?php endforeach; ?>
</table>