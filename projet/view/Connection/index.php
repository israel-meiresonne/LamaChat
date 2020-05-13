<?php $this->title = "Mon Blog - Connexion" ?>

<p><?= $msg ?></p>

<?php if (! $logged) { ?>
<!-- rnvs : <base> dans template.php ajoute webRoot aux url locales -->
<!-- rnvs : grâce à .htaccess, connection/connect est remplacé par
            index.php?controller=connection&action=connect&id= -->
<form action="connection/connect" method="post">
    <input name="login" type="text" placeholder="Entrez votre login" required autofocus>
    <input name="mdp" type="password" placeholder="Entrez votre mot de passe" required>
    <button type="submit">Connexion</button>
</form>
<?php } ?>

<?php if (isset($msgError)): ?>
    <p><?= $msgError ?></p>
<?php endif; ?>
