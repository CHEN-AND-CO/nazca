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

    public function BDDIO() {
        $this->Connect();
    }

    public function getBdd() {
        return $this->bdd;
    }

    public function setBdd($_bdd) {
        $this->bdd = $_bdd;
    }

    public function Connect() {
        try {
            $this->setBdd(new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASSWORD));
        } catch (PDOException $exception) {
            error_log('Connection error: ' . $exception->getMessage());
            return false;
        }

        return $this->getBdd();
    }

    public function dbConnect() {
        try {
            $db = new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASSWORD);
        } catch (PDOException $exception) {
            error_log('Connection error: ' . $exception->getMessage());
            return false;
        }
        return $db;
    }

    public function AddParam($libelle, $corde, $tmax_p, $fmax_p, $tmax, $fmax, $nb_points, $date, $fic_img, $fic_csv) {
        try {
            $request = 'insert into parametre(libelle, corde, tmax_p, fmax_p, tmax, fmax, nb_points, date, fic_img, fic_csv)
            values(:libelle, :corde, :tmax_p, :fmax_p, :tmax, :fmax, :nb_points, :date, :fic_img, :fic_csv)';

            $statement = $this->getBdd()->prepare($request);
            $statement->bindParam(':libelle', $libelle, PDO::PARAM_STR, 40);
            $statement->bindParam(':corde', strval($corde), PDO::PARAM_STR, 128);
            $statement->bindParam(':tmax_p', strval($tmax_p), PDO::PARAM_STR, 128);
            $statement->bindParam(':fmax_p', strval($fmax_p), PDO::PARAM_STR, 128);
            $statement->bindParam(':tmax', strval($tmax), PDO::PARAM_STR, 128);
            $statement->bindParam(':fmax', stdval($fmax), PDO::PARAM_STR, 128);
            $statement->bindParam(':nb_points', $nb_points, PDO::PARAM_INT);
            $statement->bindParam(':date', $date, PDO::PARAM_STR);
            $statement->bindParam(':fic_img', $fic_img, PDO::PARAM_STR, 256);
            $statement->bindParam(':fic_csv', $fic_csv, PDO::PARAM_STR, 256);

            $statement->execute();
        } catch (PDOException $exception) {
            error_log('Connection error: ' . $exception->getMessage());
            return false;
        }
    }

    public function dbAddParam($db, $libelle, $corde, $tmax_p, $fmax_p, $tmax, $fmax, $nb_points, $date, $fic_img, $fic_csv) {
        try {
            $request = 'insert into parametre(libelle, corde, tmax_p, fmax_p, tmax, fmax, nb_points, date, fic_img, fic_csv)
            values(:libelle, :corde, :tmax_p, :fmax_p, :tmax, :fmax, :nb_points, :date, :fic_img, :fic_csv)';

            $statement = $db->prepare($request);
            $statement->bindParam(':libelle', $libelle, PDO::PARAM_STR, 40);
            $statement->bindParam(':corde', strval($corde), PDO::PARAM_STR, 128);
            $statement->bindParam(':tmax_p', strval($tmax_p), PDO::PARAM_STR, 128);
            $statement->bindParam(':fmax_p', strval($fmax_p), PDO::PARAM_STR, 128);
            $statement->bindParam(':tmax', strval($tmax), PDO::PARAM_STR, 128);
            $statement->bindParam(':fmax', stdval($fmax), PDO::PARAM_STR, 128);
            $statement->bindParam(':nb_points', $nb_points, PDO::PARAM_INT);
            $statement->bindParam(':date', $date, PDO::PARAM_STR);
            $statement->bindParam(':fic_img', $fic_img, PDO::PARAM_STR, 256);
            $statement->bindParam(':fic_csv', $fic_csv, PDO::PARAM_STR, 256);

            $statement->execute();
        } catch (PDOException $exception) {
            error_log('Connection error: ' . $exception->getMessage());
            return false;
        }
    }

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

    public function dbRequestParam($db, $id) {
        try {
            $request = 'select * from parametre where id=:id';
            $statement = $db->prepare($request);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_CLASS, 'Parametre');
        } catch (PDOException $exception) {
            error_log('Request error: ' . $exception->getMessage());
            return false;
        }
        return $result;
    }

    public function RequestAllParams() {
        try {
            $request = 'select * from parametre';
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

    public function dbRequestAllParams($db) {
        try {
            $request = 'select * from parametre';
            $statement = $db->prepare($request);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_CLASS, 'Parametre');
        } catch (PDOException $exception) {
            error_log('Request error: ' . $exception->getMessage());
            return false;
        }
        return $result;
    }

    public function RemoveParam($_id) {
        try {
            $request = 'delete from parametre where id=:id';
            $statement = $this->getBdd()->prepare($request);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
        } catch (PDOException $exception) {
            error_log('Request error: ' . $exception->getMessage());
            return false;
        }
        return true;
    }

    public function dbRemoveParam($db, $_id) {
        try {
            $request = 'delete from parametre where id=:id';
            $statement = $db->prepare($request);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
        } catch (PDOException $exception) {
            error_log('Request error: ' . $exception->getMessage());
            return false;
        }
        return true;
    }

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

            $statement->execute();
        } catch (PDOException $exception) {
            error_log('Connection error: ' . $exception->getMessage());
            return false;
        }
    }

    public function dbAddCambrure($db, $x, $t, $f, $yintra, $yextra, $id_param, $lgx) {
        try {
            $request = 'insert into cambrure(x, t, f, yintra, yextra, id_param, lgx)
            values(:x, :t, :f, :yintra, :yextra, :id_param, :lgx)';

            $statement = $db->prepare($request);
            $statement->bindParam(':x', strval($x), PDO::PARAM_STR, 128);
            $statement->bindParam(':t', strval($t), PDO::PARAM_STR, 128);
            $statement->bindParam(':f', strval($f), PDO::PARAM_STR, 128);
            $statement->bindParam(':yintra', strval($yintra), PDO::PARAM_STR, 128);
            $statement->bindParam(':yextra', strval($yextra), PDO::PARAM_STR, 128);
            $statement->bindParam(':id_param', $id_param, PDO::PARAM_INT);
            $statement->bindParam(':lgx', strval($lgx), PDO::PARAM_STR, 128);

            $statement->execute();
        } catch (PDOException $exception) {
            error_log('Connection error: ' . $exception->getMessage());
            return false;
        }
    }

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

    public function dbRequestAllCambruresFromParam($db, $id_param) {
        try {
            $request = 'select * from cambrure where id_param=:id_param';
            $statement = $db->prepare($request);
            $statement->bindParam(':id_param', $id_param, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_CLASS, 'Cambrure');
        } catch (PDOException $exception) {
            error_log('Request error: ' . $exception->getMessage());
            return false;
        }
        return $result;
    }

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

    public function dbRequestCambrure($db, $id) {
        try {
            $request = 'select * from cambrure where id=:id';
            $statement = $db->prepare($request);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_CLASS, 'Cambrure');
        } catch (PDOException $exception) {
            error_log('Request error: ' . $exception->getMessage());
            return false;
        }
        return $result;
    }

}

?>