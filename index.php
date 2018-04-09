<html>
    <head>
        <meta charset="UTF-8" />
        <title> NAZCA Project C&amp;C SSOS 2018</title>

        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" media="screen" href="css/index.css" />
    </head>

    <body>
        <div class="page-header container">
            <img class="circle" src="res/chen.png" />
            <big> Chen&amp;Co </big>
            <medium> Homepage </medium>
        </div>

        <div id="errors" class="container">
        </div>
        <div id="infos" class="container">
        </div>
        <h1> Bonjour </h1>

        <?php
        require_once('php/bdd.php');

        $db = dbConnect();
        
        ?>

        <footer class="footer">
            <div class="container">
                <span> Service Spécial des Opérations Spéciales, Chen&amp;Co ©</span>
            </div>
        </footer>
    </body>
</html>