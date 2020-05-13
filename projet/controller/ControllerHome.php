<?php

require_once 'framework/Controller.php';
require_once 'model/Post.php';

class ControllerHome extends Controller {

    // rnvs : aller lire la doc de Post
    // rnvs : si on met toutes les méthodes de Post static, alors l'attribut
    //        $post ici n'est plus nécessaire.
    //        @nvs : TODO 2021
    // rnvs : par le biais de $post on interroge BD pour récupérer les posts
    //        (aka les billets de blog, les messages postés), 
    //        attention : rien à voir avec $_POST !
    private $post;

    public function __construct() {
        // rnvs : ici instanciation du modèle
        // rnvs : si méthodes de Post static, ceci n'est plus nécessaire...
        //        @nvs : TODO 2021
        $this->post = new Post();
    }

    // Affiche la liste de tous les billets du blog
    public function index() {
        // rnvs : ici interrogation du modèle par le contrôleur
        $posts = $this->post->getPosts();
        // rnvs : $posts est un PDOStatement (curseur) qui contient 
        // l'ensemble des billets stockés dans la BD
        
        // rnvs : ici les données ont été récupérées par le contrôleur
        //        depuis le modèle
        
        // rnvs : $datas : tableau associatif
        //        de clé 'posts' et de valeur $posts
        //        la valeur est donc un PDOStatement avec l'ensemble 
        //        des billets
        $datas = [ 'posts' => $posts ];
        
        // rnvs : la session est dotée d'un attribut 'login' dans
        //        l'action 'connect' du contrôleur 'Connection',
        //        ControllerConnection::connect() si la connexion a réussi
        if ($this->request->getSession()->existingAttribute('login')) {
            // rnvs : ajout de l'élément de clé 'login' à $datas
            //        si utilisateur identifié            
            $datas['login'] = $this->request->getSession()->getAttribute('login');
        }
        
        // rnvs : dans Controller::generateView(), le tableau $datas 
        //        est transmis à la vue via View::generate()
        $this->generateView($datas);
        // rnvs : le nom de la clé : posts 
        //        cela permet d'utiliser une variable nommée $posts dans
        //        view/Home/index.php
        
        // rnvs : Controller::generateView termine par l'appel de la méthode
        //        View::generate qui elle même termine par l'appel de
        //        la « fonction » echo qui envoie la réponse au client
        //        => on peut retourner à la fin de Controller::executeAction
    }

}
