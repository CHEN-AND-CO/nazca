<html>
    <head>
        <meta charset="UTF-8" />
        <title> NAZCA Project C&amp;C SSOS 2018</title>

<<<<<<< HEAD
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
=======
        <!--link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" /-->
>>>>>>> 64f15b7befe73f2047d21c55a24b4cac2fa22373
        <link rel="stylesheet" type="text/css" media="screen" href="css/index.css" />
    </head>

    <body>
<<<<<<< HEAD
        <div class="page-header container">
            <img class="circle" src="res/chen.png" />
            <big> Chen&amp;Co </big>
            <medium> Homepage </medium>
        </div>
=======
        <?php
        include("res/header.html");
        ?>
>>>>>>> 64f15b7befe73f2047d21c55a24b4cac2fa22373

        <div id="errors" class="container">
        </div>
        <div id="infos" class="container">
        </div>
        <h1> Bonjour </h1>

        <?php
        require_once('php/bdd.php');

        $db = dbConnect();
        
<<<<<<< HEAD
        ?>

        <footer class="footer">
            <div class="container">
                <span> Service Spécial des Opérations Spéciales, Chen&amp;Co ©</span>
            </div>
        </footer>
=======
        //Faire des trucs
        ?>

        <?php
        include("res/footer.html");
        ?>
>>>>>>> 64f15b7befe73f2047d21c55a24b4cac2fa22373
    </body>
</html>