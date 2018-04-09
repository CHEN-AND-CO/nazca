<?php

class Parametre {

    private $id;
    private $libelle;
    private $corde;
    private $tmax_p;
    private $fmax_p;
    private $tmax;
    private $fmax;
    private $nb_points;
    private $fic_img;
    private $fic_csv;

    public function init($_id) {
        $this->id = $_id;
    }
    
    public function setId($_id){
        $this->id = $_id;
    }
    
    public function setLibelle($_libelle){
        $this->libelle = $_libelle;
    }
    
    public function setCorde($_corde){
        $this->corde = $_corde;
    }

}
