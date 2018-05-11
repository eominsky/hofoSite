<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <link rel="stylesheet" type="text/css" href="css/plants.css">
        <!--Custom icon-->
        <link href="https://file.myfontastic.com/uZM4xs3mM5re5dydBReL44/icons.css" rel="stylesheet">
        <!-- jQuery library for datepicker -->
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <!--Javascript-->
        
        <script type="text/javascript" src="js/main.js"></script>
        
        <title>Plants</title>
    </head>
    
    <body>
        
        <h1>Plants <!-- Album Name --></h1>


    <?php
    require_once 'config-db.php';
    $plant_id = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT ); 

    $result = $mysqli->query("SELECT * FROM plants WHERE plantID = '".$plant_id."'");   

    while ($prow = $result->fetch_assoc()) {
        echo "<div class='indivPlant'>";
        echo "<header>";
        echo "<h1>". $prow['plantName']."</h1>";
        echo "</header>";
        echo "<h3>". $prow['scientificName']."</h3>";
        echo "<img src='images/".$prow['fileName']."' alt='images/".$prow['plantName']."'>";
        echo "<p>". $prow['careInstructions']."</p>";
        echo '<a href="plants.php"><h4>go back to all plants</h4></a>';
        echo "</div>";
    }
    ?>
    
        
        <?php include 'nav.php' ?>
    </body>
</html>
