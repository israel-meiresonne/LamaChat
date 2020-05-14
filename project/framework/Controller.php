<?php

require_once 'Configuration.php';
require_once 'Request.php';
require_once 'View.php';

/**
 * Classe abstraite contrôleur. 
 * Fournit des services communs aux classes contrôleurs dérivées.
 * 
 * rnvs : classe abstraite car méthode Controller::index() abstraite
 * 
 */
abstract class Controller {

    /** Action à réaliser */
    // rnvs : setté dans executeAction()
    private $action;

    /** Requête entrante */
    protected $request;

    /**
     * Définit la requête entrante
     * 
     * rnvs : utilisé uniquement dans Router::createController()
     * 
     * @param Request $request Request entrante
     */
    public function setRequest(Request $request) {
        $this->request = $request;
    }

    /**
     * Exécute l'action à réaliser.
     * Appelle la méthode portant le même nom que l'action sur l'objet Controller courant
     * 
     * @throws Exception Si l'action n'existe pas dans la classe Controller courante
     */
    public function executeAction($action) {
        // rnvs : c'est la méthode qui sert de point d'entrée au
        //        contrôleur effectif
        //        elle est appelée en fin de Router::routerRequest()
        
        
        // rnvs : vérification si l'objet courant possède une méthode dont le
        //        nom est stocké dans la variable $action
        // rnvs : https://www.php.net/manual/en/function.method-exists.php
        if (method_exists($this, $action)) {
            // rnvs : attribut $action setté
            $this->action = $action;
            
            // rnvs : invocation de la méthode dont le nom est le contenu
            //        de l'attribut $action de l'objet courant !
            $this->{$this->action}();
            
            // rnvs : arrivé ici, on retourne à Router::routerRequest()
            //        qui termine et retourne à index.php qui termine
            //        donc ici le script ne fait plus rien : la page (réponse)
            //        a été envoyée au client, le traitement de la requête
            //        du client est terminé 
            
        } else {
            // rnvs : récupération du nom de la classe de $this c.-à-d. du
            //        Controller effectif (dans une classe dérivée de celle-ci)
            //        sous la forme d'une string
            // rnvs : https://www.php.net/manual/en/function.get-class.php
            $classController = get_class($this);
            
            throw new Exception("Action '$action' non définie dans la classe $classController");
            
            // rnvs : cette exception est catchée dans Router::routerRequest()
        }
    }

    /**
     * Méthode abstraite correspondant à l'action par défaut
     * Oblige les classes dérivées à implémenter cette action par défaut
     */
    public abstract function index();
    // rnvs : rappel : l'action par défaut d'un Controller s'appelle
    //        index => tout contrôleur doit implémenter une telle méthode 

    /**
     * Génère la vue associée au contrôleur courant
     * 
     * rnvs : cette méthode doit probablement être la dernière à être
     *        invoquée par la méthode de l'action du contrôleur effectif
     *        car elle termine par la « fonction » echo qui envoie la
     *        réponse au client
     * 
     * rnvs : pas de valeur retournée
     * 
     * rnvs : argument $datasView : tableau associatif où la clé identifie 
     *        la nature de la donnée
     *        cet argument n'est pas modifié ici, il est fourni tel quel
     *        à View::generate()
     * 
     * rnvs : argument $action pour spécifier l'action associée à la vue,
     *        par défaut c'est la même action que celle du contrôleur
     * 
     * rnvs : pour un exemple d'action de contrôleur qui demande une action
     *        de vue différente différente de l'action du contrôleur, aller
     *        voir ControllerConnection::connect si connexion échoue
     * 
     * @param array $datasView Données nécessaires pour la génération de la vue
     * @param string $action Action associée à la vue (permet à un contrôleur de générer une vue pour une action spécifique)
     */
    protected function generateView($datasView = array(), $action = null) {
        // Utilisation de l'action actuelle par défaut
        // $actionView = $this->action;  // rnvs : comm
        // if ($action != null) {        // rnvs : comm
        // Utilisation de l'action passée en paramètre
        //      $actionView = $action;    // rnvs : comm
        // }
        
        // rnvs : détermination de l'action associée à la vue 
        //        comme l'attribut $action est une string qui ne stocke
        //        qu'une valeur, on est parfois amené à ce qu'un contrôleur
        //        effectif demande une action de vue différente de sa
        //        propre action, p. ex. si l'action du contrôleur demande
        //        l'utilisation de plusieurs vues ou de plusieurs actions 
        //        d'une même vue
        $actionView = $action == null ? $this->action : $action;    // rnvs : ajout
        
        // Utilisation du nom du contrôleur actuel
        // rnvs : get_class retourne une string : 
        // le nom de la classe du contrôleur effectivement appelé
        $classController = get_class($this);
        
        // rnvs : https://www.php.net/manual/en/function.str-replace.php
        //        on se débarrasse du mot Controller, 
        //        p. ex. si le nom du contrôleur est la string
        //        "ControllerHome", on obtient "Home"
        $controllerView = str_replace("Controller", "", $classController);

        // Instanciation et génération de la vue
        // rnvs : le ctor de View ne fait que construire le chemin
        //        vers le fichier qui correspond à l'action ($actionView)
        //        de la vue effective ($actionView), c.-à-d.
        //        view/$controllerView/$actionView.php
        //        et stocke ce chemin comme une string dans l'attribut $file
        //        de la View
        // rnvs : en particulier : il y a 1! classe vue (View)
        $view = new View($actionView, $controllerView);
        
        // rnvs : rappel : $dataview est un tableau associatif produit
        //        dans la méthode de l'action du contrôleur effectivement
        //        appelé
        // rnvs : c'est dans View::generate que la page réponse à la requête
        //        est construite et envoyée au client
        $view->generate($datasView);
        
        // rnvs : quand on arrive ici, la réponse a été envoyée au client
        //        en effet, View::generate termine par un appel à la 
        //        « fonction » echo
        //        on peut donc (dans la majorité des cas), remonter la pile 
        //        des appels de méthodes pour revenir à index.php
        //        via (dans la majorité des cas) 
        //        la méthode de l'action du contrôleur effectif
        //        appelée par Controller::executeAction 
        //        appelée par Router::routerRequest
        
    }

    /**
     * Effectue une redirection vers un contrôleur et une action spécifiques
     * 
     * rnvs : sert à rediriger vers l'action $action 
     *        du contrôleur de nom $controller (nom court : 'Home' pour
     *        'ControllerHome'
     * 
     * @param string $controller Contrôleur
     * @param type $action Action Action
     */
    protected function redirect($controller, $action = null) {
        $webRoot = Configuration::get("webRoot", "/");
        // Redirection vers l'URL /racine_site/controller/action
        // rnvs : https://www.php.net/manual/en/function.header.php
        //        header() must be called before any actual output is sent
        //        There are two special-case header calls.
        //        ...
        //        The second special case is the "Location:" header. Not 
        //        only does it send this header back to the browser, but 
        //        it also returns a REDIRECT (302) status code to the browser 
        //        unless the 201 or a 3xx status code has already been set.
        // rnvs : $webroot termine par '/'
        // rnvs : .htaccess, va remplacer $controller/$action par
        //        index.php?controller=$controller&action=$action&id=
        header("Location:" . $webRoot . $controller . "/" . $action);
    }

}
