<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="author" content="Kévin Le Torc'h & Gwenolé Leroy-Ferrec" />
        <title> NAZCA Project C&amp;C SSOS 2018</title>

        <!-- Inclusion fiche de styles -->
        <link rel="stylesheet" type="text/css" media="screen" href="css/index.css" />
        <link rel="stylesheet" href="css/generic-theme.css">

        <!-- Inclusion script js -->
        <script src="js/consult.js"></script>
    </head>

    <body id="#page-list">
        <!-- Include Header -->
        <?php
        include("res/header.html");
        ?>

        <!-- Contenu principal de la page -->
        <div class="main-content">
            <?php
            require_once('php/bdd.php');

            /* Récupération de l'identifiant du paramètre à consulter */
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

            /* Si l'dentifiant n'est pas précisé ou invalide */
            if (!isset($id)) {
                echo "<h2>400 Bad Request</h2><p>Le profil demandé n'est pas valide</p>";
            } else {
                /* Initialisation de l'interface avec la BDD */
                $db = new BDDIO;

                /* Récupération du paramètre à consulter */
                $param = $db->RequestParam($id)[0];

                /* S'il existe/valide */
                if ($param) {
                    /* Création du bouton pour récupérer le fichier csv */
                    echo '<a class="button" id="btn-csv" href="' . $param->getFic_csv() . '">Télécharger au format CSV</a>';
                    /* Affichage du nom du profil */
                    echo "<h2>Profil <i>" . $param->getLibelle() . "</i></h2>";

                    /* Affichage de l'apercu du profil */
                    echo '<div class="box-right">';
                        echo '<div class="hbox"><h3>Aperçu</h3><a href="#" id="graph-open-btn">Voir tous les graphes</a></div>';
                        echo '<a target="_blank" download="'.$param->getLibelle().'-'.$param->getDate().'.jpg" href="' . $param->getFic_img() . '"><img src="' . $param->getFic_img() . '" alt="Pas d\'aperçu disponible" class="graph"></a>';
                    echo '</div>';

                    /* Préparation de l'affichage de tous les graphes */
                    echo '<div class="window hidden vertically-centered" id="graph-window">';
                        echo '<button id="close-btn">×</button>';
                        echo '<h3>Profil</h3>';
                        echo '<a target="_blank" download="'.$param->getLibelle().'-'.$param->getDate().'.jpg" href="' . $param->getFic_img() . '"><img src="' . $param->getFic_img() . '" alt="Graphe indisponible" class="graph"></a>';
                        echo '<h3>Rigidité / solidité du profil</h3>';
                        echo '<a target="_blank" download="'.$param->getLibelle().'-'.$param->getDate().'_bis.jpg" href="' . $param->getFic_img_bis() . '"><img src="' . $param->getFic_img_bis() . '" alt="Graphe indisponible" class="graph"></a>';
                    echo '</div>';

                    /* Affichage de caractéristiques */
                    echo '<h3>Caractéristiques</h3>';
                    echo '<ul id="params">';
                        echo '<li><b>N° : </b>' . $param->getId() . '</li>';
                        echo '<li><b>Nom : </b>' . $param->getLibelle() . '</li>';
                        echo '<li><b>Corde : </b>' . $param->getCorde() . ' mm</li>';
                        echo '<li><b>T<sub>max</sub> : </b>' . $param->getTmax() . ' mm (' . $param->getTmax_p() . ' %)</li>';
                        echo '<li><b>F<sub>max</sub> : </b>' . $param->getFmax() . ' mm (' . $param->getFmax_p() . ' %)</li>';
                        echo '<li><b>Points de calcul : </b>' . $param->getNb_points() . '</li>';
                    echo '</ul>';

                    /* Récupération des cambrures du profil */
                    $cambrures = $db->RequestAllCambruresFromParam($id);

                    /* En tête du tableau */
                    echo '<table class="flat-table">';
                        echo '<thead>';
                            echo '<td>id</td>';
                            echo '<td>x</td>';
                            echo '<td>f</td>';
                            echo '<td>t</td>';
                            echo '<td>y<sub>intra</sub></td>';
                            echo '<td>y<sub>extra</sub></td>';
                            echo '<td>id_param</td>';
                            echo '<td>Ig<sub>z</sub></td>';
                        echo '</thead>';

                    /* Affichage des valeurs des cambrures */
                    foreach ($cambrures as $cambrure) {
                        echo '<tr>';
                            echo '<td>' . round($cambrure->getId(), 2) . '</td>';
                            echo '<td>' . round($cambrure->getX(), 2) . '</td>';
                            echo '<td>' . round($cambrure->getF(), 2) . '</td>';
                            echo '<td>' . round($cambrure->getT(), 2) . '</td>';
                            echo '<td>' . round($cambrure->getYintra(), 2) . '</td>';
                            echo '<td>' . round($cambrure->getYextra(), 2) . '</td>';
                            echo '<td>' . round($cambrure->getId_param(), 2) . '</td>';
                            echo '<td>' . sprintf("%.2E", $cambrure->getIgz()) . '</td>';
                        echo '</tr>';
                    }

                    echo '</table>'; //Fin du tableau
                    } else { // Si le profil n'existe pas
                    echo "<h2>400 Bad Request</h2><p>Le profil demandé n'existe pas !</p>";
                }
            }
            ?>
        </div>

        <!-- Inclusion Footer -->
        <?php
        include("res/footer.html");
        ?>
    </body>
</html>