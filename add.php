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
            <form class="vbox" action="action.php">

                <h3>Paramétres de profil</h3>
                <input type="hidden" name="action" value="add_param">

                <input type="text" name="libelle" id="libelle" placeholder="Nom de l'enregistrement">
                <input type="number" name="corde" id="corde" placeholder="Corde">

                <div class="hbox">
                    <input type="number" name="tmax_p" id="tmax_p" placeholder="T max (pourcentage)">
                    <input type="number" name="fmax_p" id="fmax_p" placeholder="F max (pourcentage)">
                </div>

                <div class="hbox">
                    <input type="number" name="tmax" id="tmax" placeholder="T max">
                    <input type="number" name="fmax" id="fmax" placeholder="F max">
                </div>

                <input type="number" name="nb_points" id="nb_points" placeholder="Nombre de points de calcul">
                
                <input type="hidden" name="fic_csv" value="">
                <input type="hidden" name="fic_img" value="">
                
                <button type="submit">Enregistrer et créer le profil</button>
            </form>
        </div>

        <?php
        include("res/footer.html");
        ?>

    </body>
</html>