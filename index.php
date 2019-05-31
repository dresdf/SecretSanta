<!DOCTYPE html>
<?PHP
session_start();
session_destroy();

//unset name cookies if they exist  
unset($_COOKIE['nume']);
setcookie('nume', '', time() - 3600); // empty value and old timestamp
unset($_COOKIE['prenume']);
setcookie('prenume', '', time() - 3600); // empty value and old timestamp
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <title>Secret Santa - Login</title>
        <link rel="shortcut icon" type="image/x-icon" href="css/images/favicon.png" />
        <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
        <link href="css/login.css" rel="stylesheet" type="text/css" media="all"/>

        <script src="js/jquery-2.1.1.js" type="text/javascript"></script>
        <script src="js/snow.js" type="text/javascript"></script>
        <script src="js/script.js" type="text/javascript"></script>
    </head>

    <body>
        
        <!--wrapper-->
        <div id="wrapper">
            <!--outer shell-->
            <div id="shell">
                <!--container-->
                <div id="container">
                    <!--main content-->
                    <div id="main">
                        <!-- Log In Form -->
                        <section class="services">
                            <div class="cl">&nbsp;</div>
                            <form class="loginForm" name="form1" method="post" action="checkLogin.php">
                                <p><span>Username:</span><br>
                                    <input name="myusername" id="myusername" type="text" autocomplete="off" value="<?php
                                if (isset($_COOKIE['remember_user'])) {
                                    echo $_COOKIE['remember_user'];
                                } else {
                                    echo '';
                                }
                                ?>"><br></p>
                                <p><span>Password:</span><br>
                                    <input name="mypassword" id="mypassword" type="password" value="<?php
                                    if (isset($_COOKIE['remember_password'])) {
                                        echo $_COOKIE['remember_password'];
                                    } else {
                                        echo '';
                                    }
                                ?>" ><br></p><br>
                                <div><input type="checkbox" name="remember"  <?php
                                    if (isset($_COOKIE['remember_password']) && isset($_COOKIE['remember_user'])) {
                                        echo 'checked="checked"';
                                    } else {
                                        echo '';
                                    }
                                ?>><span>Remember Me</span></div><br><br>
                                <input type="submit" name="Submit" value="Login" class="loginBtn">
                            </form>
                        </section>
                        <!-- end of Log In Form -->

                    </div>
                    <!--end of main content-->
                </div>
                <!--end of container-->
            </div>
            <!--end of outer shell-->
        </div>
        <!--end of wrapper-->
    
		
    </body>
    
</html>
