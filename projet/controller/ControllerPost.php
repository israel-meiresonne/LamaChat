<?php

require_once 'framework/Controller.php';
require_once 'model/Post.php';
require_once 'model/Comment.php';
/**
 * Contrôleur des actions liées aux billets
 *
 * nvs : contrôleur des actions possibles sur un billet de blog
 *
 */
class ControllerPost extends Controller {

    private $post;
    private $comment;

    /**
     * Constructeur
     */
    public function __construct() {
        $this->post = new Post();
        $this->comment = new Comment();
    }

    // Affiche les détails sur un billet
    public function index() {
        // rnvs : si on arrive ici depuis la page maison (homepage),
        //        le paramètre de requête 'id' est transmis par
        //        la méthode get (via redirection .htaccess)
        //        voir view/Home/index.php
        // rnvs : si on arrive ici suite à l'envoir d'un commentaire,
        //        c.-à-d. depuis ControllerPost::comment(), donc depuis
        //        ici, le paramètre de requête 'id' est transmis par
        //        la méthode post depuis un input caché du formulaire
        //        de la vue view/Post/index.php
        $idPost = $this->request->getParameter("id");

        $post = $this->post->getPost($idPost);
        $comments = $this->comment->getComments($idPost);

        $this->generateView(array('post' => $post, 'comments' => $comments));
    }

    // Ajoute un commentaire sur un billet
    public function comment() {
        // rnvs : le paramètre de requête 'id' est transmis
        //        (méthode post) par un input caché du dans
        //        le formulaire html de la vue view/Comment/index.php
        $idPost = $this->request->getParameter("id");

        // rnvs : dans le formulaire html, le champ author est
        //        transmis par la méthode post et _obligatoire_
        //        voir view/Comment/index.php
        //        mais on vérifie quand même bien côté serveur
        //        que le champ existe : Request::getParameter lève
        //        une exception si author est absent
        // rnvs : pour le tester : essayer la requête
        //        post/comment/1
        $author = $this->request->getParameter("author");

        // rnvs : même remarque que pour le champ author
        $content = $this->request->getParameter("content");

        $this->comment->addComment($author, $content, $idPost);

        // Exécution de l'action par défaut pour réafficher la liste des billets
        // rnvs : le commentaire ci-dessus n'est pas ok
        //        on ne réaffiche pas la liste des billets mais
        //        on réaffiche le billet courant
        $this->executeAction("index");
        // rnvs : il faut faire comme ci-dessus : $this->executeAction("index");
        //        ce n'est pas équivalent à faire $this->index();
        //        car si on invoque $this->index(); on ne change pas
        //        la valeur de l'attribut $this->action qui continue
        //        d'être 'comment' => quand on fait generateView, c'est le
        //        fichier view/Post/comment.php qui est utilisé
        //        tandis que si on fait $this->executeAction("index"); alors
        //        on change $this->action en 'index'
        //        (voir Controller::executeAction()) puis on invoque
        //        $this->index(); où le fichier view/Post/index.php est
        //        ensuite utilisé dans le constructeur de View invoqué dans
        //        Controller::generateView()
        // $this->index();     // rnvs : ajout : mais ko => comm
    }
}
