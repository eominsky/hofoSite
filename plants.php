<?php include 'config.php'; ?>
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <link rel="stylesheet" type="text/css" href="css/plants.css">
        <link rel="stylesheet" type="text/css" href="css/form.css">
        <title>Plants</title>
    </head>

    <body>
        <div class="heading">
            <h1>Plants <!-- Album Name --></h1>
        <?php
            if (isset($_SESSION['logged_user'])){
                print("<button class='add-plant'><span class='icon-plus'></span></button>");
            }
        ?>
        </div>
        
        
        <!-- Show all plants here -->
        <?php
            require_once 'config-db.php';
        
            if (isset($_GET['typeid'])){
                
                $typeID=$_GET['typeid'];
                
                $title = $mysqli->query("SELECT typeName FROM types WHERE typeID=$typeID");
                while($row = $title->fetch_assoc()){
                    print("<h2>$row[typeName]</h2>");
                }
                
                $alltypes = $mysqli->query("SELECT * FROM types");
                
                print("<h3><a href='plants.php'>Go to all plants</a></h3>");
                
                $result = $mysqli->query("SELECT * FROM plants INNER JOIN plantToType ON plants.plantID=plantToType.plantID WHERE plantToType.typeID=$typeID");
                
                echo "<div class='entry-wrapper'>";
                while($row = $result->fetch_assoc()){
                    echo "<div class='entry'>";
                    echo "<img src='images/".$row['fileName']."' alt='images/".$row['plantName']."'>";
                    echo '<a href="indivPlant.php?id='.$row['plantID'].'"><h4>'. $row['plantName']."</h4></a>";
                    echo "</div>";
                }
                
                echo "</div>";
                
            } else if (isset($_POST['searchby'])&&($_POST['searchby']!='None')){
                
                $typeid=$_POST['searchby'];
                
                $title = $mysqli->query("SELECT typeName FROM types WHERE typeID=$typeid");
                while($row = $title->fetch_assoc()){
                    print("<h2>$row[typeName]</h2>");
                }
                
                 $alltypes = $mysqli->query("SELECT * FROM types");
                
                print("<div class='sort'>");
                    print("<form method='POST'>");
                        print("Show: <select name='searchby'>");
                            print("<option value='None'>All Plants</option>");
                        while($row = $alltypes->fetch_assoc()){
                            print("<option value=$row[typeID]>$row[typeName]</option>");
                        }
                        print("</select>");
                        print("<button type='submit' class='submit-sort' name='sort' value='sort'>Sort</button>");
                    print("</form>");
                print("</div>");
                
                /*print("<h3><a href='plants.php'>Go to all plants</a></h3>");*/
                
                $result = $mysqli->query("SELECT * FROM plants INNER JOIN plantToType ON plants.plantID=plantToType.plantID WHERE plantToType.typeID=$typeid");

                
                echo "<div class='entry-wrapper'>";
                while($row = $result->fetch_assoc()){
                    echo "<div class='entry'>";
                    echo "<img src='images/".$row['fileName']."' alt='images/".$row['plantName']."'>";
                    echo '<a href="indivPlant.php?id='.$row['plantID'].'"><h4>'. $row['plantName']."</h4></a>";
                    echo "</div>";
                }
                
                echo "</div>";
                
            } else {
                print("<h2>All Plants</h2>");
                
                $alltypes = $mysqli->query("SELECT * FROM types");
        
                print("<div class='sort'>");
                    print("<form method='POST'>");
                        print("Show: <select name='searchby'>");
                            print("<option value='None'>All Plants</option>");
                        while($row = $alltypes->fetch_assoc()){
                            print("<option value=$row[typeID]>$row[typeName]</option>");
                        }
                        print("</select>");
                        print("<button type='submit' class='submit-sort' name='sort' value='sort'>Sort</button>");
                    print("</form>");
                print("</div>");
                    
          
                $result = $mysqli->query("SELECT * FROM plants");
                echo "<div class='entry-wrapper'>";
                while($row = $result->fetch_assoc()){
                    echo "<div class='entry'>";
                    echo "<img src='images/".$row['fileName']."' alt='images/".$row['plantName']."'>";
                    echo '<a href="indivPlant.php?id='.$row['plantID'].'"><h4>'. $row['plantName']."</h4></a>";
                    echo "</div>";
                }
                echo "</div>";
            
            }
                
                
        ?>
        <?php
        include 'nav.php';
        include 'php/login.php';
        include 'php/logout.php';
        include 'php/newPlant.php';
        ?>
    </body>
</html>
