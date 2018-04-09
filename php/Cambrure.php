<?php

class Cambrure {

    private $x;
    private $t;
    private $f;
    private $yintra;
    private $yextra;
    private $id_param;
    private $lgx;

    function init($_x, $_t, $_f, $_yintra, $_yextra, $_id_param, $_lgx) {
        $this->x = $_x;
        $this->t = $_t;
        $this->f = $_f;
        $this->yintra = $_yintra;
        $this->yextra = $_yextra;
        $this->id_param = $_id_param;
        $this->lgx = $_lgx;
    }

    function setX($_x) {
        $this->x = $_x;
    }

    function setT($_t) {
        $this->t = $_t;
    }

    function setF($_f) {
        $this->f = $_f;
    }

    function setYintra($_yintra) {
        $this->yintra = $_yintra;
    }

    function setYextra($y_extra) {
        $this->yextra = $y_extra;
    }

    function setId_param($_id_param) {
        $this->id_param = $_id_param;
    }

    function setLgx($_lgx) {
        $this->lgx = $_lgx;
    }

    function getX() {
        return $this->x;
    }

    function getT() {
        return $this->t;
    }

    function getF() {
        return $this->f;
    }

    function getYintra() {
        return $this->yintra;
    }

    function getYextra() {
        return $this->yextra;
    }

    function getId_param() {
        return $this->id_param;
    }

    function getLgx() {
        return $this->lgx;
    }
}

?>