<?php

require_once('php/bdd.php');

$db = new BDDIO;

echo "<b>dirty php debugging. if you don't want to loose your soul, get out.</b><br>begin action";

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

if (isset($action)) {

    echo "<br>action is set, begin processing";

    if ($action === 'del_param') {

        echo "<br>delete";
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

        if (!isset($id)) {
            // wrong id or not set  
        } else if ($db->RemoveParam($id)) {
            //success
        } else {
            //failure
        }
    } else if ($action === 'add_param' || $action === 'update_param') {

        echo "<br>parsing...";

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

        echo "done";

        if (!(isset($libelle) && isset($corde) && isset($tmax_p) && isset($fmax_p) && isset($tmax) && isset($fmax) && isset($nb_points))) {

            echo "<br>ERR_ACTION_INVALIDPARAM";
        } else {

            echo "<br>committing.";

            if (!isset($date)) {
                $date = date_create()->format('Y-m-d');
            }
            echo ".";
            if (!isset($fic_csv)) {
                $fic_csv = '#';
            }
            echo ".";
            if (!isset($fic_img)) {
                $fic_img = '#';
            }

            echo ".>";

            $param = new Parametre;

            $param->init(0, $libelle, $corde, $tmax_p, $fmax_p, $tmax, $fmax, $nb_points, $date, $fic_img, $fic_csv);
            echo ">";

            echo "This will never appear";

            if ($action === 'add_param') {
                if ($db->AddParamObject($param)) {
                    echo "<br>ERR_ACTION_ADD_NOERROR";
                } else {
                    echo "<br>ERR_ACTION_ADD_FAILED";
                }
            } else {
                if ($db->UpdateParam($id, $param)) {
                    echo "<br>ERR_ACTION_UPDATE_NOERROR";
                } else {
                    echo "<br>ERR_ACTION_UPDATE_FAILED";
                }
            }

            echo "done";
        }
    } else if ($action === 'del_cambrure') {
        echo "<br>ERR_ACTION_NOTIMPL";
    } else if ($action === 'add_cambrure') {
        echo "<br>ERR_ACTION_NOTIMPL";
    } else {
        echo "<br>ERR_ACTION_UNKNOWNACTION";
    }
} else {
    echo "<br>ERR_ACTION_UNSET";
}

echo "<br>end";
?>