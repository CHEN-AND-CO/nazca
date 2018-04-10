<html>
    <head>
        <meta charset="UTF-8" />
        <title> NAZCA Project C&amp;C SSOS 2018</title>

        <!--link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" /-->
        <link rel="stylesheet" type="text/css" media="screen" href="css/index.css" />
    </head>

    <body>
        <?php
        include("res/header.html");
        ?>

        <div id="errors" class="container">
        </div>
        <div id="infos" class="container">
        </div>
        <h1> Bonjour </h1>

        <?php
        require_once('php/bdd.php');

        $db = dbConnect();
        
        //Faire des trucs
        ?>

        <?php
        include("res/footer.html");
        ?>
    </body>
</html>