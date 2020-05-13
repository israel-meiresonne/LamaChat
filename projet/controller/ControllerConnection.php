<?php

require_once 'framework/Controller.php';
require_once 'model/User.php';

/**
 * Contrôleur gérant la connexion au site
 *
 */
class ControllerConnection extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function index()
    {        
        // rnvs : test si déjà connecté : voir ConnectionController::connect()
        if ($this->request->getSession()->existingAttribute('idUser')) {
            $msg = "Vous êtes déjà connecté.";
            $logged = true;
        }
        else {
            $msg = "Veillez vous identifier.";
            $logged = false;
        }        
        $this->generateView(['msg' => $msg, 'logged' => $logged]);
    }

    public function connect()
    {
        // rnvs : ici on vérifie que les données de connexion
        //        ont été fournies par l'utilisateur
        // rnvs : elles sont dans $_POST inclus dans $request->paramaters
        // rnvs : TODO : on utilise les données brutes du formulaire...
        //        est-ce prudent ? 
        if ($this->request->existingParameter("login") && 
                $this->request->existingParameter("mdp")) {            
            
            $login = $this->request->getParameter("login");
            $pwd = $this->request->getParameter("mdp");
            
            // rnvs : ici on interroge le modèle (User) et on vérifie si
            //        les données de connexion sont ok
            if ($this->user->connect($login, $pwd)) {
                // rnvs : $user est un tableau associatif qui représente le
                //        tuple correspondant à l'utilisateur de $login / $pwd
                //        dans la table des utilisateurs
                $user = $this->user->getUser($login, $pwd);
                // rnvs : si la connexion réussit, stockage d'informations
                //        dans $_SESSION encapsulé dans l'attribut 
                //        $session de la requête
                $this->request->getSession()->setAttribute("idUser",
                        $user['idUser']);
                $this->request->getSession()->setAttribute("login",
                        $user['login']);
                // rnvs : redirection si connexion réussie
                $this->redirect("admin");
            }
            else
            {
                // rnvs : ici données de connexion ko
                // rnvs : ici on demande une action de vue (index) différente 
                //        de l'action du contrôleur (connect)
                $this->generateView(array(
                    'msg' => "Veillez vous identifier.", 
                    'logged' => false,
                    'msgError' => 'Login ou mot de passe incorrects'),
                        "index");
            }
        }
        else
        {
            // rnvs : ici pas d'info de connexion fournies
            throw new Exception("Action impossible : login ou mot de passe non défini");
        }
    }

    public function disconnect()
    {
        $this->request->getSession()->destroy();
        $this->redirect("home");
    }

}
