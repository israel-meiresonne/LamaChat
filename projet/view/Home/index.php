<?php // rnvs : ici assignation de l'attribut $title de View
$this->title = "Mon Blog";

if (isset($login))
{
    $this->title .= " - ".$login;
}

// rnvs : https://www.php.net/manual/en/control-structures.foreach.php#82511
// rnvs : syntaxe alternative foreach sans { } mais avec : et endforeach;
foreach ($posts as $post):
    // rnvs : la variable $posts existe car dans View::generateFile()
    //        on a appelé  extract($datas) or $datas est un tableau
    //        associatif dont un élément a pour clé la valeur '$posts'
    //        voir ControllerHome::index
    // rnvs : $posts est un PDOStatement => $post est un tableau associatif
    //        dont chaque élément représente un tuple de la table T_BILLET
    ?>
    <article>
        <header>
            <!-- rnvs : $post['id'] est la valeur de la colonne 'id' du tuple
                        courant, c.-à-d. l'identifiant du post courant -->
            <!-- rnvs : dans template.hpp qui enveloppe de contenu d'index.php
                        on a <base ... > qui adapte les url relatives
                        à la racine du site
                        grâce à <base ...> et .htaccess, 
                        post/index/".$this->clean($post['id']) 
                        est remplacé par
                        webRoot/index.php?controller=post&action=index&id=$post['id'] -->
            <a href="<?= "post/index/" . $this->clean($post['id']) ?>">
                <h1 class="postTitle"><?= $this->clean($post['title']) ?></h1>
            </a>
            <time><?= $this->clean($post['date']) ?></time>
        </header>
        <p><?= $this->clean($post['content']) ?></p>
    </article>
    <hr />
<?php endforeach; ?>
