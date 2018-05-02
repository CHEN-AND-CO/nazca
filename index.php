<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="author" content="Kévin Le Torc'h & Gwenolé Leroy-Ferrec" />
        <title> NAZCA Project C&amp;C SSOS 2018</title>

        <link rel="stylesheet" type="text/css" media="screen" href="css/index.css" />
        <link rel="stylesheet" href="css/generic-theme.css">

        <script src="js/listprofils.js"></script>
    </head>

    <body id="#page-list">
        <!-- Inclusion Header -->
        <?php
        include("res/header.html");
        ?>

        <!-- Contenu de la page -->
        <div class="main-content">
            <h2>Accueil > Liste des enregistrements</h2>

            <table class="flat-table" id="plist" >
                <thead>
                <td>#</td>
                <td>Enregistrement <a class="button" id="btn-add" href="add.php">Nouveau profil</a></td>
                </thead>

                <?php
                require_once('php/bdd.php');

                $db = new BDDIO;

                $params = $db->RequestAllParams();

                foreach ($params as $param) {
                    echo '<tr id="'.$param->getId().'">';
                        echo '<td class="id">' . $param->getId() . '</td>';
                        echo '<td class="param-item">';
                            echo '<span>' . $param->getLibelle() . '</span>';
                            echo '<div>';
                                echo '<button class="edit-button" onclirck="location.href=\'consultation.php?id=' . $param->getId() . '\';" id="' . $param->getId() . '">🖉</button>';
                                echo '<button class="delete-button" oncleick="if(confirm(\'Voulez vous supprimer ' . $param->getLibelle() . '?\')){location.href=\'action.php?action=del_param&id=' . $param->getId() . '\';}" id="' . $param->getId() . '">×</button>';
                            echo '</div>';
                        echo '</td>';
                    echo '</tr>';
                }
                //Faire des trucs
                ?>
            </table>
        </div>

        <!-- Inclusion Footer -->
        <?php
        include("res/footer.html");
        ?>
    </body>
</html>