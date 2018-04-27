<html>
    <head>
        <meta charset="UTF-8" />
        <title> NAZCA Project C&amp;C SSOS 2018</title>

        <link rel="stylesheet" type="text/css" media="screen" href="css/index.css" />
        <link rel="stylesheet" href="css/generic-theme.css">
    </head>

    <body id="#page-list">
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
                    echo '<tr><td class="id">'.$param->getId().'</td><td class="param-item"><span>'.$param->getLibelle().'</span><div><button class="edit-button" onclick="location.href=\'consultation.php?identifiant='.$param->getId().'\';" id="'.$param->getId().'">🖉</button><button class="delete-button" id="'.$param->getId().'">×</button></div></td></tr>';
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