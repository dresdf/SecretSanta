<!DOCTYPE html>
<?PHP
include 'dbUtil.php';
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
    header("Location: index.php");
} else {
    $sesiune = $_SESSION['login'];
    $user = $_COOKIE['username'];
    $parola = $_COOKIE['password'];
    $nume = $_COOKIE['nume'];
    $prenume = $_COOKIE['prenume'];
    if (isset($_COOKIE['profilepic'])) {
        $profilepic = $_COOKIE['profilepic'];
    } else {
        $profilepic = "";
    }
    if (isset($_COOKIE['wishlist'])) {
        $wishlist = $_COOKIE['wishlist'];
    } else {
        $wishlist = "";
    }


    //temporary friend details
    $friendNume = "";
    $friendPrenume = "N/A";
    $friendProfilepic = "css/images/no-image.jpg";
    $friendWishlist = "Vreau eu ceva, dar nu spun inca.";
    $friend = $_COOKIE['friend'];


    if (isset($_COOKIE['friend'])) {
        $friend = $_COOKIE['friend'];

        $sql = "SELECT * FROM  $tableName  WHERE Prenume ='$friend'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $friendNume = $row['Nume'];
        $friendPrenume = $row['Prenume'];
        if (!empty($row['Profilepic'])) {
            $friendProfilepic = $row['Profilepic'];
        }
        if (!empty($row['Wishlist'])) {
            $friendWishlist = stripslashes($row['Wishlist']);
        }
    }

    function hideBtn() {
        if ($_SESSION['login'] == 'admin') {
            if (isset($_COOKIE['friend'])) {
                echo 'style="visibility:visible;" disabled';
            } else {
                echo 'style="visibility:visible;"';
            }
        } else {
            echo 'style="visibility:hidden;"';
        }
    }
    ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width">
            <title>Secret Santa - Profile</title>
            <link rel="shortcut icon" type="image/x-icon" href="css/images/favicon.png" />
            <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
            <link href="css/profile.css" rel="stylesheet" type="text/css"/>

            <script src="js/jquery-2.1.1.js" type="text/javascript"></script>
            <script src="js/script.js" type="text/javascript"></script>
            <script src="js/snow.js" type="text/javascript"></script>
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
                                    <li class="active" ><a href="profile.php">Profile</a></li>
                                    <li><a href="shoutbox.php">Shout Board</a></li>
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
                                    <li><?php echo "<b>Logged in as:</b> <i>" . $nume . " " . $prenume . "</i>"; ?></li>
                                    <li id="last"><a href="index.php"><img src="css/images/exit_btn.jpg" title="Log out"></a></li>
                                </ul>
                            </div>

                            <div class="cl">&nbsp;</div>
                        </header>
                        <!-- end of header -->


                        <!--main content-->
                        <div id="main">
                            <div class="profile_divider"></div>

                            <!-- personal -->
                            <section class="row" >
                                <div class="profilePic">
                                    <img src="<?php echo $profilepic ?>" alt="">
                                </div>

                                <div class="details">
                                    <div style="float:left; padding-right: 10px;">
                                        <h3><?php echo $prenume . " " . $nume; ?></h3>
                                        <span>Username:</span><br> 
                                        <input id="profileUsername" type="text" value="<?php echo $user ?>"><br>
                                        <span>Password:</span><br> 
                                        <input id="profilePassword" type="password" value="<?php echo $parola ?>"><br>
                                        <input id="updateBtn" class="btn" type="button" value="Update"><br>
                                        <input id="santaScriptBtn" class="btn" type="button" value="Santa Script" <?php hideBtn(); ?>>
                                    </div>
                                    <div style="float:right; padding-right: 10px;">
                                        <textarea id="wishlist-input"><?php echo $wishlist; ?></textarea>
                                        <br><input id="saveWishlistBtn" class="btn" type="button" value="Save Wishlist" >
                                    </div>
                                </div>
                                <div class="cl">&nbsp;</div>
                            </section>
                            <!-- end of personal  -->

                            <div class="profile_divider"></div>

                            <!-- secret friend -->
                            <section class="row" >
                                <h2>Secret Friend : </h2><br>
                                <div class="profilePic">
                                    <img src="<?php echo $friendProfilepic; ?>" alt="">
                                </div>

                                <div class="details">
                                    <h3><?php echo $friendPrenume . " " . $friendNume; ?></h3>
                                    <div>
                                        <h3><u>Wishlist</u></h3>
                                    </div>

                                    <div class="wishlist-content"><?php echo $friendWishlist; ?></div>

                                </div>
                                <div class="cl">&nbsp;</div>
                            </section>
                            <!-- end of secret friend  -->
                            <div class="profile_divider"></div>


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
