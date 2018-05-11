<?php include 'config.php'; ?>
        <link rel="stylesheet" type="text/css" href="css/events.css">
        <!--moment.js-->
        <script type="text/javascript" src="js/moment.js"></script>
        <title>Events</title>
    </head>
    <body>
      <header>
        <h1>Events</h1>
          <?php
            if(isset($_SESSION['logged_user'])) {
              echo "<button class='add-event'><span class='icon-plus'></span></button>";
            }
          ?>
      </header>
      <div class="events">
      <?php
        require_once 'config-db.php';
        $query = 'SELECT * FROM events;';
        $stmt = $db->prepare($query);
        $executed = $stmt->execute();

        if(!$executed){
          echo "SQL query $query not executed";
          exit();
        }

        if($row =  $stmt->fetch(PDO::FETCH_ASSOC)){
          printEvent($row);
        }

        while($row =  $stmt->fetch(PDO::FETCH_ASSOC)){
          echo "<div class='seperator'></div>";
          printEvent($row);
        }

      function printEvent($row){
        $id = $row['id'];
        $title = $row['title'];
        $start_date = $row['start_date'];
        $start_time = $row['start_time'];
        $end_date = $row['end_date'];
        $end_time = $row['end_time'];
        $place = $row['place'];
        $file_path = $row['file_path'];
        $file_name = $row['file_name'];
        $description = $row['description'];
        echo "<div id='$id' class='event'>";
        echo  "<h2>$title</h2>";
        if(isset($_SESSION['logged_user'])) {
            echo "<button class='delete-event'><span class='icon-garbage'></span></button>";
            echo "<button class='edit-event'><span class='icon-edit'></span></button>";
        }
        $time_place_str = "$start_date $start_time";
        if(!empty($end_date) || !empty($end_time)){
          $time_place_str .= " to";
          if(!empty($end_date)){
            if($end_date !== $start_date){
              $time_place_str .= " $end_date";
            }
          }
          if(!empty($end_time)){
            $time_place_str .= " $end_time";
          }
        }
        if(!empty($place)){
          $time_place_str .= " | $place";
        }
        echo "<h3>$time_place_str</h3>";
        echo "<p>$description</p>";
        if(!empty($row['file_path']) && !empty($row['file_name'])){
          echo "<img src='".$file_path.$file_name."'>";
        }
        echo "</div>";
      }
      ?>
      </div>
      <?php
        include 'nav.php';
        include 'php/login.php';
        include 'php/logout.php';
        include 'php/event-form.php';
      ?>
    </body>
</html>
