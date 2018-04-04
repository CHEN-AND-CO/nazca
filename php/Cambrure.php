<?php

class Cambrure  
{
    function __construct($C, $Tmax, $Fmax, $nbPoints)
    {
        $this->C = $C;                      //Corde
        $this->Fmax = $Fmax;                //Fmax
        $this->Tmax = $Tmax;                //Tmax
        $this->nbPoints = $nbPoints;        //Nombre de points à calculer

        
    }

}

?>