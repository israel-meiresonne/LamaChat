<?php

// rnvs : ajout pour déboguer... car je n'arrive pas à utiliser __debugInfo()
//        #boulet
//        voir tout en bas ↓
// rnvs : info trouvée par nri
//        le soucis vient de Xdebug ?
//        sans Xdebug : ça le fait : var_dump() invoque __debugInfo()
//        parade avec Xdebug : hériter de stdClass : extends stdClass
require_once 'Configuration.php';

/**
 * Classe modélisant la session.
 * Encapsule la superglobale PHP $_SESSION.
 *
 * rnvs : extends stdClass
 *        solution trouvée par nri pour que __debugInfo() soit appelé
 *        par var_dump() alors que le module Xdebug est chargé
 *
 */
class Session extends stdClass
{
    /**
     * Constructeur.
     * Démarre ou restaure la session
     */
    public function __construct()
    {
        // rnvs : https://www.php.net/manual/en/function.session-start
        session_start();
        // rnvs : session avec options par défaut :
        // https://www.php.net/manual/en/session.configuration.php
        // par exemple :
        //    + utilisation d'un cookie pour gérer la session
        // https://www.php.net/manual/en/session.configuration.php#ini.session.use-cookies
        //    + fin de la session à la fermeture du navigateur
        // https://www.php.net/manual/en/session.configuration.php#ini.session.cookie-lifetime
        //      attention : si browser configuré tel que restauration des
        //      onglets au démarrage, le cookie de session pourrait ne pas
        //      être supprimé

        // rnvs : start
        // rnvs : pour déboguer parce que je n'arrive pas
        //        à utiliser __debugInfo()
        //        voir tout en bas ↓
        if (Configuration::get("verboseRequest")) {
            $this->forDebugPurposeOnly_wrappedSESSION = $_SESSION;
        }
        // rnvs : end
    }

    /**
     * Détruit la session actuelle
     */
    public function destroy()
    {
        // rnvs : https://www.php.net/manual/en/function.session-destroy
        session_destroy();
        // rnvs : appelé par ControllerConnection::disconnect()
    }

    /**
     * Ajoute un attribut à la session
     *
     * @param string $name Nom de l'attribut
     * @param string $value Valeur de l'attribut
     */
    public function setAttribute($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * Renvoie vrai si l'attribut existe dans la session
     *
     * @param string $name Nom de l'attribut
     * @return bool Vrai si l'attribut existe et sa valeur n'est pas vide
     */
    public function existingAttribute($name)
    {
        return (isset($_SESSION[$name]) && $_SESSION[$name] != "");
    }

    /**
     * Renvoie la valeur de l'attribut demandé
     *
     * @param string $name Nom de l'attribut
     * @return string Valeur de l'attribut
     * @throws Exception Si l'attribut n'existe pas dans la session
     */
    public function getAttribute($name)
    {
        if ($this->existingAttribute($name)) {
            return $_SESSION[$name];
        }
        else {
            throw new Exception("Attribut '$name' absent de la session");
        }
    }

    // rnvs : https://stackoverflow.com/a/25945059
    // rnvs : https://www.php.net/manual/en/language.oop5.magic.php#object.debuginfo
    // rnvs : pour customizer var_dump()
    // rnvs : problème : ça ne fonctionne pas : var_dump() n'utilise pas
    //        __debugInfo
    // rnvs : problème quand le module Xdebug est utilisé
    // rnvs : nri a trouvé une parade : dériver de stdClass
    //        voir ci-dessus
    public function __debugInfo() {
        return ['SESSION_encapsulee' => $_SESSION];   // rnvs : ce que je veux
    }

}
