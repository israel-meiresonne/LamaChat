<?php

require_once 'Configuration.php';

/**
 * Classe abstraite modèle.
 * Centralise les services d'accès à une base de données.
 * Utilise l'API PDO de PHP.
 * 
 * rnvs : classe DBManager : établit connexion avec BD et 
 *        offre une méthode pour l'interroger via reqête toute prête
 *        ou requête préparée
 *
 */
abstract class Model
{
    /** Objet PDO d'accès à la BD 
      Statique donc partagé par toutes les instances des classes dérivées */
    private static $db;

    /**
     * Exécute une requête SQL
     * 
     * rnvs : $sql est une string : requête ou requête préparée
     *      + si $sql est une requête toute prête, alors $params ne doit
     *        pas être fourni ou rester $null
     *      + si $sql est une requête préparée, il y a 2 possibilité :
     *          - requête préparée avec des jokers du type :v1, :v2 (etc.)
     *            appelées variables liées (bound variables)
     *          - requête préparée avec des jokers de type ?, ? (etc.) appelés
     *            marqueurs (placeholders)
     * 
     * rnvs : $params utilisé uniquement pour requête préparée :
     *      + si requête préparée avec variables liées, $params est un
     *        tableau associatif : array('v1' => $valeur1, 'v2' => $valeur2)
     *        c.-à-d. qu'on utilise comme clé le nom de la variable liée (sous
     *        la forme d'une string) et comme valeur la valeur qu'on donne
     *        à la variable liée 
     *      + si requête préparée avec marqueurs, $params est un
     *        tableau : array($valeur1, $valeur2) où $valeur1 est associée
     *        au 1er marqueur, $valeur2 au 2e (etc.)
     * 
     * @param string $sql Requête SQL
     * @param array $params Paramètres de la requête
     * @return PDOStatement Résultats de la requête
     */
    // protected function executeRequest($sql, $params = null) // rnvs : comm (static)
    protected static function executeRequest($sql, $params = null) // rnvs : ajout (static)
    {
        if ($params == null) {
            // rnvs : https://www.php.net/manual/en/pdo.query.php
            // rnvs : donc si $params est null, 
            //        $sql est la requête à exécuter telle quelle
            $result = self::getDb()->query($sql);   // exécution directe
        }
        else {
            // rnvs : https://www.php.net/manual/en/pdo.prepare.php
            // rnvs : donc si $params est non null, $sql est une requête 
            //        $sql est une requête préparée avec variables liées
            //        ou marqueurs (voir commentaire de méthode ci-dessus)
            $result = self::getDb()->prepare($sql); // requête préparée
            
            // rnvs : https://www.php.net/manual/en/pdostatement.execute.php
            // rnvs : donc si $params est non null, 
            //        $params est un tableau associatif (si utilisation de 
            //        variables liées) ou simple (si utilisation de marqueurs)
            //        (voir commentaire de méthode ci-dessus)
            $result->execute($params);
        }
        // rnvs : dans tous les cas, PDOStatement retourné
        // rnvs : https://www.php.net/manual/en/class.pdostatement.php
        //        c.-à-d. un curseur : fetch(), fetchAll(), closeCursor(), etc.
        return $result;
    }

    /**
     * Renvoie un objet de connexion à la BDD en initialisant la connexion au besoin
     * 
     * @return PDO Objet PDO de connexion à la BDD
     */
    private static function getDb()
    {
        if (self::$db === null) {
            // Récupération des paramètres de configuration BD
            $dsn = Configuration::get("dsn");   // rnvs : data source name
            $login = Configuration::get("login");
            $pwd = Configuration::get("mdp");
            
            // Création de la connexion
            // rnvs : https://www.php.net/manual/en/pdo.construct.php
            //        pour ce qui concerne le tableau associatif en 4e argument
            //        aller voir ici : 
            //        https://www.php.net/manual/en/pdo.setattribute.php
            //        ici on demande de lever une exception en cas d'erreur
            self::$db = new PDO($dsn, $login, $pwd,
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        return self::$db;
    }

}
