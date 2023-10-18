<?php
require_once 'model/User.php';
require_once 'model/Discussion.php';
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param User[] $users users to display
 */

/**
 * @var User[]
 */
$users = $users;
?>
<table class="user-table">
    <tr>
        <th class="image"><span>photo</span></th>
        <th><span>pseudo</span></th>
        <th><span>prénom</span></th>
        <th><span>nom</span></th>
        <th><span>date de naissance</span></th>
        <th><span>permission</span></th>
        <th colspan="2"><span></span></th>
    </tr>

    <?php foreach ($users as $user) :
        $pseudo = $user->getPseudo();
    ?>
        <tr>
            <td>
                <button class="img-button remove-button-default-att">
                    <img src="<?= User::PICTURE_DIR . $user->getPicture() ?>" onclick="openProfile('<?= User::KEY_PSEUDO ?>', '<?= $pseudo ?>')">
                </button>
            </td>
            <td><span><?= $pseudo ?></span></td>
            <td><span><?= $user->getFirstname() ?></span></td>
            <td><span><?= $user->getLastname() ?></span></td>
            <td><span><?= $user->getBirthdate() ?></span></td>
            <td><span><?= $user->getPermission() ?></span></td>
            <?php require 'view/Admin/files/banishButton.php'; ?>
            <?php require 'view/Admin/files/deleteButton.php'; ?>
        </tr>
    <?php endforeach; ?>
</table>