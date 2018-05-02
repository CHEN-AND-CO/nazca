<?php

/**
 * @Author: Le Torc'h Kévin
 * @Company: Chen & Co
 * @Email: kev29lt@gmail.com
 */
require_once('constantes.php');
require_once('Cambrure.php');
require_once('Parametre.php');

class BDDIO {

    private $bdd;

    /**
     * Constructeur de l'interface de gestion de la bdd
     */
    public function BDDIO() {
        $this->Connect();
    }

    /**
     * Retourne l'objet PDO mysql stocké dans la classe
     *
     * @return PDO
     */
    public function getBdd() {
        return $this->bdd;
    }

    /**
     * Stocke un objet PDO dans la classe
     * 
     * @param PDO $_bdd
     */
    public function setBdd($_bdd) {
        $this->bdd = $_bdd;
    }

    /**
     * Connecte l'objet PDO à la base de donnée en utilisant les constantes
     *  
     * @return boolean
     * @throws Exception si erreur de connexion à la BDD
     */
    public function Connect() {
        try {
            $this->setBdd(new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASSWORD));
        } catch (PDOException $exception) {
            error_log('Connection error: ' . $exception->getMessage());
            return false;
        }

        return $this->getBdd();
    }

    /**
     * Ajoute un objet paramètre à la base de données
     * 
     * @param Parametre $param  paramètre à ajouter
     * 
     * @return boolean
     * @throws Exception si erreur de connexion à la BDD
     */
    public function AddParamObject($param) {
        return $this->AddParam($param->getLibelle(), $param->getCorde(), $param->getTmax_p(), $param->getFmax_p(), $param->getTmax(), $param->getFmax(), $param->getNb_points(), $param->getDate(), $param->getFic_img(), $param->getFic_img_bis(), $param->getFic_csv());
    }

    /**
     * Ajoute un paramètre à la base de données
     * 
     * @param string $libelle       nom du paramètre
     * @param double $corde         valeur de la corde
     * @param double $tmax_p        valeur de tmax en pourcentages
     * @param double $fmax_p        valeur de fmax en pourcentages
     * @param double $tmax          valeur de tmax
     * @param double $fmax          valeur de fmax
     * @param int $nb_points        nombre de points
     * @param string $date          date de création du paramètre
     * @param string $fic_img       emplacement fichier image
     * @param string $fic_img_bis   emplacement fichier image supplémentaire
     * @param string $fic_csv       emplacement fichier csv
     * 
     * @return boolean
     * @throws Exception si erreur de connexion à la BDD
     */
    public function AddParam($libelle, $corde, $tmax_p, $fmax_p, $tmax, $fmax, $nb_points, $date, $fic_img, $fic_img_bis, $fic_csv) {
        try {
            $request = 'insert into parametre(libelle, corde, tmax_p, fmax_p, tmax, fmax, nb_points, date, fic_img,fic_img_bis, fic_csv)
            values(:libelle, :corde, :tmax_p, :fmax_p, :tmax, :fmax, :nb_points, :date, :fic_img, :fic_img_bis, :fic_csv)';

            $statement = $this->getBdd()->prepare($request);
            $statement->bindParam(':libelle', $libelle, PDO::PARAM_STR, 40);
            $statement->bindParam(':corde', strval($corde), PDO::PARAM_STR, 128);
            $statement->bindParam(':tmax_p', strval($tmax_p), PDO::PARAM_STR, 128);
            $statement->bindParam(':fmax_p', strval($fmax_p), PDO::PARAM_STR, 128);
            $statement->bindParam(':tmax', strval($tmax), PDO::PARAM_STR, 128);
            $statement->bindParam(':fmax', strval($fmax), PDO::PARAM_STR, 128);
            $statement->bindParam(':nb_points', $nb_points, PDO::PARAM_INT);
            $statement->bindParam(':date', $date, PDO::PARAM_STR);
            $statement->bindParam(':fic_img', $fic_img, PDO::PARAM_STR, 256);
            $statement->bindParam(':fic_img_bis', $fic_img_bis, PDO::PARAM_STR, 256);
            $statement->bindParam(':fic_csv', $fic_csv, PDO::PARAM_STR, 256);
            $result = $statement->execute();
        } catch (PDOException $exception) {
            error_log('Connection error: ' . $exception->getMessage());
            return false;
        }

        return $result;
    }

    /**
     * Demande un paramètre spécifique à la BDD
     * 
     * @param int $id   identifiant du paramètre
     * 
     * @return array|boolean $result
     * @throws Exception si erreur de requète à la BDD
     */
    public function RequestParam($id) {
        try {
            $request = 'select * from parametre where id=:id';
            $statement = $this->getBdd()->prepare($request);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_CLASS, 'Parametre');
        } catch (PDOException $exception) {
            error_log('Request error: ' . $exception->getMessage());
            return false;
        }
        return $result;
    }

    /**
     * Demande tous les parametres à la BDD
     * 
     * @return array|boolean $result
     * @throws Exception si erreur de requète à la BDD
     */
    public function RequestAllParams() {
        try {
            $request = 'select * from parametre';
            $statement = $this->getBdd()->prepare($request);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_CLASS, 'Parametre');
        } catch (PDOException $exception) {
            error_log('Request error: ' . $exception->getMessage());
            return false;
        }
        return $result;
    }

    /**
     * Enlève un profil spécifique et ces cambrures associées de la BDD
     * 
     * @param int $_id  identifiant du profil
     * 
     * @return boolean
     */
    public function deleteParam($_id) {
        if (!$this->removeParamFiles($_id)) {
            //Erreur impossible de supprimer les fichiers
        }

        if ($this->RemoveCambruresFromParam($_id) && $this->RemoveParam($_id)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Supprimme les fichiers lié au profil
     * 
     * @param int $id
     * 
     * @return boolean
     */
    public function removeParamFiles($id) {
        $param = $this->RequestParam($id);

        unlink($param->getFic_csv());
        unlink($param->getFic_img());
        unlink($param->getFic_img_bis());

        return true;
    }

    /**
     * Enlève un paramètre spécifique de la BDD
     * 
     * @param int $_id  identifiant du paramètre
     * 
     * @return boolean
     * @throws Exception si erreur de requète à la BDD
     */
    public function RemoveParam($_id) {
        try {
            $request = 'delete from parametre where id=:id';
            $statement = $this->getBdd()->prepare($request);
            $statement->bindParam(':id', $_id, PDO::PARAM_INT);
            $result = $statement->execute();
        } catch (PDOException $exception) {
            error_log('Request error: ' . $exception->getMessage());
            return false;
        }
        return $result;
    }

    /**
     * Enlève toutes les cambrures d'un paramètre spécifié de la BDD
     * 
     * @param int $_id  identifiant du paramètre
     * 
     * @return boolean
     * @throws Exception si erreur de requète à la BDD
     */
    public function RemoveCambruresFromParam($_id) {
        try {
            $request = 'delete from cambrure where id_param=:id';
            $statement = $this->getBdd()->prepare($request);
            $statement->bindParam(':id', $_id, PDO::PARAM_INT);
            $result = $statement->execute();
        } catch (PDOException $exception) {
            error_log('Request error: ' . $exception->getMessage());
            return false;
        }
        return $result;
    }

    /**
     * Modifie les valeurs d'un paramètre spécifique de la BDD
     * 
     * @param int $id               identifiant du paramètre
     * @param string $libelle       description du paramètre
     * @param double $corde         valeur de la corde
     * @param double $tmax_p        valeur de tmax en poucentages
     * @param double $fmax_p        valeur de fmax en pourcentages
     * @param double $tmax          valeur de tmax
     * @param double $fmax          valeur de fmax
     * @param int $nb_points        nombre de points
     * @param string $date          date de création
     * @param string $fic_img       emplacement du fichier image
     * @param string $fic_img_bis   emplacement du fichier image supplémentaire
     * @param string $fic_csv       emplacement du fichier csv
     * 
     * @return boolean
     * @throws Exception si erreur de connexion à la BDD
     */
    public function UpdateParam($id, $libelle, $corde, $tmax_p, $fmax_p, $tmax, $fmax, $nb_points, $date, $fic_img, $fic_img_bis, $fic_csv) {
        try {
            $request = 'update parametre set libelle=:libelle, corde=:corde, tmax_p=:tmax_p, fmax_p=:fmax_p, tmax=:tmax, fmax=:fmax, nb_points=:nb_points, date=:date, fic_img=:fic_img, fic_img_bis=:fic_img_bis, fic_csv=:fic_csv where id=:id';

            $statement = $this->getBdd()->prepare($request);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->bindParam(':libelle', $libelle, PDO::PARAM_STR, 40);
            $statement->bindParam(':corde', strval($corde), PDO::PARAM_STR, 128);
            $statement->bindParam(':tmax_p', strval($tmax_p), PDO::PARAM_STR, 128);
            $statement->bindParam(':fmax_p', strval($fmax_p), PDO::PARAM_STR, 128);
            $statement->bindParam(':tmax', strval($tmax), PDO::PARAM_STR, 128);
            $statement->bindParam(':fmax', strval($fmax), PDO::PARAM_STR, 128);
            $statement->bindParam(':nb_points', $nb_points, PDO::PARAM_INT);
            $statement->bindParam(':date', $date, PDO::PARAM_STR);
            $statement->bindParam(':fic_img', $fic_img, PDO::PARAM_STR, 256);
            $statement->bindParam(':fic_img_bis', $fic_img_bis, PDO::PARAM_STR, 256);
            $statement->bindParam(':fic_csv', $fic_csv, PDO::PARAM_STR, 256);

            $result = $statement->execute();
        } catch (PDOException $exception) {
            error_log('Connection error: ' . $exception->getMessage());
            return false;
        }

        return $result;
    }

    /**
     * Modifie un paramètre spécifique de la BDD
     * 
     * @param int $id
     * @param Parametre $param
     * @return boolean
     */
    public function UpdateParamObject($id, $param) {
        return $this->UpdateParam($id, $param->getLibelle(), $param->getCorde(), $param->getTmax_p(), $param->getFmax_p(), $param->getTmax(), $param->getFmax(), $param->getNb_points(), $param->getDate(), $param->getFic_img(), $param->getFic_img_bis(), $param->getFic_csv());
    }

    /**
     * Ajoute une cambrure à la BDD
     * 
     * @param double $x
     * @param double $t
     * @param double $f
     * @param double $yintra
     * @param double $yextra
     * @param int $id_param
     * @param double $lgx
     * 
     * @return boolean
     * @throws Exception si erreur de connexion à la BDD
     */
    public function AddCambrure($x, $t, $f, $yintra, $yextra, $id_param, $lgx) {
        try {
            $request = 'insert into cambrure(x, t, f, yintra, yextra, id_param, lgx)
            values(:x, :t, :f, :yintra, :yextra, :id_param, :lgx)';

            $statement = $this->getBdd()->prepare($request);
            $statement->bindParam(':x', strval($x), PDO::PARAM_STR, 128);
            $statement->bindParam(':t', strval($t), PDO::PARAM_STR, 128);
            $statement->bindParam(':f', strval($f), PDO::PARAM_STR, 128);
            $statement->bindParam(':yintra', strval($yintra), PDO::PARAM_STR, 128);
            $statement->bindParam(':yextra', strval($yextra), PDO::PARAM_STR, 128);
            $statement->bindParam(':id_param', $id_param, PDO::PARAM_INT);
            $statement->bindParam(':lgx', strval($lgx), PDO::PARAM_STR, 128);

            $result = $statement->execute();
        } catch (PDOException $exception) {
            error_log('Connection error: ' . $exception->getMessage());
            return false;
        }

        return $result;
    }

    /**
     * Ajoute un objet cambrure à la BDD
     * 
     * @param Cambrure $cambrure
     * 
     * @return boolean
     */
    public function AddCambrureObject($cambrure) {
        return $this->AddCambrure($cambrure->getX(), $cambrure->getT(), $cambrure->getF(), $cambrure->getYintra(), $cambrure->getYextra(), $cambrure->getId_param(), $cambrure->getIgz());
    }

    /**
     * Demande toutes les cambrures d'un paramètre de la BDD
     * 
     * @param int $id_param
     * 
     * @return boolean|array $result
     * @throws Exception si erreur de requète
     */
    public function RequestAllCambruresFromParam($id_param) {
        try {
            $request = 'select * from cambrure where id_param=:id_param';
            $statement = $this->getBdd()->prepare($request);
            $statement->bindParam(':id_param', $id_param, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_CLASS, 'Cambrure');
        } catch (PDOException $exception) {
            error_log('Request error: ' . $exception->getMessage());
            return false;
        }
        return $result;
    }

    /**
     * Demande une cambrure spécifique à la BDD
     * 
     * @param int $id
     * 
     * @return boolean
     * @throws Exception si erreur de requète à la BDD
     */
    public function RequestCambrure($id) {
        try {
            $request = 'select * from cambrure where id=:id';
            $statement = $this->getBdd()->prepare($request);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_CLASS, 'Cambrure');
        } catch (PDOException $exception) {
            error_log('Request error: ' . $exception->getMessage());
            return false;
        }
        return $result;
    }

    /**
     * Modifie les valeurs d'une cambrure de la BDD
     * 
     * @param int $id
     * @param double $x
     * @param double $t
     * @param double $f
     * @param double $yintra
     * @param double $yextra
     * @param int $id_param
     * @param double $lgx
     * 
     * @return boolean
     * @throws Exception si erreur de connexion à la BDD
     */
    public function UpdateCambrure($id, $x, $t, $f, $yintra, $yextra, $id_param, $lgx) {
        try {
            $request = 'update cambrure set x=:x, t=:t, f=:f, yintra=:yintra, yextra=:yextra, id_param=:id_param, lgx=:lgx where id=:id';

            $statement = $this->getBdd()->prepare($request);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->bindParam(':x', strval($x), PDO::PARAM_STR, 128);
            $statement->bindParam(':t', strval($t), PDO::PARAM_STR, 128);
            $statement->bindParam(':f', strval($f), PDO::PARAM_STR, 128);
            $statement->bindParam(':yintra', strval($yintra), PDO::PARAM_STR, 128);
            $statement->bindParam(':yextra', strval($yextra), PDO::PARAM_STR, 128);
            $statement->bindParam(':id_param', $id_param, PDO::PARAM_INT);
            $statement->bindParam(':lgx', strval($lgx), PDO::PARAM_STR, 128);

            $result = $statement->execute();
        } catch (PDOException $exception) {
            error_log('Connection error: ' . $exception->getMessage());
            return false;
        }

        return $result;
    }

    /**
     * Modifie les valeurs d'une cambrure de la BDD
     * 
     * @param int $id
     * @param cambrure $cambrure
     * 
     * @return boolean
     */
    public function UpdateCambrureObject($id, $cambrure) {
        return $this->UpdateCambrure($id, $cambrure->getX(), $cambrure->getT(), $cambrure->getF(), $cambrure->getYintra(), $cambrure->getYextra(), $cambrure->getId_param(), $cambrure->getIgz());
    }

}

?>