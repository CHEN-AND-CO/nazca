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
    
    public function setTmax_p($_tmax_p){
        $this->tmax_p = $_tmax_p;
    }
    
    public function setFmax_p($_fmax_p){
        $this->fmax_p = $_fmax_p;
    }
    
    public function setTmax($_tmax){
        $this->tmax = $_tmax;
    }
    
    public function setFmax($_fmax){
        $this->fmax = $_fmax;
    }
    
    public function setNb_points($_nb_points){
        $this->nb_points = $_nb_points;
    }
    
    public function setFic_img($_fic_img){
        $this->fic_img = $_fic_img;
    }
    
    public function setFic_csv($_fic_csv){
        $this->fic_csv = $_fic_csv;
    }
}