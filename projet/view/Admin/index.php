<?php $this->title = "Mon Blog - Administration" ?>

<h2>Administration</h2>

Bienvenue, <?= $this->clean($login) ?> !
Ce blog comporte <?= $this->clean($nbPosts) ?> billet(s) et <?= $this->clean($nbComments) ?> commentaire(s).
<br>
<a id="decoLink" href="connection/disconnect">Se déconnecter</a>