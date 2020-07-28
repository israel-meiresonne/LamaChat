<?php
require_once "controller/ControllerSign.php";
require_once 'model/User.php';

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <title><?= $title ?></title>
    <meta charset="UTF-8">
    <base href="<?= $webRoot ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <link href='https://fonts.googleapis.com/css?family=RobotoDraft' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="content/css/src.css">
    <link rel="stylesheet" href="content/css/element.css">
    <link rel="stylesheet" href="content/css/home.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">

    <script src="content/js/element.js"></script>
    <script src="content/js/qr.js"></script>
    <script src="content/js/pages.js"></script>
    <script src="content/js/src.js"></script>
</head>

<body>
    <script>
        const TS = 450;
        const BNR = 1000000;
        const webRoot = <?= $webRoot ?>;
        // controller Sign
        const ACTION_SIGN_UP = "<?= ControllerSign::ACTION_SIGN_UP ?>";
        const ACTION_SIGN_IN = "<?= ControllerSign::ACTION_SIGN_IN ?>";
        // controller Home
        const ACTION_SEARCH_CONTACT = "<?= ControllerHome::ACTION_SEARCH_CONTACT ?>";
        const ACTION_ADD_CONTACT = "<?= ControllerHome::ACTION_ADD_CONTACT ?>";
        const ACTION_REMOVE_CONTACT = "<?= ControllerHome::ACTION_REMOVE_CONTACT ?>";
        const ACTION_BLOCK_CONTACT = "<?= ControllerHome::ACTION_BLOCK_CONTACT ?>";
        const ACTION_UNLOCK_CONTACT = "<?= ControllerHome::ACTION_UNLOCK_CONTACT ?>";
        const ACTION_WRITE_CONTACT = "<?= ControllerHome::ACTION_WRITE_CONTACT ?>";
        const ACTION_GET_CONTACT_TABLE = "<?= ControllerHome::ACTION_GET_CONTACT_TABLE ?>";
        const ACTION_SIGN_OUT = "<?= ControllerHome::ACTION_SIGN_OUT ?>";
        const ACTION_REMOVE_DISCU = "<?= ControllerHome::ACTION_REMOVE_DISCU ?>";
        const ACTION_OPEN_PROFILE = "<?= ControllerHome::ACTION_OPEN_PROFILE ?>";
        const ACTION_UPDATE_PROFILE = "<?= ControllerHome::ACTION_UPDATE_PROFILE ?>";
        // RSP keys
        const RSP_SEARCH_KEY = "<?= ControllerHome::RSP_SEARCH_KEY ?>";
        const RSP_WRITE_MENU = "<?= ControllerHome::RSP_WRITE_MENU ?>";
        const RSP_WRITE_DISCU_FEED = "<?= ControllerHome::RSP_WRITE_DISCU_FEED ?>";
        // other keys
        const FATAL_ERROR = "<?= MyError::FATAL_ERROR ?>";
        const DISCU_ID = "<?= Discussion::DISCU_ID ?>";
        const KEY_PICTURE = "<?= User::KEY_PICTURE ?>";
    </script>
    <?= $content ?>
</body>

</html>