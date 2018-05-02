<?php

/**
 * @Author: Kévin Le Torc'h
 * @Company: CHEN AND CO
 * @Email: kev29lt@gmail.com
 */

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

    /**
     * Génère la première cambrure du paramètre
     * 
     * @param parametre $param  parametre de la cambrure
     */
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

    /**
     * Initialise la cambrure
     * 
     * @param int $_id          Identifiant de la cambrure
     * @param double $_x        valeur de x de la cambrure
     * @param double $_t        valeur de t de la cambrure
     * @param double $_f        valeur de f de la cambrue
     * @param double $_yintra   valeur de Yintrados
     * @param double $_yextra   valeur de Yextrados
     * @param int $_id_param    Identifiant du paramètre auquel appartient la cambrure
     * @param double $_Igz      valeur de Igz
     */
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

    /**
     * Charge les valeurs de la cambrure depuis un tableau
     * 
     * @param array $array
     */
    public function load($array) {
        $this->setId($array[0]);
        $this->setX($array[1]);
        $this->setT($array[2]);
        $this->setF($array[3]);
        $this->setYintra($array[4]);
        $this->setYextra($array[5]);
        $this->setId_param($array[6]);
        $this->setIgz($array[7]);
    }

    /**
     * Initialise la valeur de Igz
     * 
     * @param parametre $param      Parametre du profil
     * @param cambrure $next        Cambrure suivante dans le profil
     */
    public function initIgz($param, $next) {
        $this->setIgz(
                $this->getIgiz($param, $next) +
                pow($this->getF() - $param->getYg(), 2) *
                $this->getDsi($param, $next)
        );
    }

    /**
     * Initialise les valeurs de yg local et xg local
     * 
     * @param parametre $param      Parametre du profil
     * @param cambrure $next        Cambrure suivante dans le profil
     */
    public function initPg($param, $next) {
        $this->setPxg($this->getXgi($param) * $this->getDsi($param, $next));
        $this->setPyg($this->getF() * $this->getDsi($param, $next));
    }

    /**
     * Met tous les parametres de la cambrure à 0
     */
    public function clear() {
        $this->init(0, 0, 0, 0, 0, 0, 0, 0);
        $this->setPxg(0);
        $this->setPyg(0);
    }

    /**
     * Setter de l'id de la cambrure
     * 
     * @param int $_id      Identifiant
     */
    public function setId($_id) {
        $this->id = $_id;
    }

    /**
     * Setter de x
     * 
     * @param double $_x
     */
    public function setX($_x) {
        $this->x = strval($_x);
    }

    /**
     * Setter de t
     * 
     * @param double $_t
     */
    public function setT($_t) {
        $this->t = strval($_t);
    }

    /**
     * Setter de f
     * 
     * @param double $_f
     */
    public function setF($_f) {
        $this->f = strval($_f);
    }

    /**
     * Setter de Yintrados
     * 
     * @param double $_yintra
     */
    public function setYintra($_yintra) {
        $this->yintra = strval($_yintra);
    }

    /**
     * Setter de Yextrados
     * 
     * @param double $y_extra
     */
    public function setYextra($y_extra) {
        $this->yextra = strval($y_extra);
    }

    /**
     * Setter de l'identifiant du paramètre auquel la cambrure appartient
     * 
     * @param int $_id_param
     */
    public function setId_param($_id_param) {
        $this->id_param = $_id_param;
    }

    /**
     * Setter de Igz / lgx
     * 
     * @param double $_Igz
     */
    public function setIgz($_Igz) {
        $this->lgx = strval($_Igz);
    }

    /**
     * Setter de xg pondéré local
     * 
     * @param double $_pxg
     */
    public function setPxg($_pxg) {
        $this->pxg = $_pxg;
    }

    /**
     * Setter de xg local
     * 
     * @param double $_pyg
     */
    public function setPyg($_pyg) {
        $this->pyg = $_pyg;
    }

    /**
     * Getter de l'id de la cambrure
     * 
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Getter de x
     * 
     * @return double
     */
    public function getX() {
        return doubleval($this->x);
    }

    /**
     * Getter de t
     * 
     * @return double
     */
    public function getT() {
        return doubleval($this->t);
    }

    /**
     * Getter de f
     * 
     * @return double
     */
    public function getF() {
        return doubleval($this->f);
    }

    /**
     * Getter de yintrados
     * 
     * @return double
     */
    public function getYintra() {
        return doubleval($this->yintra);
    }

    /**
     * Getter de yextrados
     * 
     * @return double
     */
    public function getYextra() {
        return doubleval($this->yextra);
    }

    /**
     * Getter de l'identifiant du paramètre auquel appartient la cambrure
     * 
     * @return int
     */
    public function getId_param() {
        return $this->id_param;
    }

    /**
     * Getter de xg local
     * 
     * @param parametre $param
     * @return double
     */
    public function getXgi($param) {
        return $this->getX() + ($param->getDx() / 2);
    }

    /**
     * Getter de lgx ( valeur de igz )
     * 
     * @return double
     */
    public function getIgz() {
        return doubleval($this->lgx);
    }

    /**
     * Getter de igzi ( igz local )
     * 
     * @param Parametre $param      Parametre de la cambrure
     * @param type $next            Cambrure suivante dans le profil
     * 
     * @return double
     */
    public function getIgiz($param, $next) {
        return pow($param->getDx() * $this->getTmoy($next), 3) / 12;
    }

    /**
     * Getter de xg pondéré
     * 
     * @return double
     */
    public function getPxg() {
        return $this->pxg;
    }

    /**
     * Getter de yg pondéré
     * 
     * @return double
     */
    public function getPyg() {
        return $this->pyg;
    }

    /**
     * Calcul de Tmoy
     * 
     * @param cambrure $next    Cambrure suivant dans le profil
     * 
     * @return double
     */
    public function getTmoy($next) {
        return ($this->getYextra() + $next->getYextra() - $this->getYintra() - $next->getYintra()) / 2;
    }

    /**
     * Calcul de la surface locale
     * 
     * @param parametre $param      profil/parametre auquel appartient la cambrure
     * @param cambrure $next        Cambrure suivante dans le profil
     * 
     * @return double
     */
    public function getDsi($param, $next) {
        return $param->getDx() * $this->getTmoy($next);
    }

}

?>