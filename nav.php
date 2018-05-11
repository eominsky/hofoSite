<div class='navbar'>
    <ul>
        <li><a href='index.php'>Home</a></li>
        <li><a href='about.php'>About</a></li>
        <li><a href='contact.php'>Contact Us</a></li>
        <li><a href='events.php'>Events</a></li>
        <li><a href='plants.php'>Plants</a></li>
        <li>
            <?php
              if(isset($_SESSION['logged_user'])){
                echo "<a href='' class='show-logout'>Logout</a>";
              }else{
                echo "<a href='' class='show-login'>Login</a>";
              }
            ?>
        </li>
     </ul>
</div>
