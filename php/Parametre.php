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
    private $xg,$yg;

    public function init($_id, $_libelle, $_corde, $_tmax_p, $_fmax_p, $_tmax, $_fmax, $_nb_points, $_fic_img, $_fic_csv) {
        $this->id = $_id;
        $this->libelle = $_libelle;
        $this->corde = $_corde;
        $this->tmax_p = $_tmax_p;
        $this->fmax_p = $_fmax_p;
        $this->tmax = $_tmax;
        $this->fmax = $_fmax;
        $this->nb_points = $_nb_points;
        $this->fic_img = $_fic_img;
        $this->fic_csv = $_fic_csv;
        $this->$xg = 0;
        $this->$yg = 0;
    }

    public function initXg($cambrures){
        $this->xg = 0;

        foreach($cambrures as $cambrure){
            $this->xg += $cambrure->getPxg();
        }
        $this->xg /= $this->getS($cambrures);
    }

    public function initYg($cambrures){
         $this->yg = 0;

        foreach($cambrures as $cambrure){
            $this->yg += $cambrure->getPyg();
        }
        $this->yg /= $this->getS($cambrures);
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

    public function getId(){
        return $this->id;
    }

    public function getLibelle(){
        return $this->libelle;
    }

    public function getCorde(){
        return $this->corde;
    }

    public function getTmax_p(){
        return $this->tmax_p;
    }

    public function getFmax_p(){
        return $this->fmax_p;
    }

    public function getTmax(){
        return $this->tmax;
    }

    public function getFmax(){
        return $this->fmax;
    }

    public function getNb_points(){
        return $this->nb_points;
    }

    public function getFic_img(){
        return $this->fic_img;
    }

    public function getFic_csv(){
        return $this->fic_csv;
    }

    public function getDx(){
        return ($this->corde/$this->nb_points);
    }

    public function getXg(){
        return $this->xg;
    }

    public function getYg(){
        return $this->yg;
    }

    public function getS($cambrures){
        $s = 0;
        for($i = 0; $i < $this->nb_points-1; $i++){
            $s += $cambrures[i].getDsi($this, $cambrures[i+1]);
        }

        return $s;
    }
}
