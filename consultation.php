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

            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

            if (!isset($id))
            {
                echo "<h2>400 Bad Request</h2><p>Le profil demandé n'existe pas</p>";
            } else {

                $db = new BDDIO;

                $param = $db->RequestParam($id);

                if ($param) echo "teeeeeeeest";
                
                $cambrures = $db->RequestAllCambruresFromParam(intval($_GET['id']));

                echo '<table class="flat-table"><thead><td>id</td><td>x</td><td>f</td><td>t</td><td>y<sub>intra</sub></td><td>y<sub>extra</sub></td><td>id_param</td><td>Ig<sub>z</sub></td></thead>';
                foreach ($cambrures as $cambrure) {
                    echo '<tr>';
                    echo '<td>' . round( $cambrure->getId(), 2) . '</td>';
                    echo '<td>' . round( $cambrure->getX(), 2) . '</td>';
                    echo '<td>' . round( $cambrure->getF(), 2) . '</td>';
                    echo '<td>' . round( $cambrure->getT(), 2) . '</td>';
                    echo '<td>' . round( $cambrure->getYintra(), 2) . '</td>';
                    echo '<td>' . round( $cambrure->getYextra(), 2) . '</td>';
                    echo '<td>' . round( $cambrure->getId_param(), 2) . '</td>';
                    echo '<td>' . round( $cambrure->getIgz(), 5) . '</td>';
                    echo '</tr>';
                }
                echo '</table>';


                echo '<br></br><h2> test de chargement de CSV </h2>';

                require_once('php/CSVIO.php');

                $cambrures2 = CSVIO::getCSVFileAsCambrureArray('test.csv');

                echo '<table class="flat-table"><thead><td>id</td><td>x</td><td>f</td><td>t</td><td>yintra</td><td>yextra</td><td>id_param</td><td>Igz</td></thead>';
                foreach ($cambrures2 as $cambrure) {
                    echo '<tr>';
                    echo '<td>' . $cambrure->getId() . '</td>';
                    echo '<td>' . $cambrure->getX() . '</td>';
                    echo '<td>' . $cambrure->getF() . '</td>';
                    echo '<td>' . $cambrure->getT() . '</td>';
                    echo '<td>' . $cambrure->getYintra() . '</td>';
                    echo '<td>' . $cambrure->getYextra() . '</td>';
                    echo '<td>' . $cambrure->getId_param() . '</td>';
                    echo '<td>' . $cambrure->getIgz() . '</td>';
                    echo '</tr>';
                }
                echo '</table>';

                CSVIO::writeCambrureArrayToCSVFile('test' . date_create()->format('Y-m-d') . '.csv', $cambrures);
                
            }
            ?>

        </div>

        <?php
        include("res/footer.html");
        ?>

    </body>
</html>