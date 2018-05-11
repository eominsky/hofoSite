<?php include 'config.php'; ?>
        <link rel="stylesheet" type="text/css" href="css/about.css">
        <title>About</title>
    </head>
    <body>
        <h1>About Us</h1>

        <h2>Hortus Forum</h2>
        <div class='bio'>
            <img src='images/aboutpage.jpg' height='500'><br>
            <p>We meet on Wednesdays at 4:40pm in Plant Science room G22, and we hold plant sales on most Fridays all across campus but most frequently at Mann Library Lobby. Come stop by!</p>
            <p>"What is Hortus Forum?" you may ask... Hortus Forum is Cornell’s horticulture club. </p>
            <p>We grow a wide variety of houseplants on campus in the Kenneth Post Lab greenhouses. We hold weekly plant sales to maintain      greenhouse costs, fund educational horticulture trips, service projects, and community social events. Past trips have been to Costa Rica, Longwood garden, Puerto Rico, Holland, and Florida. We also hold a variety of social events during the year with other interests groups.
            </p>
        </div>

        <div class="memberhead">
            <h3>Meet the Members</h3>
        <?php
            if (isset($_SESSION['logged_user'])){
                print("<button class='new-member'><span class='icon-plus'></span></button>");
            }
        ?>
        </div>
        <?php
            require_once 'config-db.php';
            $members=$mysqli->query("SELECT * FROM members");
            
            echo "<div class='member-wrapper'>";
             while ($row=$members->fetch_assoc()){
                print("<div class='members'><img src='images/members/$row[fileName]' alt='memberimg' height='200'><p><b><u>$row[memberName]</u></b><br>$row[memberRole]<br>$row[roleDescription]<br><i>$row[email]</i></p>");
                print("</div>");
            }
            echo "</div>";
        ?>
        <?php
          include 'nav.php';
          include 'php/login.php';
          include 'php/logout.php';
          include 'php/newmember.php';
        ?>
    </body>
</html>
