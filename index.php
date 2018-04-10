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
                
                <h1> Bonjour </h1>

                <?php
                require_once('php/bdd.php');

                $db = dbConnect();
                
                $params = dbListParam($db);

                echo "<table><thead><td>#</td><td>Enregistrement</td></thead>";
                foreach ($params as $param)
                {
                        echo "<tr><td>".$param['id']."</td><td>".$param['libelle']."</td></tr>";
                }
                echo "</table>";
                //Faire des trucs
                ?>

        </div>

        <?php
        include("res/footer.html");
        ?>

    </body>
</html>