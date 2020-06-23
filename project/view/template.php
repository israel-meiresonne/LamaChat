<!DOCTYPE html>
<html lang="fr">
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

<script src="content/js/pages.js"></script>
<script src="content/js/element.js"></script>
<script src="content/js/src.js"></script>

<body>
    <script>
        const TS = 450;
        const BNR = 1000000;
    </script>
    <?= $content ?>
</body>

</html>