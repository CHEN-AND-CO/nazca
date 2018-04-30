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
    private $pxg, $pyg;

    /**
     * Crée une cambrure en calculant les valeurs
     * 
     * @param parametre $param  parametre de la cambrure
     * @param cambrure $prev    cambrure precedente dans le paramètre
     */
    public function create($param, $prev) {
        $this->setId($prev->getId() + 1);

        $this->setX($prev->getX() + $param->getDx());

        $x_sur_c = $this->getX() / $param->getCorde();

        $this->setT(
                -( 1.015 * pow($x_sur_c, 4) - 2.843 * pow($x_sur_c, 3) + 3.516 * pow($x_sur_c, 2) + 1.26 * $x_sur_c - 2.969 * sqrt($x_sur_c) ) * $param->getTmax()
        );

        $this->setF(-4 * (pow($x_sur_c, 2) - ($x_sur_c)) * $param->getFmax());

        $this->setYintra($this->getF() - $this->getT() / 2);
        $this->setYextra($this->getF() + $this->getT() / 2);

        $this->setId_param($param->getId());

        $this->setIgz(0);
    }

    public function genesis($param) {
        $this->setId(0);
        $this->setX(0);

        $x_sur_c = $this->getX() / $param->getCorde();

        $this->setT(
                -( 1.015 * pow($x_sur_c, 4) - 2.843 * pow($x_sur_c, 3) + 3.516 * pow($x_sur_c, 2) + 1.26 * $x_sur_c - 2.969 * sqrt($x_sur_c) ) * $param->getTmax()
        );

        $this->setF(-4 * (pow($x_sur_c, 2) - ($x_sur_c)) * $param->getFmax());

        $this->setYintra($this->getF() - $this->getT() / 2);
        $this->setYextra($this->getF() + $this->getT() / 2);

        $this->setId_param($param->getId());

        $this->setIgz(0);
    }

    public function init($_id, $_x, $_t, $_f, $_yintra, $_yextra, $_id_param, $_Igz) {
        $this->setId($_id);
        $this->setX($_x);
        $this->setT($_t);
        $this->setF($_f);
        $this->setYintra($_yintra);
        $this->setYextra($_yextra);
        $this->setId_param($_id_param);
        $this->setIgz($_Igz);
    }

    public function load($_array) {
        $this->setId($_array[0]);
        $this->setX($_array[1]);
        $this->setT($_array[2]);
        $this->setF($_array[3]);
        $this->setYintra($_array[4]);
        $this->setYextra($_array[5]);
        $this->setId_param($_array[6]);
        $this->setIgz($_array[7]);
    }

    public function initIgz($param, $next) {
        $this->setIgz(
                $this->getIgiz($param, $next) +
                pow($this->getF() - $param->getYg(), 2) *
                $this->getDsi($param, $next)
        );
    }

    public function initPg($param, $next) {
        $this->setPxg($this->getXgi($param) * $this->getDsi($param, $next));
        $this->setPyg($this->getF() * $this->getDsi($param, $next));
    }

    public function clear() {
        $this->init(0, 0, 0, 0, 0, 0, 0, 0);
        $this->setPxg(0);
        $this->setPyg(0);
    }

    public function setId($_id) {
        $this->id = $_id;
    }

    public function setX($_x) {
        $this->x = strval($_x);
    }

    public function setT($_t) {
        $this->t = strval($_t);
    }

    public function setF($_f) {
        $this->f = strval($_f);
    }

    public function setYintra($_yintra) {
        $this->yintra = strval($_yintra);
    }

    public function setYextra($y_extra) {
        $this->yextra = strval($y_extra);
    }

    public function setId_param($_id_param) {
        $this->id_param = $_id_param;
    }

    public function setIgz($_Igz) {
        $this->lgx = strval($_Igz);
    }

    public function setPxg($_pxg) {
        $this->pxg = $_pxg;
    }

    public function setPyg($_pyg) {
        $this->pyg = $_pyg;
    }

    public function getId() {
        return $this->id;
    }

    public function getX() {
        return doubleval($this->x);
    }

    public function getT() {
        return doubleval($this->t);
    }

    public function getF() {
        return doubleval($this->f);
    }

    public function getYintra() {
        return doubleval($this->yintra);
    }

    public function getYextra() {
        return doubleval($this->yextra);
    }

    public function getId_param() {
        return $this->id_param;
    }

    public function getXgi($param) {
        return $this->getX() + ($param->getDx() / 2);
    }

    public function getIgz() {
        return doubleval($this->lgx);
    }

    public function getIgiz($param, $next) {
        return pow($param->getDx() * $this->getTmoy($next), 3) / 12;
    }

    public function getPxg() {
        return $this->pxg;
    }

    public function getPyg() {
        return $this->pyg;
    }

    public function getTmoy($next) {
        return ($this->getYextra() + $next->getYextra() - $this->getYintra() - $next->getYintra()) / 2;
    }

    public function getDsi($param, $next) {
        return $param->getDx() * $this->getTmoy($next);
    }

}

?>