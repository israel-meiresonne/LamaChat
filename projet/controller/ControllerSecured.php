<?php

require_once 'framework/Controller.php';

/**
 * Classe parente des contrôleurs soumis à authentification
 * 
 * rnvs : classe abstraite car méthode Controller::index() abstraite
 * 
 * rnvs : cette classe redéfinit la méthode Controller::executeAction
 *        pour vérifier si des données de connexion existent avant de 
 *        procéder à l'invocation de la méthode d'action
 *
 */
abstract class ControllerSecured extends Controller
{

    public function executeAction($action)
    {
        // Vérifie si les informations utilisateur sont présents dans la session
        // Si oui, l'utilisateur s'est déjà authentifié : l'exécution de l'action continue normalement
        // Si non, l'utilisateur est renvoyé vers le contrôleur de connexion
        if ($this->request->getSession()->existingAttribute("idUser")) {
            parent::executeAction($action);
        }
        else {
            $this->redirect("connection");
        }
    }

    /**
     * Appel pour génèrer la vue associée au contrôleur courant
     * 
     * @param array $datasView Données nécessaires pour la génération de la vue
     * @param string $action Action associée à la vue (permet à un contrôleur de générer une vue pour une action spécifique)
     */
    /*
    protected function generateView($datasView = array(), $action = null)
    {
        parent::generateView($datasView, $action);
    }
     */ // rnvs : comm : inutile
}

