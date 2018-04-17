<html>
    <head>
        <meta charset="UTF-8" />
        <title> NAZCA Project C&amp;C SSOS 2018</title>

        <!--link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" /-->
        <link rel="stylesheet" type="text/css" media="screen" href="css/index.css" />
        <link rel="stylesheet" href="css/generic-theme.css">
    </head>

    <body>
        <?php
        include("res/header.html");
        ?>

        <div class="main-content">
                <div id="errors" class="container">
                </div>
                <div id="infos" class="container">
                </div>

                <h2>Accueil > Liste des enregistrements</h2>

                <?php
                require_once('php/bdd.php');

                $db = dbConnect();
                
                $params = dbRequestAllParams($db);

                echo '<table class="flat-table"><thead><td>#</td><td>Enregistrement</td></thead>';
                foreach ($params as $param)
                {
                        echo '<tr><td class="id">'.$param['id'].'</td><td class="param-item"><span>'.$param['libelle'].'</span><div><button class="edit-button" id="'.$param['id'].'">🖉</button><button class="delete-button" id="'.$param['id'].'">×</button></div></td></tr>';
                }
                echo '</table>';
                //Faire des trucs
                ?>

        </div>

        <?php
        include("res/footer.html");
        ?>

    </body>
</html>