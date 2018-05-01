<?php

/**
 * @Author: Le Torc'h Kévin
 * @Company: Chen & Co
 * @Email: kev29lt@gmail.com
 */
require_once('Cambrure.php');

class CSVIO {

    /**
     * Récupération d'un fichier CSV
     * 
     * @param string $path
     * 
     * @return array
     */
    function getCSVFile($path) {
        $out = array();
        $file = fopen($path, 'r');

        while (($line = fgets($file))) {
            array_push($out, $line);
        }

        fclose($file);

        return $out;
    }

    /**
     * Ecriture d'un fichier CSV
     * 
     * @param string $path
     * @param array $content
     * 
     * @return boolean
     */
    function writeToCSVFile($path, $content) {
        $file = fopen($path, 'w');

        if (isset($file)) {
            foreach ($content as $line) {
                fwrite($file, $line . PHP_EOL);
            }

            return fclose($file);
        }

        return false;
    }

    /**
     * Ajout à un fichier CSV
     * 
     * @param string $path
     * @param array $content
     * 
     * @return boolean
     */
    function addToCSVFile($path, $content) {
        $file = fopen($path, 'a');

        if (isset($file)) {
            foreach ($content as $line) {
                fwrite($file, $line, strlen($line));
            }

            return fclose($file);
        }

        return false;
    }

    /**
     * Conversion d'un tableau format CSV en tableau de tableau de valeurs
     * 
     * @param array $_raw
     * 
     * @return array
     */
    function csvToArray($_raw) {
        $out = array();

        foreach ($_raw as $line) {
            array_push($out, explode(",", $line));
        }

        return $out;
    }

    /**
     * Conversion d'un tableau de tableau de valeurs en tableau format CSV
     * 
     * @param array $_array
     * 
     * @return array
     */
    function arrayToCsv($_array) {
        $out = array();

        foreach ($_array as $line) {
            array_push($out, implode(",", $line));
        }

        return $out;
    }

    /**
     * Conversion d'un tableau de tableau de valeurs en tableau de cambrures
     * 
     * @param array $_array
     * 
     * @return array
     */
    function arrayToCambrureArray($_array) {
        $out = array();
        $id = 0;

        foreach ($_array as $element) {
            array_unshift($element, $id);
            $tmp = new Cambrure;

            $tmp->load($element);
            array_push($out, $tmp);
            $id++;
        }

        return $out;
    }

    /**
     * Conversion d'un tableau de cambrures en tableau de tableau de valeurs
     * 
     * @param array $cambrures
     * 
     * @return array
     */
    function cambrureArrayToArray($cambrures) {
        $out = array();

        foreach ($cambrures as $element) {
            $tmp = array();

            array_push($tmp, $element->getX());
            array_push($tmp, $element->getT());
            array_push($tmp, $element->getF());
            array_push($tmp, $element->getYintra());
            array_push($tmp, $element->getYextra());
            array_push($tmp, $element->getId_param());
            array_push($tmp, $element->getIgz());

            array_push($out, $tmp);
        }

        return $out;
    }

    /**
     * Conversion d'un tableau format CSV en tableau de cambrures
     * 
     * @param array $_raw
     * 
     * @return array
     */
    function csvToCambrureArray($_raw) {
        return self::arrayToCambrureArray(self::csvToArray($_raw));
    }

    /**
     * Conversion d'un tableau de cambrures en tableau format CSV
     * 
     * @param array $cambrures
     * 
     * @return array
     */
    function cambrureArrayToCsv($cambrures) {
        return self::arrayToCsv(self::cambrureArrayToArray($cambrures));
    }

    /**
     * Récupération d'un tableau de cambrures stocké dans un fichier CSV
     * 
     * @param string $_path
     * 
     * @return array
     */
    function getCSVFileAsCambrureArray($_path) {
        return self::csvToCambrureArray(self::getCSVFile($_path));
    }

    /**
     * Ecriture du tableau de cambrures dans un fichier CSV
     * 
     * @param string $path
     * @param array $content
     */
    function writeCambrureArrayToCSVFile($path, $content) {
        self::writeToCSVFile($path, self::cambrureArrayToCsv($content));
    }

}

?>