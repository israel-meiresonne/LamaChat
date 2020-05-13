<?php

require_once 'framework/Model.php';

/**
 * Fournit les services d'accès aux commentaires
 *
 * rnvs : lire doc de Model pour Model::executeRequest()
 *
 * méthodes pour :
 *      + récupérer tous les commentaires d'un billet (post) donné
 *      + ajouter un commentaire à un billet donné
 *      + récupérer le nombre de commentaires d'un post donné
 *
 * rnvs : les méthodes de Comment pourraient toutes être static...
 *        @nvs : TODO 2021
 *
 */
class Comment extends Model {

    /**
     * Renvoie la liste des commentaires associés à un billet
     *
     * rnvs : retourne PDOStatement (curseur) avec tous les commentaires
     *        du post d'identifiant $idPost
     *        rem. : la colonne BIL_ID n'est pas dans les tuples du
     *               PSOStatement retourné
     *               le PSOStatement peut être vide
     *
     * @param type $idPost
     * @return type
     */
    public function getComments($idPost) {
        $sql = 'select COM_ID as id, COM_DATE as date,'
                . ' COM_AUTEUR as author, COM_CONTENU as content from T_COMMENTAIRE'
                . ' where BIL_ID=?';

        // $comments = $this->executeRequest($sql, array($idPost)); // rnvs : comm (static)
        $comments = parent::executeRequest($sql, array($idPost));    // rnvs : ajout (static)

        return $comments;
    }

    /**
     *
     * rnvs : ajoute un commentaire à un post (billet)
     *
     * rnvs : pas de valeur retournée
     *
     * @param type $author
     * @param type $content
     * @param type $idPost
     */
    public function addComment($author, $content, $idPost) {
        $sql = 'insert into T_COMMENTAIRE(COM_DATE, COM_AUTEUR, COM_CONTENU, BIL_ID)'
            . ' values(?, ?, ?, ?)';

        // https://www.php.net/manual/en/function.date.php
        // $date = date(DATE_W3C);  // rnvs : comm : ko chez moi...
        $date = date('Y-m-d H:i:s');    // rnvs : ajout : ok chez moi

        // $this->executeRequest($sql, array($date, $autor, $content, $idPost));    // rnvs : comm (static)
        parent::executeRequest($sql, array($date, $author, $content, $idPost));   // rnvs : ajout (static)
    }

    /**
     * Renvoie le nombre total de commentaires
     *
     * rnvs : retourne un entier
     *
     * @return int Le nombre de commentaires
     */
    public function getNumberComments()
    {
        $sql = 'select count(*) as nbComments from T_COMMENTAIRE';

        // $result = $this->executeRequest($sql);   // rnvs : comm (static)
        $result = parent::executeRequest($sql);  // rnvs : ajout (static)

        /*
        $line = $result->fetch();  // Le résultat comporte toujours 1 ligne
        return $line['nbComments'];
         */ // rnvs : comm : existe plus direct

        // rnvs : start
        // https://www.php.net/manual/en/pdostatement.fetchcolumn.php
        return $result->fetchColumn();
        // rnvs : end
    }
}
