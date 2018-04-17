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
    }
?>