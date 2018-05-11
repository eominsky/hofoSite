<?php include 'config.php'; ?>
        <link rel="stylesheet" type ="text/css" href="css/contact.css">
        <title>Contact</title>

    </head>

    <body>
        <h1>Contact Us</h1>

        <h2>Send a Message to the Horticulture Club</h2>

        <div class='contact-container'>

        <div class='contact form-screen'>
                <form method='post' name='contact-club'>
                    Your Name: <input type='text' name='name' size='40' placeholder='Your Name*' required>
                    Your Email: <input type='email' name='email' size-'40' placeholder='email@cornell.edu*' required>
                    Subject: <input type='text' name='subject' size='40' placeholder='message subject'>
                    Message: <textarea rows="7" cols="50" name='message' placeholder="Write your message here!*" required></textarea><br>
                    Add me to the list-serve <input type='checkbox' name='listserve' value='yes'><br><br>
                    <button type="submit" class="submit send-email" name="send" value="send email">Send</button>
                    <p>*required field</p>
                </form>
        </div>

        <div class='contact'>
            <img id='contactpage' src='images/contactpage.jpg' width='450'>
        </div>

        </div>

        <div class="pop-up sent">
            <button class="close-pop-up"><span class="icon-x"></span></button>
            <h1>Your Message Has Been Sent</h1>
            <p>Thank you for contacting the Horticulture Club.</p>
            <p>If you had any questions, we will get back to you as soon as possible.</p>
        </div>

        <div class="pop-up not-sent">
            <button class="close-pop-up"><span class="icon-x"></span></button>
            <h1>Error: Sorry, Your message wasn't sent</h1>
            <p>Something went wrong.</p>
            <p>Please fill out the all the required forms and try again.</p>
        </div>
        <?php
          include 'nav.php';
          include 'php/login.php';
          include 'php/logout.php';
        ?>
    </body>
</html>
