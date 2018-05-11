<div class="new-type-form form-screen pop-up">
  <button class="close-pop-up"><span class="icon-x"></span></button>
  <form action="" method="post" enctype='multipart/form-data'>
      <h1>Add New Plant Type</h1>
      <div class="form-content">
        <div class="box">
          <input type="file" name="newTypeFile" id="file" class="inputfile" required>
          <label for="file">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
              <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z" /> </svg> <span>Choose a file&hellip;</span> </label>
        </div>
        <input type = "text" name = "name" placeholder="Type Name*" required>
      </div>
      <button type="submit" class="submit" name="submit" value="submit">Add New Type</button>
  </form>
</div>

<?php 
    
    require_once 'config-db.php';

    if ( !empty($_POST["name"]) && !empty($_FILES["newTypeFile"]) ){
        
        $newType = $_POST["name"];
        
        if (!empty($_FILES['newTypeFile'])) {
    
                $newPhoto = $_FILES['newTypeFile'];
                $originalName = $newPhoto['name'];
                if ( $newPhoto['error'] == 0 ) {
                
                    $tempName = $newPhoto['tmp_name'];
                    move_uploaded_file( $tempName, "images/$originalName");
                    $_SESSION['photos'][] = $originalName;
                    
                    
                    $statement = "INSERT INTO types(typeName, fileName) VALUES ('$newType', '$originalName')";
            
                    $result = $mysqli->query($statement);

                    /*if($result){
                        echo "<script type='text/javascript'>showTypeConfirm();</script>";
                    }
                }
            }
    } else {
        echo "<script type='text/javascript>showTypeFail();</script>"; */
    }
        }
    }



?>

<div class="new-type-complete pop-up">
    <?php echo"<h1>$newType has been added successfully</h1>"; ?>
    <a href='index.php'>Please click here to view</a>
</div>

<div class="new-type-failed pop-up">
    <button class="close-pop-up"><span class="icon-x"></span></button>
    <h1>ERROR</h1>
    <?php echo"<p>Sorry, $newName could not be added</p>"; ?>
    <a href='index.php'>Please try again</a>
</div>
      
      
          