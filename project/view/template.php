<!DOCTYPE html>
<!-- rnvs : modèle utilisé par toutes les pages du site
            les contenus spécifiques sont insérés dans le 
            <div> d'id 'content' -->
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <!-- rnvs : https://developer.mozilla.org/en-US/docs/Web/HTML/Element/base 
                    The HTML <base> element specifies the base URL to use for 
                    all relative URLs in a document. -->
        <base href="<?= $webRoot ?>" >
        <link rel="stylesheet" href="content/style.css" />
        <title><?= $title ?></title>
    </head>
    <body>
        <div id="global">
            <header>
                <a href=""><h1 id="blogTitle">Mon Blog</h1></a>
                <p>Je vous souhaite la bienvenue sur ce modeste blog.</p>
            </header>
            <div id="content">
                <!-- rnvs : ici inclusion du corps spécifique à la vue -->
                <?= $content ?>
            </div> <!-- #content -->
            <footer id="blogFooter">
                Blog réalisé avec PHP, HTML5 et CSS.
            </footer>
        </div> <!-- #global -->
    </body>
</html>