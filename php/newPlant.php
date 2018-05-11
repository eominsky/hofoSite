<div class="new-plant-form form-screen pop-up">
  <button class="close-pop-up"><span class="icon-x"></span></button>
  <form action="" method="post" enctype="multipart/form-data">
      <h1>Add New Plant</h1>
      <div class="form-content">
        <div class="box">
          <input type="file" name="new_file" id="file" class="inputfile" data-multiple-caption="{count} files selected" multiple />
          <label for="file">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
              <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z" /> </svg> <span>Choose a photo&hellip;</span> </label>
        </div>
        <input type="text" name="pName" placeholder="Plant name*" required>
        <input type="text" name="sName" placeholder="Scientific Name">
        <input type="text" name="careI" placeholder="Care instructions*" required>
        <p>What type of plant is this?:</p>
      <?php
        require_once 'config-db.php';
        $mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        $result = $mysqli->query("SELECT * FROM types");
        while ($typerow = $result->fetch_assoc()) {
            echo '<p><input type="checkbox" name="addedType[]" value="'.$typerow['typeID'].'">';
            echo $typerow['typeName'].'</p>';
        }
       ?>
      </div>
      <button type="submit" class="submit" name="plant_submit" value="submit">Add New Plant</button>
  </form>
</div>
<?php

    if (isset($_POST["plant_submit"]) && !empty($_POST["pName"]) && !empty($_POST["careI"]) && !empty($_FILES["new_file"])){
        if ( ! empty( $_FILES['new_file'] ) ) {
                $newPhoto = $_FILES['new_file'];
                $originalName = $newPhoto['name'];
                if ( $newPhoto['error'] == 0 ) {
                    $tempName = $newPhoto['tmp_name'];
                    move_uploaded_file( $tempName, "images/$originalName");
                    $_SESSION['photos'][] = $originalName;
                    print("<p>The file $originalName was uploaded successfully.</p>");
                }
        }

        $vPlant = $_POST["pName"];
        if (!empty($_POST["sName"])){
            $vScience = $_POST["sName"];
        } else{
            $vScience = "";
        }

        $newPhoto = $_FILES['new_file'];
        $originalName = $newPhoto['name'];
        $vCare = $_POST["careI"];

        if (isset($_POST["addedType"])){
            $statement1 = "INSERT INTO plants(plantName, scientificName, careInstructions, fileName)

            VALUES ('$vPlant', '$vScience', '$vCare', '$originalName')";
                $result = $mysqli->query($statement1);

                $result = $mysqli->query("SELECT MAX(plantID) from plants");

                $row = $result->fetch_row();
                $pid = $row[0];
                $vTypes = $_POST["addedType"];

                foreach ($vTypes as $typeIndex){

                    $statement2 = "INSERT INTO plantToType( plantID, typeID)
                        VALUES ('$pid', '$typeIndex')";
                    $result = $mysqli->query($statement2);
                }
        }else{
            $statement = "INSERT INTO plants(plantName, scientificName, careInstructions, fileName)
             VALUES ('$vPlant', '$vScience', '$vCare', '$originalName')";
            $result = $mysqli->query($statement);
        }

}
?>
