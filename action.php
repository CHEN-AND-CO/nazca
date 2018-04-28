<html>
    <head>
        <meta charset="UTF-8" />
        <title>Création de profil - NAZCA</title>

        <link rel="stylesheet" type="text/css" media="screen" href="css/index.css" />
        <link rel="stylesheet" href="css/generic-theme.css">
    </head>

    <body id="#page-list">
        <?php
        include("res/header.html");
        ?> 
        <div class="main-content">
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
                        echo '<h2> ERREUR: Une ou des valeurs requises pour la création d\'un paramètre est/sont invalide(s) </h2>';
                    } else {
                        if (!isset($date)) {
                            $date = date_create()->format('Y-m-d');
                        }
                        if (!isset($fic_csv)) {
                            $fic_csv = '#';
                        }
                        if (!isset($fic_img)) {
                            $fic_img = '#';
                        }

                        $param = new Parametre;

                        $param->init(0, $libelle, $corde, $tmax_p, $fmax_p, $tmax, $fmax, $nb_points, $date, $fic_img, $fic_csv);

                        if ($action === 'add_param') {
                            if ($db->AddParamObject($param)) {
                                echo '<h2> Vous avez rajouté ' . $param->getLibelle() . ' à la Base de donnée !</h2>';
                            } else {
                                echo '<h2> ERREUR: Impossible d\'ajouter ' . $param->getLibelle() . ' à la Base de donnée !</h2>';
                            }
                        } else {
                            if ($db->UpdateParam($id, $param)) {
                                echo '<h2> Vous avez modifié ' . $param->getLibelle() . ' avec succès ! </h2>';
                            } else {
                                echo '<h2> ERREUR: Impossible de modifier ' . $param->getLibelle() . ' dans la Base de donnée !</h2>';
                            }
                        }
                    }
                } else if ($action === 'del_cambrure') {
                    echo "<br>ERR_ACTION_NOTIMPL";
                } else if ($action === 'add_cambrure') {
                    echo "<br>ERR_ACTION_NOTIMPL";
                } else {
                    echo '<h2> ERREUR: Cette action n\'existe pas </h2>';
                }
            } else {
                echo "<br>ERR_ACTION_UNSET";
            }

            echo '<a class="button" href="/">Retour à l\'acceuil</a>';
            echo '<a class="button" href="/ add.php">Recommencer</a>';
            ?>
        </div>
        <?php
        include("res/footer.html");
        ?>

    </body>
</html>