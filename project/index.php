<?php
// rnvs : début
require 'framework/Configuration.php';
$verboseError = Configuration::get("verboseError");
if ($verboseError) {
    // rnvs : https://blog.teamtreehouse.com/how-to-debug-in-php
    // rnvs : avec xdebug c'est encore mieux
    // rnvs : https://xdebug.org/
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
}
// rnvs : fin
// 
// Contrôleur frontal : instancie un router pour traiter la requête entrante
// rnvs : https://www.php.net/manual/en/function.require.php
require 'framework/Router.php';

// rnvs : le ctor de Router ne fait rien, pas d'initialisation ni rien,
//        à part créer l'instance qu'on peut utiliser ensuite
// $router = new Router();  // rnvs : comm (static)

// rnvs : TOUT se passe dans routerRequest() !
// $router->routerRequest();    // rnvs : comm (static)
Router::routerRequest();       // rnvs : ajout (static)

// rnvs : ici c'est fini : la page (réponse) est générée et envoyée au client
