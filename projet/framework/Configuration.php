<?php

/**
 * Classe de gestion des paramètres de configuration.
 * Inspirée du SimpleFramework de Frédéric Guillot
 * (https://github.com/fguillot/simpleFramework)
 *
 */
class Configuration {

    /** Tableau des paramètres de configuration */
    // rnvs : tableau associatif : clé == clé dans fichier ini, 
    //                             valeur == valeur dans fichier ini 
    private static $parameters;

    /**
     * Renvoie la valeur d'un paramètre de configuration
     * 
     * @param string $name Nom du paramètre
     * @param string $defaultValue Valeur à renvoyer par défaut
     * @return string Valeur du paramètre
     */
    public static function get($name, $defaultValue = null) {
        $parameters = self::getParameters();
        if (isset($parameters[$name])) {
            $value = $parameters[$name];
        } else {
            $value = $defaultValue;
        }
        return $value;
    }

    /**
     * Renvoie le tableau des paramètres en le chargeant au besoin depuis un fichier de configuration.
     * Les fichiers de configuration recherchés sont config/dev.ini et config/prod.ini (dans cet ordre)
     * 
     * @return array Tableau des paramètres
     * @throws Exception Si aucun fichier de configuration n'est trouvé
     */
    private static function getParameters() {
        if (self::$parameters == null) {
            $filePath = "config/dev.ini";
            // rnvs : https://www.php.net/manual/en/function.file-exists.php
            if (!file_exists($filePath)) {
                $filePath = "config/prod.ini";
            }
            if (!file_exists($filePath)) {
                throw new Exception("Aucun fichier de configuration trouvé");
            }
            // rnvs : https://www.php.net/manual/en/function.parse-ini-file
            //        parse_ini_file() retourne un tableau associatif
            self::$parameters = parse_ini_file($filePath);
        }
        return self::$parameters;
    }

}
