<?php

require_once 'framework/Model.php';

/**
 * Fournit les services d'accès aux billets du blog 
 * 
 * rnvs : aller lire la doc de Model::executeRequest() 
 * 
 * rnvs : méthodes pour récupérer : 
 *              + tous les posts (billets de blog)
 *              + 1 post précis sur base de son identifiant
 *              + le nombre de billets de blogs
 * 
 * rnvs : les méthodes de Post pourraient toutes être static...
 *        @nvs : TODO 2021
 */
class Post extends Model {

    /** Renvoie la liste des billets du blog
     * 
     * rnvs : retour PDOStatement c.-à-d. curseur : fetch(), fetchAll(), etc.
     * 
     * @return PDOStatement La liste des billets
     */
    public function getPosts() {
        $sql = 'select BIL_ID as id, BIL_DATE as date,'
                . ' BIL_TITRE as title, BIL_CONTENU as content from T_BILLET'
                . ' order by BIL_ID desc';
        // rnvs : ici requête toute faite
        
        // $posts = $this->executeRequest($sql);    // rnvs : comm (static)
        // rnvs : https://www.php.net/manual/en/language.oop5.static.php
        $posts = parent::executeRequest($sql);    // rnvs : ajout (static)
        
        return $posts;
    }

    /** Renvoie les informations sur un billet
     * 
     * rnvs : plutôt : Renvoie un billet
     * 
     * rnvs : retourne un tableau associatif qui correspond au 1er tuple
     *        dans le PDOStatement (curseur) qui correspond à la requête
     *        (normalement il ne doit  y avoir qu'un tuple car $idPost est
     *        la clé primaire)
     *        les clés du tableau associatif sont des chaînes qui correspondent
     *        au nom de la colonne ou à son index
     *        p. ex. ici id est la 1re colonne => si on stocke le retour de
     *               getPost() dans une variable nommée $retour,  
     *               on peut interroger $retour['id'] ou $retour[0]
     *               (l'entier 0 est transtypé en string '0')
     * 
     * @param int $id L'identifiant du billet
     * @return array Le billet
     * @throws Exception Si l'identifiant du billet est inconnu
     */
    public function getPost($idPost) {
        $sql = 'select BIL_ID as id, BIL_DATE as date,'
                . ' BIL_TITRE as title, BIL_CONTENU as content from T_BILLET'
                . ' where BIL_ID=?';
        // rnvs : requête préparée avec 1 marqueur (placeholder)
        //          => executeRequest avec un tableau à une valeur en paramètre
        // $post = $this->executeRequest($sql, array($idPost)); // rnvs : comm (static)
        $post = parent::executeRequest($sql, array($idPost));    // rnvs : ajout (static)
        
        // rnvs : ici $post est un PDOStatement
        
        // rnvs : https://www.php.net/manual/en/pdostatement.rowcount.php
        // rnvs : problème : returns the number of rows affected by the last 
        //        DELETE, INSERT, or UPDATE statement executed... For most 
        //        databases, PDOStatement::rowCount() does not return the 
        //        number of rows affected by a SELECT statement.
        /*
        if ($post->rowCount() > 0)
            return $post->fetch();  // Accès à la première ligne de résultat
        else
            throw new Exception("Aucun billet ne correspond à l'identifiant '$idPost'");
         */ // rnvs : comm car rowCount() pas ok...
        
        // rnvs : start
        // https://www.php.net/manual/en/pdostatement.fetchall.php
        // les éléments de l'array retournée pas fetchAll sont des tableaux
        // associatifs qui représentent les tuples du PDOStatement (curseur)
        // on a ici PDO::FETCH_BOTH => accès aux colonnes du tuple par nom ou 
        // par indice (voir commentaire de la méthode ci-dessus)
        $postArray = $post->fetchAll();
        
        // https://www.php.net/manual/en/function.count.php
        if (count($postArray) > 0) {
            return $postArray[0];   // retour du 1er (et seul normalement) tuple
        } else {
            throw new Exception("Aucun billet ne correspond à l'identifiant '$idPost'");
        }
        // rnvs : end
    }

    /**
     * Renvoie le nombre total de billets
     * 
     * rnvs : retourne un entier
     * 
     * @return int Le nombre de billets
     */
    public function getNumberPosts()
    {
        $sql = 'select count(*) as nbPosts from T_BILLET';
        // $result = $this->executeRequest($sql);   // rnvs : comm (static)
        $result = parent::executeRequest($sql);   // rnvs : ajout (static)
        // rnvs : https://www.php.net/manual/en/pdostatement.fetch.php
        // rnvs : on a ici PDO::FETCH_BOTH 
        //          => $line représente le prochain tuple du curseur sous
        //             la forme d'un tableau associatif où on peut accéder
        //             à une colonne du tuple par son nom ou par son indice
        //             dans le tuple
        $line = $result->fetch();  // Le résultat comporte toujours 1 ligne
        return $line['nbPosts'];    // rnvs : ici accès par le nom
        // rnvs : on aurait pu avoir $line[0]
    }
}