<html>
    <head>
        <meta charset="UTF-8" />
        <title>Création de profil - NAZCA</title>

        <link rel="stylesheet" type="text/css" media="screen" href="css/index.css" />
        <link rel="stylesheet" href="css/generic-theme.css">

        <script src="js/edit-form.js"></script>
    </head>

    <body id="#page-list">

        <?php
        include("res/header.html");
        ?>

        <!-- Animation de chargement-->
        <div id="loading" class="hidden">
            <div id="outer-circle"></div>
            <div id="inner-circle"></div>
        </div>
        
        <!-- Formulaire d'ajout/édition de profil-->
        <div class="main-content">
            <!--iframe name="hiddenFrame" width="0" height="0" border="0" style="display: none;"></iframe-->
            <!--form class="vbox" action="action.php" target="hiddenFrame" method="GET"-->
            <form id="edit-param" class="vbox" action="action.php" method="GET">
                <h3>Paramétres de profil</h3>
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
        include("res/footer.html");
        ?>

    </body>
</html>