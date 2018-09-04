<?php
  session_start();
?>


<!DOCTYPE html>


<html>

    <head>
        <meta charset="UTF-8">
            <title>SAD</title>    
        <link rel="stylesheet" href="css/login.css">    
    </head>

    <body>

        <hgroup>
            <h1>Student Analysis and Development</h1>
        </hgroup>

        <form action = "" method="POST">

            <div class="group">
                <input type="text" name="f_UserName"><span class="highlight"></span><span class="bar"></span>
                <label>username</label>
            </div>

            <div class="group">
                <input type="Password" name="f_Password"><span class="highlight"></span><span class="bar"></span>
                <label>Password</label>
            </div>

            <div>
                <?php
                    if (isset($_POST['login']))
                    {
                        $userName = $_POST['f_UserName'];
                        $password = $_POST['f_Password'];
                        include "backend/b_Login_Login.php";
                    }
                ?>
            </div>

            <div>
                <button type="submit" type="button" class="button buttonBlue" id = "login" name="login">Login
                    <div class="ripples buttonRipples">
                        <span class="ripplesCircle"></span>
                    </div>
                </button>
            </div>

        </form>

        <!--Footer-->
        <footer>
            <a href="http://www.krumbs.ph/" target="_blank">
                <img src="http://www.krumbs.ph/krumbsdesign_files/Krumbs-Logo.png">
            </a>
        </footer>

        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script src="js/login.js"></script>

    </body>

    
</html>
