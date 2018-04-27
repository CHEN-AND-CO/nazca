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

                <h2>Consultation du paramètre</h2>

                <?php
                require_once('php/bdd.php');

                $db = dbConnect();
                
                $cambrures = dbRequestAllCambruresFromParam($db, intval($_GET['identifiant']));
                
                echo '<table class="flat-table"><thead><td>id</td><td>x</td><td>f</td><td>t</td><td>yintra</td><td>yextra</td><td>id_param</td><td>Igz</td></thead>';
                foreach ($cambrures as $cambrure){
                    echo '<tr>';
                    echo '<td>'.$cambrure->getId().'</td>';
                    echo '<td>'.$cambrure->getX().'</td>';
                    echo '<td>'.$cambrure->getF().'</td>';
                    echo '<td>'.$cambrure->getT().'</td>';
                    echo '<td>'.$cambrure->getYintra().'</td>';
                    echo '<td>'.$cambrure->getYextra().'</td>';
                    echo '<td>'.$cambrure->getId_param().'</td>';
                    echo '<td>'.$cambrure->getIgz().'</td>';
                    echo '</tr>';
                }
                echo '</table>';


                echo '<br></br><h2> test de chargement de CSV </h2>';

                require_once('php/CSVIO.php');

                $cambrures2 = CSVIO::getCSVFileAsCambrureArray('test.csv');

                echo '<table class="flat-table"><thead><td>id</td><td>x</td><td>f</td><td>t</td><td>yintra</td><td>yextra</td><td>id_param</td><td>Igz</td></thead>';
                foreach ($cambrures2 as $cambrure){
                    echo '<tr>';
                    echo '<td>'.$cambrure->getId().'</td>';
                    echo '<td>'.$cambrure->getX().'</td>';
                    echo '<td>'.$cambrure->getF().'</td>';
                    echo '<td>'.$cambrure->getT().'</td>';
                    echo '<td>'.$cambrure->getYintra().'</td>';
                    echo '<td>'.$cambrure->getYextra().'</td>';
                    echo '<td>'.$cambrure->getId_param().'</td>';
                    echo '<td>'.$cambrure->getIgz().'</td>';
                    echo '</tr>';
                }
                echo '</table>';
                ?>

        </div>

        <?php
        include("res/footer.html");
        ?>

    </body>
</html>