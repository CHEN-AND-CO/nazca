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
            require_once('php/graph.php');

            $db = new BDDIO;

            $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

            if (isset($action)) {
                if ($action === 'del_param') {
                    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

                    if (!isset($id)) {
                        echo '<h2> ERREUR: vous n\'avez pas précisé quel paramètre à supprimer</h2>';
                    } else if ($db->deleteParam($id)) {
                        header("Location: /");
                        exit;
                    } else {
                        echo '<h2> ERREUR: Impossible de supprimer le paramètre</h2>';
                    }
                } else if ($action === 'add_param' || $action === 'update_param') {
                    if ($action === 'update_param') {
                        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
                    }

                    $libelle = filter_input(INPUT_GET, 'libelle', FILTER_SANITIZE_STRING);
                    $corde = filter_input(INPUT_GET, 'corde', FILTER_SANITIZE_NUMBER_FLOAT);
                    $tmax_p = filter_input(INPUT_GET, 'tmax_p', FILTER_SANITIZE_NUMBER_FLOAT);
                    $fmax_p = filter_input(INPUT_GET, 'fmax_p', FILTER_SANITIZE_NUMBER_FLOAT);
                    //$tmax = filter_input(INPUT_GET, 'tmax', FILTER_SANITIZE_NUMBER_FLOAT);
                    //$fmax = filter_input(INPUT_GET, 'fmax', FILTER_SANITIZE_NUMBER_FLOAT);
                    $nb_points = filter_input(INPUT_GET, 'nb_points', FILTER_SANITIZE_NUMBER_INT);
                    $date = filter_input(INPUT_GET, 'date', FILTER_SANITIZE_STRING);
                    

                    if (!(isset($libelle) && isset($corde) && isset($tmax_p) && isset($fmax_p) && isset($nb_points))) {
                        echo '<h2> ERREUR: Une ou des valeurs requises pour la création d\'un paramètre est/sont invalide(s) </h2>';
                    } else {
                        if (!isset($date)) {
                            $date = date_create()->format('Y-m-d');
                        }

                        /* Nom des fichiers image et csv */
                        $filename = sizeof( $db->RequestAllParams() ).str_replace(' ', '_', $libelle);
                        $fic_img = '/res/img/'.$filename.'.jpg';
                        $fic_csv = '/res/csv/'.$filename.'.csv';

                        $param = new Parametre;

                        $param->init(0, $libelle, $corde, $tmax_p, $fmax_p, ($tmax_p / 100) * $corde, ($fmax_p / 100) * $corde, $nb_points, $date, $fic_img, $fic_csv);

                        if ($action === 'add_param') {
                            if ($db->AddParamObject($param)) {
                                echo '<h2> Vous avez rajouté ' . $param->getLibelle() . ' à la Base de donnée !</h2>';

                                $dirtytmp = $db->RequestAllParams();
                                $parametre = $dirtytmp[sizeof($dirtytmp) - 1];

                                /* ===================== Génération des cambrures ==================== */
                                /* Génération de la première cambrure */
                                $cambrures = array();
                                $one = new Cambrure;
                                $one->genesis($parametre);
                                array_push($cambrures, $one);

                                /* Génération des autres cambrures */
                                for ($i = 1; $i < $parametre->getNb_points()+1; $i++) {
                                    $tmp = new Cambrure;
                                    $tmp->create($parametre, $cambrures[$i - 1]);

                                    array_push($cambrures, $tmp);
                                }

                                /* Préparation au calcul du centre de gravité */
                                for ($i = 0; $i < $parametre->getNb_points() - 1; $i++) {
                                    $cambrures[$i]->initPg($parametre, $cambrures[$i + 1]);
                                }
                                $cambrures[$parametre->getNb_points() - 1]->initPg($parametre, $cambrures[0]);
                                $parametre->initXg($cambrures);

                                /* Calcul des Igz */
                                for ($i = 0; $i < $parametre->getNb_points() - 1; $i++) {
                                    $cambrures[$i]->initIgz($parametre, $cambrures[$i + 1]);
                                }
                                $cambrures[$parametre->getNb_points() - 1]->initIgz($parametre, $cambrures[0]);

                                /* Ajout des cambrures */
                                foreach ($cambrures as $cambrure) {
                                    if ($db->AddCambrureObject($cambrure)) {
                                        
                                    } else {
                                        echo '<h2> ERREUR: Impossible d\'ajouter la cambrure n°' . $cambrure->getId() . ' de' . $parametre->getLibelle() . ' !</h2>';
                                    }
                                }

                                /* Création des fichiers CSV et image */
                                echo __DIR__.$fic_img;
                                createGraph($id, __DIR__.$fic_img);
                                CSVIO::writeCambrureArrayToCSVFile(__DIR__.$fic_csv, $cambrures);
                                
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
            ?>
        </div>
        <?php
        include("res/footer.html");
        ?>

    </body>
</html>