<!DOCTYPE html>
<?PHP
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
    header("Location: index.php");
} else {
    $sesiune = $_SESSION['login'];
    $nume = $_COOKIE['nume'];
    $prenume = $_COOKIE['prenume'];
    ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width">
            <title>Secret Santa - Shout Board</title>
            <link rel="shortcut icon" type="image/x-icon" href="css/images/favicon.png" />
            <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
            <link href="css/shoutbox.css" rel="stylesheet" type="text/css"/>

            
            <script src="js/jquery-2.1.1.js" type="text/javascript"></script>
            <script src="js/jquery.flexslider-min.js" type="text/javascript"></script>
            <script src="js/script.js" type="text/javascript"></script>
            <script src="js/snow.js" type="text/javascript"></script>
            <script src="js/shoutbox.js" type="text/javascript"></script>
        </head>

        <body>
            <!--wrapper-->
            <div id="wrapper">
                <!--outer shell-->
                <div id="shell">
                    <!--container-->
                    <div id="container">
                        <!-- header -->
                        <header class="header">
                            <nav id="navigation">
                                <ul>
                                    <li><a href="main.php">Home</a></li>
                                    <li><a id="profile" href="profile.php">Profile</a></li>
                                    <li class="active"><a href="shoutbox.php">Shout Board</a></li>
                                    <li id="games">
                                        <a href="#">Games<span></span></a>
                                        <ul id="gamelist">
                                            <li><a href="whist.php">Whist<sup style="font-size: 7px;color:red;font-weight: bold;">(BETA)</sup></a></li>
                                            <li><a href="rentz.php">Rentz</a></li>
                                            <li><a href="yams.php">Yams</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                            <div id="userBox" class="userbox">
                                <ul>
                                    <li><?php echo "<b>Logged in as:</b> <i>".$nume . " " . $prenume."</i>"; ?></li>
                                    <li id="last"><a href="index.php"><img src="css/images/exit_btn.jpg" title="Log out"></a></li>
                                </ul>
                            </div>


                            <div class="cl">&nbsp;</div>
                        </header>
                        <!-- end of header -->

                        <!--main content-->
                        <div id="main">
                            <div class="cl">&nbsp;</div>
                            <div id="shoutbox">
                                <div class="block_main">
                                    <h2>Shoutbox</h2><br>
                                    <span class='adminMsg'>Shouting as :  </span><span id="name"><?php echo $prenume ?></span><br><br>

                                    <form method="post" action="shout.php">
                                        <span class='adminMsg'>Message: </span><br><textarea id="message"></textarea>
                                        <br><input type="submit" id="submit" value="SHOUT" />
                                    </form>
                                    <hr>

                                    <div id="shout"></div>
                                </div>
                            </div>


                        </div>
                        <!--end of main content-->
                    </div>
                    <!--end of container-->

                    <!--footer-->
                    <div class="footer">
                        <p class="copy">Copyright &copy; 2014 All Rights Reserved. Design by <a href="http://secaradragos.com" target="_blank" >Secara Dragos Florian</a> </p>
                    </div>
                    <!--end of footer-->
                </div>
                <!--end of outer shell-->
            </div>
            <!--end of wrapper-->
			
        </body>
    </html>
<?php } ?>
