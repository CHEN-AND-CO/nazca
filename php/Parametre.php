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
    private $date;
    private $fic_img;
    private $fic_csv;
    private $xg, $yg;

    /**
     * Initialisation du Paramètre/Profil
     * 
     * @param int $_id          identifiant du profil
     * @param string $_libelle  description du profil
     * @param double $_corde    valeur de corde en mm
     * @param double $_tmax_p   valeur de tmax en pourcentages
     * @param double $_fmax_p   valeur de fmax en pourcentages
     * @param double $_tmax     valeur de tmax en mm
     * @param double $_fmax     valeur de fmax en mm
     * @param int $_nb_points   nombre de points
     * @param string $_date     date de création
     * @param string $_fic_img  emplacement du fichier image
     * @param string $_fic_csv  emplacement du fichier csv
     */
    public function init($_id, $_libelle, $_corde, $_tmax_p, $_fmax_p, $_tmax, $_fmax, $_nb_points, $_date, $_fic_img, $_fic_csv) {
        $this->setId($_id);
        $this->setLibelle($_libelle);
        $this->setCorde($_corde);
        $this->setTmax_p($_tmax_p);
        $this->setFmax_p($_fmax_p);
        $this->setTmax($_tmax);
        $this->setFmax($_fmax);
        $this->setNb_points($_nb_points);
        $this->setDate($_date);
        $this->setFic_img($_fic_img);
        $this->setFic_csv($_fic_csv);
        $this->setXg(0);
        $this->setYg(0);
    }

    public function initG($cambrures) {
        for ($i = 0; $i < $this->getNb_points() - 1; $i++) {
            $cambrures[$i]->initPg($this, $cambrures[$i + 1]);
        }
        $cambrures[$this->getNb_points() - 1]->initPg($this, $cambrures[0]);
        $this->initXg($cambrures);
        $this->initYg($cambrures);
    }

    public function initXg($cambrures) {
        $this->xg = 0;

        foreach ($cambrures as $cambrure) {
            $this->xg += $cambrure->getPxg();
        }
        $this->xg /= $this->getS($cambrures);
    }

    public function initYg($cambrures) {
        $this->yg = 0;

        foreach ($cambrures as $cambrure) {
            $this->yg += $cambrure->getPyg();
        }
        $this->yg /= $this->getS($cambrures);
    }

    public function setId($_id) {
        $this->id = $_id;
    }

    public function setLibelle($_libelle) {
        $this->libelle = $_libelle;
    }

    public function setCorde($_corde) {
        $this->corde = strval($_corde);
    }

    public function setTmax_p($_tmax_p) {
        $this->tmax_p = strval($_tmax_p);
    }

    public function setFmax_p($_fmax_p) {
        $this->fmax_p = strval($_fmax_p);
    }

    public function setTmax($_tmax) {
        $this->tmax = strval($_tmax);
    }

    public function setFmax($_fmax) {
        $this->fmax = strval($_fmax);
    }

    public function setNb_points($_nb_points) {
        $this->nb_points = $_nb_points;
    }

    public function setDate($_date) {
        $this->date = $_date;
    }

    public function setFic_img($_fic_img) {
        $this->fic_img = $_fic_img;
    }

    public function setFic_csv($_fic_csv) {
        $this->fic_csv = $_fic_csv;
    }

    public function setXg($_xg) {
        $this->xg = $_xg;
    }

    public function setYg($_yg) {
        $this->yg = $_yg;
    }

    public function getId() {
        return $this->id;
    }

    public function getLibelle() {
        return $this->libelle;
    }

    public function getCorde() {
        return doubleval($this->corde);
    }

    public function getTmax_p() {
        return doubleval($this->tmax_p);
    }

    public function getFmax_p() {
        return doubleval($this->fmax_p);
    }

    public function getTmax() {
        return doubleval($this->tmax);
    }

    public function getFmax() {
        return doubleval($this->fmax);
    }

    public function getNb_points() {
        return $this->nb_points;
    }

    public function getDate() {
        return $this->date;
    }

    public function getFic_img() {
        return $this->fic_img;
    }

    public function getFic_csv() {
        return $this->fic_csv;
    }

    public function getDx() {
        return ($this->getCorde() / $this->getNb_points());
    }

    public function getXg() {
        return $this->xg;
    }

    public function getYg() {
        return $this->yg;
    }

    /**
     * Calcul de la surface du profil
     * 
     * @param array $cambrures
     * @return double
     */
    public function getS($cambrures) {
        $s = 0;
        for ($i = 0; $i < $this->getNb_points() - 1; $i++) {
            $s += $cambrures[$i]->getDsi($this, $cambrures[$i + 1]);
        }
        $s += $cambrures[$this->getNb_points() - 1]->getDsi($this, $cambrures[0]);

        return $s;
    }

}
