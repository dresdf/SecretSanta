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

    //get data from whist_game table
    $gameDataArray = readGameData($con, $owner);
    $players = checkArray($gameDataArray, 'players');
    $prizeThreshold = checkArray($gameDataArray, 'prizeThreshold');
    $prizeAmount = checkArray($gameDataArray, 'prizeAmount');
    $handValue = checkArray($gameDataArray, 'handValue');
    $zeroWin = checkArray($gameDataArray, 'zeroWin');
    $nvGame = checkArray($gameDataArray, 'nvGame');
    $gameTable = checkArray($gameDataArray, 'gameTable');
    $handState = checkArray($gameDataArray, 'handState');

    $player1Name = checkArray($gameDataArray, 'p1name');
    $player2Name = checkArray($gameDataArray, 'p2name');
    $player3Name = checkArray($gameDataArray, 'p3name');
    $player4Name = checkArray($gameDataArray, 'p4name');
    $player5Name = checkArray($gameDataArray, 'p5name');
    $player6Name = checkArray($gameDataArray, 'p6name');
    ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width">
            <title>Secret Santa - Whist</title>
            <link rel="shortcut icon" type="image/x-icon" href="css/images/favicon.png"/>
            <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
            <link href="css/whist.css" rel="stylesheet" type="text/css"/>
            <link href="css/sweet-alert.css" rel="stylesheet" type="text/css"/>
            
            <script src="js/jquery-2.1.1.js" type="text/javascript"></script>
            <script src="js/jquery.flexslider-min.js" type="text/javascript"></script>
            <script src="js/script.js" type="text/javascript"></script>
            <script src="js/whist.js" type="text/javascript"></script>
            <script src="js/snow.js" type="text/javascript"></script>
            <script src="js/sweet-alert.min.js" type="text/javascript"></script>
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
                                            <li><a href="whist.php">Whist<sup style="font-size: 8px;color:red;font-weight: bold;">(BETA)</sup></a></li>
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
                            <div id="helper_div" class="hidden">
                                <span id="owner_span"><?php echo $owner; ?></span>
                                <span id="player_span"><?php echo $players; ?></span>
                                <span id="prizeThreshold_span"><?php echo $prizeThreshold; ?></span>
                                <span id="prizeAmount_span"><?php echo $prizeAmount; ?></span>
                                <span id="handValue_span"><?php echo $handValue; ?></span>
                                <span id="zeroWin_span"><?php echo $zeroWin; ?></span>
                                <span id="gameTable_span"><?php echo $gameTable; ?></span>
                                <span id="player1Name_span"><?php echo $player1Name; ?></span>
                                <span id="player2Name_span"><?php echo $player2Name; ?></span>
                                <span id="player3Name_span"><?php echo $player3Name; ?></span>
                                <span id="player4Name_span"><?php echo $player4Name; ?></span>
                                <span id="player5Name_span"><?php echo $player5Name; ?></span>
                                <span id="player6Name_span"><?php echo $player6Name; ?></span>
                            </div>
                            <div id="whist_content">

                                <table id="whist_scoresheet">
                                    <?php
                                    displayGame($players, $con, $gameTable, $player1Name, $player2Name, $player3Name, $player4Name, $player5Name, $player6Name);
                                    ?>
                                </table>
                            <br>
                            <input class='btn' id='exit_game' type='button' value='Exit Game'>

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
