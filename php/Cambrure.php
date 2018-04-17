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
    private $pxg,$pyg;

    public function create($param, $prev){
        $this->id = $prev->getId()+1;

        $this->x = $prev->getX()+$param->getDx();

        $x_sur_c = $this->x/$this->getCorde();

        $this->t = -(
            1.015*pow($x_sur_c,4)
            -2.843*pow($x_sur_c,3)
            +3.516*pow($x_sur_c,2)
            +1.26*$x_sur_c
            -2.969*sqrt($x_sur_c)*$param->getTmax()
        );

        $this->f = -4*(pow($x_sur_c, 2)-($x_sur_c)*$param->getFmax());

        $this->yintra = $this->f - $this->t/2;
        $this->yextra = $this->f + $this->t/2;

        $this->id_param = $param->getId();

        $this->lgx = 0;
    }

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

    public function initLgx($param, $next){
        $tmoy = ($this->yextra+$next->getYextra())/2 - ($this->yintra+$next->getYintra())/2;
        $igzi = pow($param->getDx()*$tmoy, 3)/12;
        $ds = $param->getDx() * $tmoy;

        $this->lgx = $igiz+pow($this->f-$param->getYg(), 2)* $ds;
    }

    public function initPg($param, $next){
        $tmoy = ($this->yextra+$next->getYextra())/2 - ($this->yintra+$next->getYintra())/2;
        $ds = $param->getDx() * $tmoy;
        $xgi = $this->x + $param->getX()/2;

        $this->pxg = $xgi * $ds;
        $this->pyg = $this->f*$param->getDx() * $tmoy;
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

    public function setPxg($_pxg){
        $this->pxg = $_pxg;
    }

    public function setPyg($_pyg){
        $this->pyg = $_pyg;
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

    public function getPxg(){
        return $this->pxg;
    }

    public function getPyg(){
        return $this->pyg;
    }

    public function getDsi($param, $next){
        $tmoy = ($this->yextra+$next->getYextra())/2 - ($this->yintra+$next->getYintra())/2;
        return $param->getDx() * $tmoy;
    }
}

?>