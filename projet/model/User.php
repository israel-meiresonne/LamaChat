<?php

require_once 'framework/Model.php';

/**
 * Modélise un utilisateur du blog
 *
 * rnvs : lire doc de Model pour Model::executeRequest()
 * 
 * rnvs : fournit : 
 *          + une méthode pour checker userId / password 
 *          + une méthode pour récuperer le tuple correspondant à un user
 *            si userId / password sont ok
 * 
 * rnvs : les méthodes de User pourraient toutes être static...
 *        @nvs : TODO 2021
 */
class User extends Model {

    /**
     * Vérifie qu'un utilisateur existe dans la BD
     * 
     * rnvs : plutôt : 
     *        vérifie si la BD contient 
     *        un utilisateur d'id $login et de mot de passe $pwd : 
     *          si oui, retourne true, sinon retourne false 
     * 
     * @param string $login Le login
     * @param string $pwd Le mot de passe
     * @return boolean Vrai si l'utilisateur existe, faux sinon
     */
    public function connect($login, $pwd)
    {
        $sql = "select UTIL_ID from T_UTILISATEUR where UTIL_LOGIN=? and UTIL_MDP=?";
        
        // $user = $this->executeRequest($sql, array($login, $pwd));    // rnvs : comm (static)
        $user = parent::executeRequest($sql, array($login, $pwd));   // rnvs : ajout (static)
        
        // rnvs : https://www.php.net/manual/en/pdostatement.rowcount.php
        // rnvs : problème : returns the number of rows affected by the last 
        //        DELETE, INSERT, or UPDATE statement executed... For most 
        //        databases, PDOStatement::rowCount() does not return the 
        //        number of rows affected by a SELECT statement.
        /*
        return ($user->rowCount() == 1);
         */ // rnvs : comm car rowCount() pas ok...
        
        // rnvs : start
        // https://www.php.net/manual/en/pdostatement.fetchall.php
        // les éléments de l'array retournée pas fetchAll sont des tableaux
        // associatifs qui représentent les tuples du PDOStatement (curseur)
        // on a ici PDO::FETCH_BOTH => accès aux colonnes du tuple par nom ou 
        // par indice (voir commentaire de la méthode ci-dessus)
        $userArray = $user->fetchAll();
        
        // https://www.php.net/manual/en/function.count.php
        return count($userArray) == 1;
        // rnvs : end
    }

    /**
     * Renvoie un utilisateur existant dans la BD
     * 
     * rnvs : renvoie un tableau associatif qui représente un tuple de 
     *        la table User si $login et $pwd correspondent et sont ok
     *        dans ce tableau, on accède aux colonnes via 
     *        le nom de la colonne ou son indice 
     *        (voir doc de la classe Post pour explications détaillées)
     * 
     * @param string $login Le login
     * @param string $pwd Le mot de passe
     * @return mixed L'utilisateur
     * @throws Exception Si aucun utilisateur ne correspond aux paramètres
     */
    public function getUser($login, $pwd)
    {
        $sql = "select UTIL_ID as idUser, UTIL_LOGIN as login, UTIL_MDP as mdp 
            from T_UTILISATEUR where UTIL_LOGIN=? and UTIL_MDP=?";
        
        // $user = $this->executeRequest($sql, array($login, $pwd));    // rnvs : comm (static)
        $user = parent::executeRequest($sql, array($login, $pwd));   // rnvs : ajout (static)
        
        // rnvs : https://www.php.net/manual/en/pdostatement.rowcount.php
        // rnvs : problème : returns the number of rows affected by the last 
        //        DELETE, INSERT, or UPDATE statement executed... For most 
        //        databases, PDOStatement::rowCount() does not return the 
        //        number of rows affected by a SELECT statement.
        /*
        if ($user->rowCount() == 1)
            return $user->fetch();  // Accès à la première ligne de résultat
        else
            throw new Exception("Aucun utilisateur ne correspond aux identifiants fournis");
         */ // rnvs : comm car rowCount() pas ok...
        
        // rnvs : start
        // https://www.php.net/manual/en/pdostatement.fetchall.php
        // les éléments de l'array retournée pas fetchAll sont des tableaux
        // associatifs qui représentent les tuples du PDOStatement (curseur)
        // on a ici PDO::FETCH_BOTH => accès aux colonnes du tuple par nom ou 
        // par indice (voir commentaire de la méthode ci-dessus)
        $userArray = $user->fetchAll();
        
        // https://www.php.net/manual/en/function.count.php
        if (count($userArray) == 1) {
            return $userArray[0];   // Accès à la première ligne de résultat
        } else {
            throw new Exception("Aucun utilisateur ne correspond aux identifiants fournis");
        }
        // rnvs : end
    }

}

