<?php

require_once('php/bdd.php');

$db = new BDDIO;

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

if (isset($action)) {
    if ($action === 'del_param') {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

        if (!isset($id)) {
            // wrong id or not set  
        } else if ($db->RemoveParam($id)) {
            //success
        } else {
            //failure
        }
    } else if ($action === 'add_param' || $action === 'update_param') {
        if ($action === 'update_param') {
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        }
        $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_STRING);
        $corde = filter_input(INPUT_POST, 'corde', FILTER_SANITIZE_NUMBER_FLOAT);
        $tmax_p = filter_input(INPUT_POST, 'tmax_p', FILTER_SANITIZE_NUMBER_FLOAT);
        $fmax_p = filter_input(INPUT_POST, 'fmax_p', FILTER_SANITIZE_NUMBER_FLOAT);
        $tmax = filter_input(INPUT_POST, 'tmax', FILTER_SANITIZE_NUMBER_FLOAT);
        $fmax = filter_input(INPUT_POST, 'fmax', FILTER_SANITIZE_NUMBER_FLOAT);
        $nb_points = filter_input(INPUT_POST, 'nb_points', FILTER_SANITIZE_NUMBER_INT);
        $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
        $fic_img = filter_input(INPUT_POST, 'fic_img', FILTER_SANITIZE_URL);
        $fic_csv = filter_input(INPUT_POST, 'fic_csv', FILTER_SANITIZE_URL);

        if (!(isset($libelle) && isset($corde) && isset($tmax_p) && isset($fmax_p) && isset($tmax) && isset($fmax) && isset($nb_points))) {
            //erreur une ou des valeurs du parametre invalide  
        } else {
            if (!isset($date)) {
                $date = date_create()->format('Y-m-d H:i:s');
            }


            if ($action === 'add_param') {
                if ($db->AddParam($libelle, $corde, $tmax_p, $fmax_p, $tmax, $fmax, $nb_points, $date, $fic_img, $fic_csv)) {
                    //success
                } else {
                    //failure
                }
            } else {
                if ($db->UpdateParam($id, $libelle, $corde, $tmax_p, $fmax_p, $tmax, $fmax, $nb_points, $date, $fic_img, $fic_csv)) {
                    //success
                } else {
                    //failure
                }
            }
        }
    }
}
?>