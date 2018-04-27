<?php
/**
 * @Author: Le Torc'h Kévin
 * @Company: Chen & Co
 * @Email: kev29lt@gmail.com
 */

    require_once('Cambrure.php');

    class CSVIO {
        function getCSVFile($path){
            $out = array();
            $file = fopen($path, 'r');

            while(($line = fgets($file))){
                array_push($out, $line);
            }

            fclose($file);
        
            return $out;
        }

        function csvToArray($_raw){
            $out = array();

            foreach($_raw as $line){
                array_push($out, explode(",", $line));
            }

            return $out;
        }

        function arrayToCsv($_array){
            $out = array();

            foreach($_array as $line){
                array_push($out, implode(",", $line));
            }

            return $out;
        }

        function arrayToCambrureArray($_array){
            $out = array();
            $id = 0;

            foreach($_array as $element){
                array_unshift($element, $id);
                $tmp = new Cambrure;

                $tmp->load($element);
                array_push($out, $tmp);
                $id++;
            }

            return $out;
        }

        function csvToCambrureArray($_raw){
            return self::arrayToCambrureArray(self::csvToArray($_raw));
        }

        function getCSVFileAsCambrureArray($_path){
            return self::csvToCambrureArray(self::getCSVFile($_path));
        }
    }
?>