<?php

require_once('Cambrure.php');

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

    public function rigidite($_corde, $_tmax_p, $_fmax_p, $_nb_points) {
        $this->init(0, null, $_corde, $_tmax_p, $_fmax_p, ($_tmax_p / 100) * $_corde, ($_fmax_p / 100) * $_corde, $_nb_points, null, null, null);

        $cambrures = array();
        $one = new Cambrure;
        $one->genesis($this);
        array_push($cambrures, $one);

        /* Génération des autres cambrures */
        for ($i = 1; $i < $this->getNb_points() + 1; $i++) {
            $tmp = new Cambrure;
            $tmp->create($this, $cambrures[$i - 1]);

            array_push($cambrures, $tmp);
        }

        /* Préparation au calcul du centre de gravité */
        for ($i = 0; $i < $this->getNb_points() - 1; $i++) {
            $cambrures[$i]->initPg($this, $cambrures[$i + 1]); //Calcul des xg et yg pondérés
        }
        $cambrures[$this->getNb_points() - 1]->initPg($this, $cambrures[0]); //Pareil pour le dernier
        $this->initXg($cambrures); //Calcul de l'abscisse du point G
        $this->initYg($cambrures); //Calcul de l'ordonnée du point G

        /* Calcul des Igz */
        for ($i = 0; $i < $this->getNb_points() - 1; $i++) {
            $cambrures[$i]->initIgz($this, $cambrures[$i + 1]);
        }
        $cambrures[$this->getNb_points() - 1]->initIgz($this, $cambrures[0]);

        $igz = 0;
        foreach ($cambrures as $cambrure) {
            $igz += $cambrure->getIgz();
        }

        return $igz;
    }

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

    /**
     * Initialisation et calcul du centre de gravité
     * 
     * @param array $cambrures  Cambrures du profil
     */
    public function initG($cambrures) {
        for ($i = 0; $i < $this->getNb_points() - 1; $i++) {
            $cambrures[$i]->initPg($this, $cambrures[$i + 1]);
        }
        $cambrures[$this->getNb_points() - 1]->initPg($this, $cambrures[0]);
        $this->initXg($cambrures);
        $this->initYg($cambrures);
    }

    /**
     * Initialisation et calcul de l'abscisse du centre de gravité
     * 
     * @param array $cambrures  Cambrures du profil
     */
    public function initXg($cambrures) {
        $this->xg = 0;

        foreach ($cambrures as $cambrure) {
            $this->xg += $cambrure->getPxg();
        }
        $this->xg /= $this->getS($cambrures);
    }

    /**
     * Initialisation et calcul de l'ordonné du centre de gravité
     * 
     * @param array $cambrures  Cambrures du profil
     */
    public function initYg($cambrures) {
        $this->yg = 0;

        foreach ($cambrures as $cambrure) {
            $this->yg += $cambrure->getPyg();
        }
        $this->yg /= $this->getS($cambrures);
    }

    /**
     * Setter de l'identifiant du profil
     * 
     * @param int $_id  identifiant
     */
    public function setId($_id) {
        $this->id = $_id;
    }

    /**
     * Setter de la description du profil
     * 
     * @param string $_libelle  description
     */
    public function setLibelle($_libelle) {
        $this->libelle = $_libelle;
    }

    /**
     * Setter de la valeur de corde du profil
     * 
     * @param double $_corde
     */
    public function setCorde($_corde) {
        $this->corde = strval($_corde);
    }

    /**
     * Setter de la valeur de tmax en %
     * 
     * @param double $_tmax_p
     */
    public function setTmax_p($_tmax_p) {
        $this->tmax_p = strval($_tmax_p);
    }

    /**
     * Setter de la valeur de fmax en %
     * 
     * @param double $_fmax_p
     */
    public function setFmax_p($_fmax_p) {
        $this->fmax_p = strval($_fmax_p);
    }

    /**
     * Setter de la valeur de tmax en mm
     * 
     * @param double $_tmax
     */
    public function setTmax($_tmax) {
        $this->tmax = strval($_tmax);
    }

    /**
     * Setter de la valeur de fmax en mm
     * 
     * @param double $_fmax
     */
    public function setFmax($_fmax) {
        $this->fmax = strval($_fmax);
    }

    /**
     * Setter du nombre de points du profil
     * 
     * @param int $_nb_points
     */
    public function setNb_points($_nb_points) {
        $this->nb_points = $_nb_points;
    }

    /**
     * Setter de la date de création
     * 
     * @param string $_date
     */
    public function setDate($_date) {
        $this->date = $_date;
    }

    /**
     * Setter de l'emplacement du fichier image
     * 
     * @param string $_fic_img
     */
    public function setFic_img($_fic_img) {
        $this->fic_img = $_fic_img;
    }

    /**
     * Setter de l'emplacement du fichier csv
     * 
     * @param string $_fic_csv
     */
    public function setFic_csv($_fic_csv) {
        $this->fic_csv = $_fic_csv;
    }

    /**
     * Setter de l'abscisse du centre de gravité
     * 
     * @param double $_xg
     */
    public function setXg($_xg) {
        $this->xg = $_xg;
    }

    /**
     * Setter de l'ordonnée du centre de gravité
     * 
     * @param double $_yg
     */
    public function setYg($_yg) {
        $this->yg = $_yg;
    }

    /**
     * Getter de l'identifiant du profil
     * 
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Getter de la description du profil
     * 
     * @return string
     */
    public function getLibelle() {
        return $this->libelle;
    }

    /**
     * Getter de la valeur de la corde en mm
     * 
     * @return double
     */
    public function getCorde() {
        return doubleval($this->corde);
    }

    /**
     * Getter de la valeur de tmax en %
     * 
     * @return double
     */
    public function getTmax_p() {
        return doubleval($this->tmax_p);
    }

    /**
     * Getter de la valeur de fmax en %
     * 
     * @return double
     */
    public function getFmax_p() {
        return doubleval($this->fmax_p);
    }

    /**
     * Getter de la valeur de tmax en mm
     * 
     * @return double
     */
    public function getTmax() {
        return doubleval($this->tmax);
    }

    /**
     * Getter de la valeur de fmax en mm
     * 
     * @return double
     */
    public function getFmax() {
        return doubleval($this->fmax);
    }

    /**
     * Getter du nombre de points
     * 
     * @return int
     */
    public function getNb_points() {
        return $this->nb_points;
    }

    /**
     * Getter de la date de création
     * 
     * @return string
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Getter de l'emplacement du fichier image
     * 
     * @return string
     */
    public function getFic_img() {
        return $this->fic_img;
    }

    /**
     * Getter de l'emplacement du fichier csv
     * 
     * @return string
     */
    public function getFic_csv() {
        return $this->fic_csv;
    }

    /**
     * Getter du pas entre les différentes valeurs de x du profil
     * 
     * @return double
     */
    public function getDx() {
        return ($this->getCorde() / $this->getNb_points());
    }

    /**
     * Getter de l'abscisse du centre de gravité
     * 
     * @return double
     */
    public function getXg() {
        return $this->xg;
    }

    /**
     * Getter de l'ordonnée du centre de gravité
     * 
     * @return double
     */
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
