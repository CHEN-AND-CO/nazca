<?php

class Cambrure {

    private $id;
    private $x;
    private $t;
    private $f;
    private $yintra;
    private $yextra;
    private $id_param;
    private $lgx;

    public function init($_id, $_x, $_t, $_f, $_yintra, $_yextra, $_id_param, $_lgx) {
        $this->id = $_id;
        $this->x = $_x;
        $this->t = $_t;
        $this->f = $_f;
        $this->yintra = $_yintra;
        $this->yextra = $_yextra;
        $this->id_param = $_id_param;
        $this->lgx = $_lgx;
    }

    public function setId($_id){
        $this->id = $_id;
    }
    
    public function setX($_x) {
        $this->x = $_x;
    }

    public function setT($_t) {
        $this->t = $_t;
    }

    public function setF($_f) {
        $this->f = $_f;
    }

    public function setYintra($_yintra) {
        $this->yintra = $_yintra;
    }

    public function setYextra($y_extra) {
        $this->yextra = $y_extra;
    }

    public function setId_param($_id_param) {
        $this->id_param = $_id_param;
    }

    public function setLgx($_lgx) {
        $this->lgx = $_lgx;
    }
    
    public function getId(){
        return $this->id;
    }

    public function getX() {
        return $this->x;
    }

    public function getT() {
        return $this->t;
    }

    public function getF() {
        return $this->f;
    }

    public function getYintra() {
        return $this->yintra;
    }

    public function getYextra() {
        return $this->yextra;
    }

    public function getId_param() {
        return $this->id_param;
    }

    public function getLgx() {
        return $this->lgx;
    }
}

?>