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

            <a class="button" href="add.php">Nouveau profil</a>

            <?php
            require_once('php/bdd.php');

            $db = new BDDIO;

            $params = $db->RequestAllParams();

            echo '<table class="flat-table"><thead><td>#</td><td>Enregistrement</td></thead>';
            foreach ($params as $param) {
                echo '<tr>';
                    echo '<td class="id">' . $param->getId() . '</td>';
                    echo '<td class="param-item">';
                        echo '<span>' . $param->getLibelle() . '</span>';
                        echo '<div>';
                            echo '<button class="edit-button" onclick="location.href=\'consultation.php?identifiant=' . $param->getId() . '\';" id="' . $param->getId() . '">🖉</button>';
                            echo '<button class="delete-button" onclick="if(confirm(\'Voulez vous supprimer ' . $param->getLibelle() . '?\')){location.href=\'action.php?action=del_param&id=' . $param->getId() . '\';}" id="' . $param->getId() . '">×</button>';
                        echo '</div>';
                    echo '</td>';
                echo '</tr>';
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