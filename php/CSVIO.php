<?php
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

        function csvToArray($raw){
            $out = array();

            foreach($raw as $line){
                array_push($out, explode(",", $line));
            }

            return $out;
        }

        function arrayToCsv($array){
            $out = array();

            foreach($array as $line){
                array_push($out, implode(",", $line));
            }

            return $out;
        }
    }
?>