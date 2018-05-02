<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="author" content="Kévin Le Torc'h & Gwenolé Leroy-Ferrec" />
        <title>Création de profil - NAZCA</title>

        <link rel="stylesheet" type="text/css" media="screen" href="css/index.css" />
        <link rel="stylesheet" href="css/generic-theme.css">

        <script src="js/edit-form.js"></script>
    </head>

    <body id="#page-list">
        <!-- Inclusion Header -->
        <?php
        include("res/header.html");
        ?>

        <!-- Animation de chargement-->
        <div id="loading" class="hidden">
            <div id="outer-circle"></div>
            <div id="inner-circle"></div>
        </div>

        <?php
        require_once('php/bdd.php');

        /* Récupération de l'identifiant du paramètre à consulter */
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        /* Si l'dentifiant est est valide */
        if (!isset($id)) {
        ?>
        <!-- Formulaire d'ajout/édition de profil-->
        <div class="main-content">
            <form id="edit-param" class="vbox" action="action.php" method="GET">
                <h3>Paramètres de profil</h3>
                <input type="hidden" name="action" value="add_param">

                <input type="text" name="libelle" id="libelle" placeholder="Nom de l'enregistrement">
                <input type="number" name="corde" min="0" step="0.001" id="corde" placeholder="Corde">

                <div class="hbox">
                    <input type="number" name="tmax_p" id="tmax_p" step="any" min="0" placeholder="T max (pourcentage)">
                    <input type="number" name="fmax_p" id="fmax_p" step="any" min="0" placeholder="F max (pourcentage)">
                </div>

                <input type="number" name="nb_points" id="nb_points" step="1" min="0" max="10000" placeholder="Nombre de points de calcul">

                <button type="submit" id="btn-submit">Enregistrer et créer le profil</button>
            </form>
        </div>

        <?php
        } else {
            /* Initialisation de l'interface avec la BDD */
            $db = new BDDIO;

            /* Récupération du paramètre à consulter */
            $param = $db->RequestParam($id)[0];

            /* S'il existe/valide */
            if ($param)
            {
        ?>

        <div class="main-content">
            <form id="edit-param" class="vbox" action="action.php" method="GET">
                <h3>Paramètres de profil</h3>
                <input type="hidden" name="action" value="update_param">

                <?php
                echo '<input type="hidden" name="id" value="'.$id.'">';
                echo '<input type="text" name="libelle" id="libelle" placeholder="Nom de l\'enregistrement" value="'.$param->getLibelle().'">';
                echo '<input type="number" name="corde" min="0" step="0.001" id="corde" placeholder="Corde" value="'.$param->getCorde().'">';

                echo '<div class="hbox">';
                    echo '<input type="number" name="tmax_p" id="tmax_p" step="any" min="0" placeholder="T max (pourcentage)" value="'.$param->getTmax_p().'">';
                    echo '<input type="number" name="fmax_p" id="fmax_p" step="any" min="0" placeholder="F max (pourcentage)" value="'.$param->getFmax_p().'">';
                echo '</div>';

                echo '<input type="number" name="nb_points" id="nb_points" step="1" min="0" max="10000" placeholder="Nombre de points de calcul" value="'.$param->getNb_points().'">';
                ?>
                <button type="submit" id="btn-submit">Enregistrer les modifications</button>
            </form>
        </div>

        <?php
            }
        }
        ?>

        <?php
        include("res/footer.html");
        ?>

    </body>
</html>