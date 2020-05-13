<?php

require_once 'Configuration.php';

/**
 * Classe modélisant une vue.
 * 
 * rnvs : il n'y a qu'une seule classe vue, 
 *        mais à chaque action de chaque vue effective 
 *        correspond un fichier *.php qui est inclus dans 
 *        View::generateFile()
 * 
 * rnvs : pour chaque contrôleur, p. ex. ControllerHome, 
 *        il y a un sous-répertoire dans le dossier view
 *        dont le nom est celui du contrôleur sans Controller, 
 *        p. ex. : view/Home/
 *        j'appelle ce dossier « dossier de la vue effective » et j'y
 *        associe ce que j'appelle « vue effective »
 * rnvs : pour chaque vue effective, il peut exister plusieurs actions
 *        c.-à-d. différents fichiers dans, p. ex. view/Home/ : 
 *        view/Home/index.php, view/Home/show.php, etc.
 * 
 * rnvs : ce fichier d'action de la vue effective est le corps de la page
 *        web à retourner au client. ce corps est inséré dans le modèle
 *        template.php
 * 
 * rnvs : il est possible de créer des vues qui ne sont pas attachées à un
 *        contrôleur effectif, mais juste à une action.
 *        on a alors le fichier view/error.php, p. ex.
 * 
 * rnvs : résumé : 1 contrôleur effectif ←→ 1 vue effective
 *                 1 contrôleur effectif ←→ 1 classe ControllerXXX dérivant
 *                                          de la classe Controller
 *                 1 vue effective ←→ 1 répertoire view/XXX
 * 
 *                 1 contrôleur effectif ←→ plusieurs actions possibles
 *                 1 action du contrôleur effectif ←→ 1 méthode du contrôleur
 *                                                    effectif, p. ex.
 *                                                    ControllerXXX::index()
 * 
 *                 1 vue effective ←→ plusieurs actions possibles
 *                 1 action de la vue effective ←→ 1 fichier dans /view/XXX,
 *                                                 p. ex. view/XXX/index.php
 * 
 *                 c'est le contrôleur effectif qui fixe la vue effective 
 *                 et son action
 * 
 *                 ça se passe dans le ctor de View 
 *                 invoqué dans Controller::generateView elle-même 
 *                 invoquée dans la méthode de l'action du contrôleur effectif
 * 
 *                 l'action de la vue effective est représentée dans la classe
 *                 View sous la forme d'une string stockée dans $file dont
 *                 le contenu est le chemin vers le fichier de l'action de
 *                 la vue effective, p. ex. "view/XXX/index.php"
 */
class View
{
    /** Nom du fichier associé à la vue */
    // rnvs : string qui contient le chemin vers le fichier php qui correspond
    //        à l'action de la vue effective
    // rnvs : attribut construit et setté dans le ctor de View ci-dessous
    private $file;

    /** Titre de la vue (défini dans le fichier vue) */
    // rnvs : cet attribut est setté dans le fichier qui se trouve à 
    //        l'emplacement $file c.-à-d. dans le fichier d'action de 
    //        la vue que l'attribut
    // rnvs : cela se passe dans View::generateFile() 
    //        par le biais du statement require $file; 
    private $title;

    /**
     * Constructeur
     * 
     * rnvs : les 2 arguments sont des chaînes de caractères qui servent à
     *        produire le chemin vers le fichier de l'action de la vue effective
     * 
     * rnvs : $action est une string indiquant l'action de la vue effective  
     * 
     * rnvs : $controller est une string avec le nom du contrôleur appelant
     *        sans le mot Controller
     *        p. ex. si la View est construite par ControllerHome, la 
     *        string $controller est "Home"
     * 
     * rnvs : il est possible de créer des vues qui ne sont pas attachées à un
     *        contrôleur effectif, mais juste à une action.
     *        on a alors le fichier view/$action.php      
     * 
     * @param string $action Action à laquelle la vue est associée
     * @param string $controller Nom du contrôleur auquel la vue est associée
     */
    public function __construct($action, $controller = "")
    {
        // Détermination du nom du fichier vue à partir de l'action et du constructeur
        // La convention de nommage des fichiers vues est : view/<$controller>/<$action>.php
        
        $file = "view/";
        if ($controller != "") {
            // rnvs : par exemple si la string $controller est "Home", 
            //        $file devient "view/Home/"
            $file = $file . $controller . "/";
        }
        
        // rnvs : on indique ici l'action attachée à la vue, cette action
        //        peut-être l'action du contrôleur, soit une autre action
        //        fournie explicitement par le contrôleur par l'appel
        //        de la méthode Controller::generateView() par le contrôleur
        //        effectif (dans la méthode associée à son action)
        // rnvs : si l'action est celle du contrôleur et que l'action du
        //        contrôleur est celle par défaut, à savoir "index", on a
        //        $file et $this->file égaux à "view/Home/index.php"
        $this->file = $file . $action . ".php";
    }

    /**
     * Génère et affiche la vue
     * 
     * rnvs : cette méthode envoie la réponse au client donc après elle,
     *        il n'y a (probablement) plus rien à faire
     * 
     * rnvs : $datas est un tableau associatif : c'est le contenu qui doit
     *        être envoyé au client en réponse à sa requête
     *        ce tableau est utilisé par View::generateFile() pour mise en
     *        forme html
     * 
     * @param array $datas Données nécessaires à la génération de la vue
     */
    public function generate($datas)
    {
        // Génération de la partie spécifique de la vue
        $content = $this->generateFile($this->file, $datas);
        
        // rnvs : ici $content est une string dont le contenu est le corps
        //        de la page web à retourner au client où le contenu du
        //        tableau $datas a été inséré
        
        // On définit une variable locale accessible par la vue pour la racine Web
        // Il s'agit du chemin vers le site sur le serveur Web
        // Nécessaire pour les URI de type controller/action/id
        // rnvs : le chemin contenu par $webRoot termine par le caractère '/'
        $webRoot = Configuration::get("webRoot", "/");
        
        // Génération du gabarit commun utilisant la partie spécifique
        $view = $this->generateFile('view/template.php', 
                array('title' => $this->title, 
                    'content' => $content, 
                    'webRoot' => $webRoot));
        
        // Renvoi de la vue générée au navigateur
        // rnvs : https://www.php.net/manual/en/function.echo.php
        // rnvs : envoi de la réponse au client ici
        echo $view;
        
        // rnvs : ici la réponse a été envoyée au client
        //        on peut donc retourner à Controller::generateView
        //        et retourner (dans la majorité des cas) à index.php  
        //        via (dans la majorité des cas) 
        //        la méthode de l'action du contrôleur effectif
        //        appelée par Controller::executeAction 
        //        appelée par Router::routerRequest
    }

    /**
     * Génère un fichier vue et renvoie le résultat produit
     * 
     * rnvs : retourne une string dont le contenu est le fichier dont
     *        le chemin d'accès est contenu dans $file, fichier dont
     *        le contenu est garni avec les données du tableau associatif
     *        $datas, tableau éclaté en autant de variables qu'il possède
     *        d'éléments
     * 
     * @param string $file Chemin du fichier vue à générer
     * @param array $datas Données nécessaires à la génération de la vue
     * @return string Résultat de la génération de la vue
     * @throws Exception Si le fichier vue est introuvable
     */
    private function generateFile($file, $datas)
    {
        if (file_exists($file)) {
            // Rend les éléments du tableau $datas accessibles dans la vue
            // rnvs : https://www.php.net/manual/en/function.extract.php
            // rnvs : Import variables from an array into the current symbol 
            //        table.
            //        c.-à-d. pour chaque élément key => value ('abc' => 22,
            //        p.ex.) de $datas, crée une variable de nom $key 
            //        ($abc p. ex.) et de valeur value (22, p. ex.)
            extract($datas);
            
            // rnvs : ici on a 1 variable par élément de $datas
            
            // Démarrage de la temporisation de sortie
            // rnvs : https://www.php.net/manual/en/function.ob-start.php
            // rnvs : This function will turn output buffering on. While 
            //        output buffering is active no output is sent from the 
            //        script (other than headers), instead the output is 
            //        stored in an internal buffer.
            // rnvs : donc à partir d'ici les sorties ne sont pas écrites dans
            //        le script mais mises en tampon
            ob_start();
            
            // Inclut le fichier vue
            // Son résultat est placé dans le tampon de sortie
            // rnvs : le contenu du fichier de chemin $file n'est pas inclus
            //        dans le script ic-même mais copié dans le tampon
            //        créé / géré par ob_start()
            // rnvs : les variables extraites de $datas sont accessibles
            //        dans le fichier de chemin $file 
            // rnvs : lors du 1er appel de View::generateFile() dans 
            //        View::generate(), le paramètre $file est une string
            //        dont le contenu est le chemin vers le fichier d'action 
            //        de la vue effective. cela sert à produire le corps de
            //        la page web à retourner au client.
            //        c'est lors de l'inclusion de ce fichier que l'attribut
            //        $title de la View est setté.
            // rnvs : lors du 2e appel de View::generateFile() dans 
            //        View::generate(), le paramètre $file est une string
            //        dont le contenu est le chemin vers le fichier modèle
            //        générique (template.php) utilisé par toutes les pages 
            //        du site
            require $file;

            // Arrêt de la temporisation et renvoi du tampon de sortie
            // rnvs : https://www.php.net/manual/en/function.ob-get-clean.php
            // rnvs : Gets the current buffer contents and delete current 
            //        output buffer.
            // rnvs : le buffer créé / géré par ob_start() est retourné sous 
            //        la forme d'une string
            return ob_get_clean();
        }
        else {
            // rnvs : ici le fichier de l'action de la vue effective n'existe pas
            throw new Exception("Fichier '$file' introuvable");
            // rnvs : l'exception remonte jusque Router::routerRequest()
        }
    }

    /**
     * Nettoie une valeur insérée dans une page HTML
     * Doit être utilisée à chaque insertion de données dynamique dans une vue
     * Permet d'éviter les problèmes d'exécution de code indésirable (XSS) dans les vues générées
     * 
     * rnvs : cette méthode peut être (et est) appelée dans les fichiers
     *        inclus dans View::generateFile() lors de require $file
     * 
     * @param string $value Valeur à nettoyer
     * @return string Valeur nettoyée
     */
    private function clean($value)
    {
        // Convertit les caractères spéciaux en entités HTML
        // rnvs : https://www.php.net/manual/en/function.htmlspecialchars.php
        //        Convert special characters to HTML entities
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
    }

}
