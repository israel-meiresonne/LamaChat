<?php

require_once 'Session.php';

/**
 * Classe modélisant une requête HTTP entrante.
 * 
 * rnvs : l'attribut $parameters est la fusion des tableaux $_GET et $_POST
 * 
 * rnvs : l'attribut $session encapsule le tableau $_SESSION
 * 
 */
class Request
{
    /** Tableau des paramètres de la requête */
    // rnvs : tableau associatif avec les clés + valeurs des variables
    //        $_GET et $_POST
    private $parameters;

    /** Objet session associé à la requête */
    // rnvs : instance de Session qui crée / prolonge une session et 
    //        enveloppe $_SESSION
    private $session;

    /**
     * Constructeur
     * 
     * @param array $parameters Paramètres de la requête
     */
    public function __construct($parameters)
    {
        $this->parameters = $parameters;
        
        // rnvs : création / prolongement de la session dans ctor de Session
        $this->session = new Session();
    }

    /**
     * Renvoie l'objet session associé à la requête
     * 
     * rnvs : pour l'accès à $_SESSION via les méthodes de Session
     * 
     * @return Session Objet session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Renvoie vrai si le paramètre existe dans la requête
     * 
     * rnvs : il s'agit d'un paramètre $_GET ou $_POST de la requête
     * 
     * @param string $name Nom du paramètre
     * @return bool Vrai si le paramètre existe et sa valeur n'est pas vide 
     */
    public function existingParameter($name)
    {
        return (isset($this->parameters[$name]) && $this->parameters[$name] != "");
    }

    /**
     * Renvoie la valeur du paramètre demandé
     * 
     * rnvs : il s'agit d'un paramètre $_GET ou $_POST de la requête
     * 
     * @param string $name Nom d paramètre
     * @return string Valeur du paramètre
     * @throws Exception Si le paramètre n'existe pas dans la requête
     */
    public function getParameter($name)
    {
        if ($this->existingParameter($name)) {
            return $this->parameters[$name];
        }
        else {
            throw new Exception("Paramètre '$name' absent de la requête");
        }
    }

}

