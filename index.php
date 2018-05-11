<?php include 'config.php'; ?>
        <link rel="stylesheet" type="text/css" href="css/home.css">
        
        <title>Hortus Forum</title>
    </head>
    <body>
            <header>
                <h1>Hortus Forum</h1>
                <?php if (isset($_SESSION['logged_user'])){
                        print("<button class='new-type'><span class='icon-plus'></span></button>");
                        print("</header>");
                    }
                ?>
                
            <h2>Cornell's Undergraduate Horticulture Club</h2>
                <!-- Have plant albums with album thumbnail
                When you click the album thumbnail, it takes you to a different page with all the plants-->
                <?php
                    require_once 'config-db.php';


                $types=$mysqli->query("SELECT * FROM types");

                 while ($row=$types->fetch_assoc()){
                     print("<div class='grid'>
                        <form action='plants.php?type_id=$row[typeID]' method='GET'>
                            <input type='hidden' name='typeid' value='$row[typeID]'>
                            <input class='typedisplay' type='image' src='images/$row[fileName]' alt='$row[typeName]' width='300'><br>
                            <a href='plants.php?typeid=$row[typeID]'>$row[typeName]</a>
                        </form>
                     </div>");
                 }
             ?>
            
        
        
        <?php
          include 'nav.php';
          include 'php/login.php';
          include 'php/logout.php';
          include 'php/newType.php';
        ?>
    </body>

</html>
