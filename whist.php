<!DOCTYPE html>
<?PHP
include 'dbUtil.php';
include 'whistFunctions.php';

session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
    header("Location: index.php");
} else {
    $sesiune = $_SESSION['login'];
    $nume = $_COOKIE['nume'];
    $prenume = $_COOKIE['prenume'];
    $owner = $prenume;

    //check if another unfinished game exists
    $sql = "SELECT * FROM whist_games WHERE owner='$owner' AND gameState='ongoing'";
    $result = mysqli_query($con, $sql);
    $count = mysqli_num_rows($result);
    if ($count === 1) {
        header("Location:gameWhist.php");
    }
    ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width">
            <title>Secret Santa - Whist</title>
            <link rel="shortcut icon" type="image/x-icon" href="css/images/favicon.png"/>
            <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
            <link href="css/whist.css" rel="stylesheet" type="text/css"/>

            <script src="js/jquery-2.1.1.js" type="text/javascript"></script>
            <script src="js/jquery.flexslider-min.js" type="text/javascript"></script>
            <script src="js/script.js" type="text/javascript"></script>
            <script src="js/snow.js" type="text/javascript"></script>
            <script src="js/whist.js" type="text/javascript"></script>
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
                                    <li><a href="shoutbox.php">Shout Board</a></li>
                                    <li id="games" class="active">
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
                            <div id="whist_form">
                                <span id="owner_span" class="hidden"><?php echo $owner ?></span>
                                <!--select number of players-->
                                <label for="playerNumber">Numar de jucatori :</label>
                                <select id="playerNumber" name="playerNumber">
                                    <option value="" selected disabled>Select..</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>
                                <br>

                                <!--player names-->
                                <div id="playerNamesWrapper">
                                    <input id="player1" name="player1" type="text" placeholder="" class="playerName" disabled>
                                    <input id="player2" name="player2" type="text" placeholder="" class="playerName" disabled>
                                    <input id="player3" name="player3" type="text" placeholder="" class="playerName" disabled>
                                    <input id="player4" name="player4" type="text" placeholder="" class="playerName" disabled>
                                    <input id="player5" name="player5" type="text" placeholder="" class="playerName" disabled>
                                    <input id="player6" name="player6" type="text" placeholder="" class="playerName" disabled>
                                </div>


                                <label for="zeroWinSelector">Joc la 0 :</label>
                                <select id="zeroWinSelector" name="zeroWinSelector">
                                    <option value="false" selected>No</option>
                                    <option value="true">Yes</option>
                                </select>
                                <br><br>

                                <label for="nvGameSelector">Joc la NeVe (jocuri de 1 si de 8) :</label>
                                <select id="nvGameSelector" name="nvGameSelector">
                                    <option value="false" selected>No</option>
                                    <option value="true">Yes</option>
                                </select>
                                <br><br>


                                <label for="handValueInput">Punctaj de baza:</label>
                                <input id='handValueInput' name='handValueInput' type="text" value="5" size="1" class="addForm">
                                <br><br>

                                <label for="prizeThresholdInput">Premiere la:</label>
                                <input id="prizeThresholdInput" name="prizeThresholdInput" type="text" value="5" size="1" class="addForm">
                                <label for="prizeThresholdInput">jocuri.</label>
                                <br><br>

                                <label for="prizeAmountInput">Valoare premiere: </label>
                                <input id="prizeAmountInput" name="prizeAmountInput" type="text" value="5" size="1" class="addForm">

                                <br><br>
                                <input id='startJocButton' name='startJocButton' type='button' value="Start Joc" class="btn">
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
