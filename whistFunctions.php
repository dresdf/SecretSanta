<?php

//function to check if the user has another unfinished game
function checkIfOpenGame($con, $owner) {
    $sql = "SELECT * FROM whist_games WHERE owner='$owner' AND gameState='ongoing'";
    $result = mysqli_query($con, $sql);
    $count = mysqli_num_rows($result);
    if ($count === 1) {
        return true;
        //TODO: get table information for continuing the game
    } else {
        return false;
    }
}

//function to insert new game into whist_games table
//player names 4-6 have null as default to shorten the code
function insertNewGame($con, $owner, $players, $prizeThreshold, $prizeAmount, $handValue, $zeroWin, $nvGame, $gameTable, $p1name, $p2name, $p3name = NULL, $p4name = NULL, $p5name = NULL, $p6name = NULL) {
    $sql = "INSERT INTO whist_games (owner, players, prizeThreshold, prizeAmount, handValue, zeroWin, nvGame, gameState, gameTable, p1name, p2name, p3name, p4name, p5name, p6name)" .
            " VALUES ('$owner', '$players', '$prizeThreshold', '$prizeAmount', '$handValue', '$zeroWin', '$nvGame', 'ongoing', '$gameTable', '$p1name', '$p2name', '$p3name', '$p4name', '$p5name', '$p6name')";

    $result = mysqli_query($con, $sql);
    if ($result) {
        return TRUE;
    } else {
        return FALSE;
    }
}

//function for deleting temporary game tables
function dropTable($con, $gameTable) {
    $sql = 'DROP TABLE IF EXISTS ' . $gameTable;
    mysqli_query($con, $sql);
    $sql1 = "UPDATE whist_games SET gameState = 'finished', p1total = '$p1score', p2total = '$p2score' WHERE owner = '$owner' AND gameState = 'ongoing'";
    mysqli_query($con, $sql);
}

//function to delete game table and set gameState to canceled for a dropped game
//used for the "exit game" button dialog
function exitGame($con, $gameTable, $owner) {
    $sql = 'DROP TABLE IF EXISTS ' . $gameTable;
    mysqli_query($con, $sql);
    $sql1 = "UPDATE whist_games SET gameState = 'canceled' WHERE owner = '$owner' AND gameTable= '$gameTable' AND gameState = 'ongoing'";
    mysqli_query($con, $sql1);
}

//function to create temporary table for game
function createWhistTable($con, $players, $gameTable) {

    //create sql statement based on the number of players
    switch ($players) {
        case 2:
            $sql = 'CREATE TABLE IF NOT EXISTS ' . $gameTable .
                    '(
    id INT(10) NOT NULL AUTO_INCREMENT,
    currentHand INT(10),
    handState VARCHAR(200),
    owner VARCHAR(100) NOT NULL,
    p1bet INT(10),p1done INT(10),p1score INT(10),p1prize INT(10),
    p2bet INT(10),p2done INT(10),p2score INT(10),p2prize INT(10),
    PRIMARY KEY(id)
)';
            break;
        case 3:
            $sql = 'CREATE TABLE IF NOT EXISTS ' . $gameTable .
                    '(
    id INT(10) NOT NULL AUTO_INCREMENT,
    currentHand INT(10),
    handState VARCHAR(200),
    owner VARCHAR(100) NOT NULL,
    p1bet INT(10),p1done INT(10),p1score INT(10),p1prize INT(10),
    p2bet INT(10),p2done INT(10),p2score INT(10),p2prize INT(10),
    p3bet INT(10),p3done INT(10),p3score INT(10),p3prize INT(10),
    PRIMARY KEY(id)
)';
            break;
        case 4:
            $sql = 'CREATE TABLE IF NOT EXISTS ' . $gameTable .
                    '(
    id INT(10) NOT NULL AUTO_INCREMENT,
    currentHand INT(10),
    handState VARCHAR(200),
    owner VARCHAR(100) NOT NULL,
    p1bet INT(10),p1done INT(10),p1score INT(10),p1prize INT(10),
    p2bet INT(10),p2done INT(10),p2score INT(10),p2prize INT(10),
    p3bet INT(10),p3done INT(10),p3score INT(10),p3prize INT(10),
    p4bet INT(10),p4done INT(10),p4score INT(10),p4prize INT(10),
    PRIMARY KEY(id)
)';
            break;
        case 5:
            $sql = 'CREATE TABLE IF NOT EXISTS ' . $gameTable .
                    '(
    id INT(10) NOT NULL AUTO_INCREMENT,
    currentHand INT(10),
    handState VARCHAR(200),
    owner VARCHAR(100) NOT NULL,
    p1bet INT(10),p1done INT(10),p1score INT(10),p1prize INT(10),
    p2bet INT(10),p2done INT(10),p2score INT(10),p2prize INT(10),
    p3bet INT(10),p3done INT(10),p3score INT(10),p3prize INT(10),
    p4bet INT(10),p4done INT(10),p4score INT(10),p4prize INT(10),
    p5bet INT(10),p5done INT(10),p5score INT(10),p5prize INT(10),
    PRIMARY KEY(id)
)';
            break;
        case 6:
            $sql = 'CREATE TABLE IF NOT EXISTS ' . $gameTable .
                    '(
    id INT(10) NOT NULL AUTO_INCREMENT,
    currentHand INT(10),
    handState VARCHAR(200),
    owner VARCHAR(100) NOT NULL,
    p1bet INT(10),p1done INT(10),p1score INT(10),p1prize INT(10),
    p2bet INT(10),p2done INT(10),p2score INT(10),p2prize INT(10),
    p3bet INT(10),p3done INT(10),p3score INT(10),p3prize INT(10),
    p4bet INT(10),p4done INT(10),p4score INT(10),p4prize INT(10),
    p5bet INT(10),p5done INT(10),p5score INT(10),p5prize INT(10),
    p6bet INT(10),p6done INT(10),p6score INT(10),p6prize INT(10),
    PRIMARY KEY(id)
)';
            break;
    }

    //run query
    $result = mysqli_query($con, $sql);

    return $result;
}

//function to populate the temporary game table
function insertDefaultValues($con, $players, $gameTable, $owner) {
    //insert 1 
    $count = 0;
    while ($count < $players) {
        $sql = "INSERT into $gameTable (currentHand, handState, owner) VALUES( 1, 'inactive', '$owner')";
        $count = $count + 1;
        $result = mysqli_query($con, $sql);
    }
//insert 2-7 
    $count = 2;
    while ($count < 8) {
        $sql = "INSERT into $gameTable (currentHand, handState, owner) VALUES( '$count', 'inactive', '$owner')";
        $count = $count + 1;
        $result = mysqli_query($con, $sql);
    }
//insert 8 
    $count = 0;
    while ($count < $players) {
        $sql = "INSERT into $gameTable (currentHand, handState, owner) VALUES( 8, 'inactive', '$owner')";
        $count = $count + 1;
        $result = mysqli_query($con, $sql);
    }

//insert 7-2  	
    $count = 7;
    while ($count > 1) {
        $sql = "INSERT into $gameTable (currentHand, handState, owner) VALUES( '$count', 'inactive', '$owner')";
        $count = $count - 1;
        $result = mysqli_query($con, $sql);
    }

//insert 1 
    $count = 0;
    while ($count < $players) {
        $sql = "INSERT into $gameTable (currentHand, handState, owner) VALUES( 1, 'inactive', '$owner')";
        $count = $count + 1;
        $result = mysqli_query($con, $sql);
    }
}

//function to get data from whist_games
function readGameData($con, $owner) {
    $sql = "SELECT * FROM whist_games WHERE owner='$owner' AND gameState='ongoing'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    return $row;
}

//function to check if the array value is set before reading it
function checkArray($arr, $key) {
    if (isset($arr[$key])) {
        return $arr[$key];
    } else {
        return NULL;
    }
}

function checkPost($post) {
    if (isset($post)) {
        return $post;
    } else {
        return 'NULL';
    }
}

//display game table for play
function displayGame($players, $con, $gameTable, $player1Name, $player2Name, $player3Name = "NULL", $player4Name = "NULL", $player5Name = "NULL", $player6Name = "NULL") {
    switch ($players) {
        case 2:
            //names header
            echo "<tr id='header_names'>";
            echo "<td class='currentHandSpan'><span></span></td>";
            echo "<td colspan='3' class='playerNamesSpan'><span id='p1name'>" . $player1Name . "</span></td>";
            echo "<td colspan='3' class='playerNamesSpan'><span' id='p2name'>" . $player2Name . "</span></td>";
            echo "<td><span></span></td>";
            echo "<td class='hidden'><span></span></td>";
            echo "</tr>";

            //details header
            echo "<tr id='header_details'>
                <td class='currentHandSpan'><span>Cards</span></td>
                <td class='tableHeaderSpan'><span> Bet</span></td>
                <td class='tableHeaderSpan'><span>Done</span></td>
                <td class='tableHeaderSpan'><span>Score</span></td>
                <td class='tableHeaderSpan'><span>Bet</span></td>
                <td class='tableHeaderSpan'><span>Done</span></td>
                <td class='tableHeaderSpan'><span>Score</span></td>
                <td class='tableHeaderSpan'><span>Action</span></td>
                <td class='hidden'><span class='tableHeaderSpan'>State</span></td>
            </tr>";

            //dynamic content 
            $sql = "SELECT * FROM $gameTable";
            $result = mysqli_query($con, $sql);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $handID = checkArray($row, 'id');
                $currentHand = checkArray($row, 'currentHand');
                $handState = checkArray($row, 'handState');
                $p1bet = checkArray($row, 'p1bet');
                $p1done = checkArray($row, 'p1done');
                $p1score = checkArray($row, 'p1score');
                $p1prize = checkArray($row, 'p1prize');
                $p2bet = checkArray($row, 'p2bet');
                $p2done = checkArray($row, 'p2done');
                $p2score = checkArray($row, 'p2score');
                $p2prize = checkArray($row, 'p2prize');

                echo "<tr id='" . $handID . "'>";
                echo "<td class='currentHandSpan'><span id='hand_" . $handID . "'>" . $currentHand . "</span></td>";
                echo "<td class='inputField'><input id='p1_bet_" . $handID . "' type='number' value='" . $p1bet . "' disabled></td>";
                echo "<td class='inputField'><input id='p1_done_" . $handID . "' type='number' value='" . $p1done . "' disabled></td>";
                echo "<td class='spanField'><span id='p1_score_" . $handID . "'>" . $p1score . "</span></td>";
                echo "<td class='inputField'><input id='p2_bet_" . $handID . "' type='number' value='" . $p2bet . "' disabled></td>";
                echo "<td class='inputField'><input id='p2_done_" . $handID . "' type='number' value='" . $p2done . "' disabled></td>";
                echo "<td class='spanField'><span id='p2_score_" . $handID . "'>" . $p2score . "</span></td>";
                echo "<td><input class='rowActionButton btn' id='action_" . $handID . "' type='button' value='Bet' disabled></td>";
                echo "<td class='hidden'><span id='handState_" . $handID . "' class='spanFieldState'>" . $handState . "</span></td>";
                echo"</tr>";
            }
            break;
        case 3:
            //names header
            echo "<tr id='header_names'>";
            echo "<td class='currentHandSpan'><span></span></td>";
            echo "<td colspan='3' class='playerNamesSpan'><span id='p1name'>" . $player1Name . "</span></td>";
            echo "<td colspan='3' class='playerNamesSpan'><span' id='p2name'>" . $player2Name . "</span></td>";
            echo "<td colspan='3' class='playerNamesSpan'><span id='p3name'>" . $player3Name . "</span></td>";
            echo "<td><span></span></td>";
            echo "<td class='hidden'><span></span></td>";
            echo "</tr>";

            //details header
            echo "<tr id='header_details'>
                <td class='currentHandSpan'><span>Cards</span></td>
                <td class='tableHeaderSpan'><span> Bet</span></td>
                <td class='tableHeaderSpan'><span>Done</span></td>
                <td class='tableHeaderSpan'><span>Score</span></td>
                <td class='tableHeaderSpan'><span>Bet</span></td>
                <td class='tableHeaderSpan'><span>Done</span></td>
                <td class='tableHeaderSpan'><span>Score</span></td>
                <td class='tableHeaderSpan'><span> Bet</span></td>
                <td class='tableHeaderSpan'><span>Done</span></td>
                <td class='tableHeaderSpan'><span>Score</span></td>
                <td class='tableHeaderSpan'><span>Action</span></td>
                <td class='hidden'><span class='tableHeaderSpan'>State</span></td>
            </tr>";

            //dynamic content 
            $sql = "SELECT * FROM $gameTable";
            $result = mysqli_query($con, $sql);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $handID = checkArray($row, 'id');
                $currentHand = checkArray($row, 'currentHand');
                $handState = checkArray($row, 'handState');
                $p1bet = checkArray($row, 'p1bet');
                $p1done = checkArray($row, 'p1done');
                $p1score = checkArray($row, 'p1score');
                $p1prize = checkArray($row, 'p1prize');
                $p2bet = checkArray($row, 'p2bet');
                $p2done = checkArray($row, 'p2done');
                $p2score = checkArray($row, 'p2score');
                $p2prize = checkArray($row, 'p2prize');
                $p3bet = checkArray($row, 'p3bet');
                $p3done = checkArray($row, 'p3done');
                $p3score = checkArray($row, 'p3score');
                $p3prize = checkArray($row, 'p3prize');

                echo "<tr id='" . $handID . "'>";
                echo "<td class='currentHandSpan'><span id='hand_" . $handID . "'>" . $currentHand . "</span></td>";
                echo "<td class='inputField'><input id='p1_bet_" . $handID . "' type='number' value='" . $p1bet . "' disabled></td>";
                echo "<td class='inputField'><input id='p1_done_" . $handID . "' type='number' value='" . $p1done . "' disabled></td>";
                echo "<td class='spanField'><span id='p1_score_" . $handID . "'>" . $p1score . "</span></td>";
                echo "<td class='inputField'><input id='p2_bet_" . $handID . "' type='number' value='" . $p2bet . "' disabled></td>";
                echo "<td class='inputField'><input id='p2_done_" . $handID . "' type='number' value='" . $p2done . "' disabled></td>";
                echo "<td class='spanField'><span id='p2_score_" . $handID . "'>" . $p2score . "</span></td>";
                echo "<td class='inputField'><input id='p3_bet_" . $handID . "' type='number' value='" . $p3bet . "' disabled></td>";
                echo "<td class='inputField'><input id='p3_done_" . $handID . "' type='number' value='" . $p3done . "' disabled></td>";
                echo "<td class='spanField'><span id='p3_score_" . $handID . "'>" . $p3score . "</span></td>";
                echo "<td><input class='rowActionButton btn' id='action_" . $handID . "' type='button' value='Bet' disabled></td>";
                echo "<td class='hidden'><span id='handState_" . $handID . "' class='spanFieldState'>" . $handState . "</span></td>";
                echo"</tr>";
            }
            break;
        case 4:
            //names header
            echo "<tr id='header_names'>";
            echo "<td class='currentHandSpan'><span></span></td>";
            echo "<td colspan='3' class='playerNamesSpan'><span id='p1name'>" . $player1Name . "</span></td>";
            echo "<td colspan='3' class='playerNamesSpan'><span' id='p2name'>" . $player2Name . "</span></td>";
            echo "<td colspan='3' class='playerNamesSpan'><span id='p3name'>" . $player3Name . "</span></td>";
            echo "<td colspan='3' class='playerNamesSpan'><span id='p4name'>" . $player4Name . "</span></td>";
            echo "<td><span></span></td>";
            echo "<td class='hidden'><span></span></td>";
            echo "</tr>";

            //details header
            echo "<tr id='header_details'>
                <td class='currentHandSpan'><span>Cards</span></td>
                <td class='tableHeaderSpan'><span> Bet</span></td>
                <td class='tableHeaderSpan'><span>Done</span></td>
                <td class='tableHeaderSpan'><span>Score</span></td>
                <td class='tableHeaderSpan'><span>Bet</span></td>
                <td class='tableHeaderSpan'><span>Done</span></td>
                <td class='tableHeaderSpan'><span>Score</span></td>
                <td class='tableHeaderSpan'><span> Bet</span></td>
                <td class='tableHeaderSpan'><span>Done</span></td>
                <td class='tableHeaderSpan'><span>Score</span></td>
                <td class='tableHeaderSpan'><span>Bet</span></td>
                <td class='tableHeaderSpan'><span>Done</span></td>
                <td class='tableHeaderSpan'><span>Score</span></td>
                <td class='tableHeaderSpan'><span>Action</span></td>
                <td class='hidden'><span class='tableHeaderSpan'>State</span></td>
            </tr>";

            //dynamic content 
            $sql = "SELECT * FROM $gameTable";
            $result = mysqli_query($con, $sql);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $handID = checkArray($row, 'id');
                $currentHand = checkArray($row, 'currentHand');
                $handState = checkArray($row, 'handState');
                $p1bet = checkArray($row, 'p1bet');
                $p1done = checkArray($row, 'p1done');
                $p1score = checkArray($row, 'p1score');
                $p1prize = checkArray($row, 'p1prize');
                $p2bet = checkArray($row, 'p2bet');
                $p2done = checkArray($row, 'p2done');
                $p2score = checkArray($row, 'p2score');
                $p2prize = checkArray($row, 'p2prize');
                $p3bet = checkArray($row, 'p3bet');
                $p3done = checkArray($row, 'p3done');
                $p3score = checkArray($row, 'p3score');
                $p3prize = checkArray($row, 'p3prize');
                $p4bet = checkArray($row, 'p4bet');
                $p4done = checkArray($row, 'p4done');
                $p4score = checkArray($row, 'p4score');
                $p4prize = checkArray($row, 'p4prize');

                echo "<tr id='" . $handID . "'>";
                echo "<td class='currentHandSpan'><span id='hand_" . $handID . "'>" . $currentHand . "</span></td>";
                echo "<td class='inputField'><input id='p1_bet_" . $handID . "' type='number' value='" . $p1bet . "' disabled></td>";
                echo "<td class='inputField'><input id='p1_done_" . $handID . "' type='number' value='" . $p1done . "' disabled></td>";
                echo "<td class='spanField'><span id='p1_score_" . $handID . "'>" . $p1score . "</span></td>";
                echo "<td class='inputField'><input id='p2_bet_" . $handID . "' type='number' value='" . $p2bet . "' disabled></td>";
                echo "<td class='inputField'><input id='p2_done_" . $handID . "' type='number' value='" . $p2done . "' disabled></td>";
                echo "<td class='spanField'><span id='p2_score_" . $handID . "'>" . $p2score . "</span></td>";
                echo "<td class='inputField'><input id='p3_bet_" . $handID . "' type='number' value='" . $p3bet . "' disabled></td>";
                echo "<td class='inputField'><input id='p3_done_" . $handID . "' type='number' value='" . $p3done . "' disabled></td>";
                echo "<td class='spanField'><span id='p3_score_" . $handID . "'>" . $p3score . "</span></td>";
                echo "<td class='inputField'><input id='p4_bet_" . $handID . "' type='number' value='" . $p4bet . "' disabled></td>";
                echo "<td class='inputField'><input id='p4_done_" . $handID . "' type='number' value='" . $p4done . "' disabled></td>";
                echo "<td class='spanField'><span id='p4_score_" . $handID . "'>" . $p4score . "</span></td>";
                echo "<td><input class='rowActionButton btn' id='action_" . $handID . "' type='button' value='Bet' disabled></td>";
                echo "<td class='hidden'><span id='handState_" . $handID . "' class='spanFieldState'>" . $handState . "</span></td>";
                echo"</tr>";
            }
            break;
        case 5:
            //names header
            echo "<tr id='header_names'>";
            echo "<td class='currentHandSpan'><span></span></td>";
            echo "<td colspan='3' class='playerNamesSpan'><span id='p1name'>" . $player1Name . "</span></td>";
            echo "<td colspan='3' class='playerNamesSpan'><span' id='p2name'>" . $player2Name . "</span></td>";
            echo "<td colspan='3' class='playerNamesSpan'><span id='p3name'>" . $player3Name . "</span></td>";
            echo "<td colspan='3' class='playerNamesSpan'><span id='p4name'>" . $player4Name . "</span></td>";
            echo "<td colspan='3' class='playerNamesSpan'><span id='p5name'>" . $player5Name . "</span></td>";
            echo "<td><span></span></td>";
            echo "<td class='hidden'><span></span></td>";
            echo "</tr>";

            //details header
            echo "<tr id='header_details'>
                <td class='currentHandSpan'><span>Cards</span></td>
                <td class='tableHeaderSpan'><span> Bet</span></td>
                <td class='tableHeaderSpan'><span>Done</span></td>
                <td class='tableHeaderSpan'><span>Score</span></td>
                <td class='tableHeaderSpan'><span>Bet</span></td>
                <td class='tableHeaderSpan'><span>Done</span></td>
                <td class='tableHeaderSpan'><span>Score</span></td>
                <td class='tableHeaderSpan'><span> Bet</span></td>
                <td class='tableHeaderSpan'><span>Done</span></td>
                <td class='tableHeaderSpan'><span>Score</span></td>
                <td class='tableHeaderSpan'><span>Bet</span></td>
                <td class='tableHeaderSpan'><span>Done</span></td>
                <td class='tableHeaderSpan'><span>Score</span></td>
                <td class='tableHeaderSpan'><span>Bet</span></td>
                <td class='tableHeaderSpan'><span>Done</span></td>
                <td class='tableHeaderSpan'><span>Score</span></td>
                <td class='tableHeaderSpan'><span>Action</span></td>
                <td class='hidden'><span class='tableHeaderSpan'>State</span></td>
            </tr>";

            //dynamic content 
            $sql = "SELECT * FROM $gameTable";
            $result = mysqli_query($con, $sql);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $handID = checkArray($row, 'id');
                $currentHand = checkArray($row, 'currentHand');
                $handState = checkArray($row, 'handState');
                $p1bet = checkArray($row, 'p1bet');
                $p1done = checkArray($row, 'p1done');
                $p1score = checkArray($row, 'p1score');
                $p1prize = checkArray($row, 'p1prize');
                $p2bet = checkArray($row, 'p2bet');
                $p2done = checkArray($row, 'p2done');
                $p2score = checkArray($row, 'p2score');
                $p2prize = checkArray($row, 'p2prize');
                $p3bet = checkArray($row, 'p3bet');
                $p3done = checkArray($row, 'p3done');
                $p3score = checkArray($row, 'p3score');
                $p3prize = checkArray($row, 'p3prize');
                $p4bet = checkArray($row, 'p4bet');
                $p4done = checkArray($row, 'p4done');
                $p4score = checkArray($row, 'p4score');
                $p4prize = checkArray($row, 'p4prize');
                $p5bet = checkArray($row, 'p5bet');
                $p5done = checkArray($row, 'p5done');
                $p5score = checkArray($row, 'p5score');
                $p5prize = checkArray($row, 'p5prize');

                echo "<tr id='" . $handID . "'>";
                echo "<td class='currentHandSpan'><span id='hand_" . $handID . "'>" . $currentHand . "</span></td>";
                echo "<td class='inputField'><input id='p1_bet_" . $handID . "' type='number' value='" . $p1bet . "' disabled></td>";
                echo "<td class='inputField'><input id='p1_done_" . $handID . "' type='number' value='" . $p1done . "' disabled></td>";
                echo "<td class='spanField'><span id='p1_score_" . $handID . "'>" . $p1score . "</span></td>";
                echo "<td class='inputField'><input id='p2_bet_" . $handID . "' type='number' value='" . $p2bet . "' disabled></td>";
                echo "<td class='inputField'><input id='p2_done_" . $handID . "' type='number' value='" . $p2done . "' disabled></td>";
                echo "<td class='spanField'><span id='p2_score_" . $handID . "'>" . $p2score . "</span></td>";
                echo "<td class='inputField'><input id='p3_bet_" . $handID . "' type='number' value='" . $p3bet . "' disabled></td>";
                echo "<td class='inputField'><input id='p3_done_" . $handID . "' type='number' value='" . $p3done . "' disabled></td>";
                echo "<td class='spanField'><span id='p3_score_" . $handID . "'>" . $p3score . "</span></td>";
                echo "<td class='inputField'><input id='p4_bet_" . $handID . "' type='number' value='" . $p4bet . "' disabled></td>";
                echo "<td class='inputField'><input id='p4_done_" . $handID . "' type='number' value='" . $p4done . "' disabled></td>";
                echo "<td class='spanField'><span id='p4_score_" . $handID . "'>" . $p4score . "</span></td>";
                echo "<td class='inputField'><input id='p5_bet_" . $handID . "' type='number' value='" . $p5bet . "' disabled></td>";
                echo "<td class='inputField'><input id='p5_done_" . $handID . "' type='number' value='" . $p5done . "' disabled></td>";
                echo "<td class='spanField'><span id='p5_score_" . $handID . "'>" . $p5score . "</span></td>";
                echo "<td><input class='rowActionButton btn' id='action_" . $handID . "' type='button' value='Bet' disabled></td>";
                echo "<td class='hidden'><span id='handState_" . $handID . "' class='spanFieldState'>" . $handState . "</span></td>";
                echo"</tr>";
            }
            break;
        case 6:
            //names header
            echo "<tr id='header_names'>";
            echo "<td class='currentHandSpan'><span></span></td>";
            echo "<td colspan='3' class='playerNamesSpan'><span id='p1name'>" . $player1Name . "</span></td>";
            echo "<td colspan='3' class='playerNamesSpan'><span' id='p2name'>" . $player2Name . "</span></td>";
            echo "<td colspan='3' class='playerNamesSpan'><span id='p3name'>" . $player3Name . "</span></td>";
            echo "<td colspan='3' class='playerNamesSpan'><span id='p4name'>" . $player4Name . "</span></td>";
            echo "<td colspan='3' class='playerNamesSpan'><span id='p5name'>" . $player5Name . "</span></td>";
            echo "<td colspan='3' class='playerNamesSpan'><span id='p6name'>" . $player6Name . "</span></td>";
            echo "<td><span></span></td>";
            echo "<td class='hidden'><span></span></td>";
            echo "</tr>";

            //details header
            echo "<tr id='header_details'>
                <td class='currentHandSpan'><span>Cards</span></td>
                <td class='tableHeaderSpan'><span> Bet</span></td>
                <td class='tableHeaderSpan'><span>Done</span></td>
                <td class='tableHeaderSpan'><span>Score</span></td>
                <td class='tableHeaderSpan'><span> Bet</span></td>
                <td class='tableHeaderSpan'><span>Done</span></td>
                <td class='tableHeaderSpan'><span>Score</span></td>
                <td class='tableHeaderSpan'><span>Bet</span></td>
                <td class='tableHeaderSpan'><span>Done</span></td>
                <td class='tableHeaderSpan'><span>Score</span></td>
                <td class='tableHeaderSpan'><span> Bet</span></td>
                <td class='tableHeaderSpan'><span>Done</span></td>
                <td class='tableHeaderSpan'><span>Score</span></td>
                <td class='tableHeaderSpan'><span>Bet</span></td>
                <td class='tableHeaderSpan'><span>Done</span></td>
                <td class='tableHeaderSpan'><span>Score</span></td>
                <td class='tableHeaderSpan'><span>Bet</span></td>
                <td class='tableHeaderSpan'><span>Done</span></td>
                <td class='tableHeaderSpan'><span>Score</span></td>
                <td class='tableHeaderSpan'><span>Action</span></td>
                <td class='hidden'><span class='tableHeaderSpan'>State</span></td>
            </tr>";

            //dynamic content 
            $sql = "SELECT * FROM $gameTable";
            $result = mysqli_query($con, $sql);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $handID = checkArray($row, 'id');
                $currentHand = checkArray($row, 'currentHand');
                $handState = checkArray($row, 'handState');
                $p1bet = checkArray($row, 'p1bet');
                $p1done = checkArray($row, 'p1done');
                $p1score = checkArray($row, 'p1score');
                $p1prize = checkArray($row, 'p1prize');
                $p2bet = checkArray($row, 'p2bet');
                $p2done = checkArray($row, 'p2done');
                $p2score = checkArray($row, 'p2score');
                $p2prize = checkArray($row, 'p2prize');
                $p3bet = checkArray($row, 'p3bet');
                $p3done = checkArray($row, 'p3done');
                $p3score = checkArray($row, 'p3score');
                $p3prize = checkArray($row, 'p3prize');
                $p4bet = checkArray($row, 'p4bet');
                $p4done = checkArray($row, 'p4done');
                $p4score = checkArray($row, 'p4score');
                $p4prize = checkArray($row, 'p4prize');
                $p5bet = checkArray($row, 'p5bet');
                $p5done = checkArray($row, 'p5done');
                $p5score = checkArray($row, 'p5score');
                $p5prize = checkArray($row, 'p5prize');
                $p6bet = checkArray($row, 'p6bet');
                $p6done = checkArray($row, 'p6done');
                $p6score = checkArray($row, 'p6score');
                $p6prize = checkArray($row, 'p6prize');

                echo "<tr id='" . $handID . "'>";
                echo "<td class='currentHandSpan'><span id='hand_" . $handID . "'>" . $currentHand . "</span></td>";
                echo "<td class='inputField'><input id='p1_bet_" . $handID . "' type='number' value='" . $p1bet . "' disabled></td>";
                echo "<td class='inputField'><input id='p1_done_" . $handID . "' type='number' value='" . $p1done . "' disabled></td>";
                echo "<td class='spanField'><span id='p1_score_" . $handID . "'>" . $p1score . "</span></td>";
                echo "<td class='inputField'><input id='p2_bet_" . $handID . "' type='number' value='" . $p2bet . "' disabled></td>";
                echo "<td class='inputField'><input id='p2_done_" . $handID . "' type='number' value='" . $p2done . "' disabled></td>";
                echo "<td class='spanField'><span id='p2_score_" . $handID . "'>" . $p2score . "</span></td>";
                echo "<td class='inputField'><input id='p3_bet_" . $handID . "' type='number' value='" . $p3bet . "' disabled></td>";
                echo "<td class='inputField'><input id='p3_done_" . $handID . "' type='number' value='" . $p3done . "' disabled></td>";
                echo "<td class='spanField'><span id='p3_score_" . $handID . "'>" . $p3score . "</span></td>";
                echo "<td class='inputField'><input id='p4_bet_" . $handID . "' type='number' value='" . $p4bet . "' disabled></td>";
                echo "<td class='inputField'><input id='p4_done_" . $handID . "' type='number' value='" . $p4done . "' disabled></td>";
                echo "<td class='spanField'><span id='p4_score_" . $handID . "'>" . $p4score . "</span></td>";
                echo "<td class='inputField'><input id='p5_bet_" . $handID . "' type='number' value='" . $p5bet . "' disabled></td>";
                echo "<td class='inputField'><input id='p5_done_" . $handID . "' type='number' value='" . $p5done . "' disabled></td>";
                echo "<td class='spanField'><span id='p5_score_" . $handID . "'>" . $p5score . "</span></td>";
                echo "<td class='inputField'><input id='p6_bet_" . $handID . "' type='number' value='" . $p6bet . "' disabled></td>";
                echo "<td class='inputField'><input id='p6_done_" . $handID . "' type='number' value='" . $p6done . "' disabled></td>";
                echo "<td class='spanField'><span id='p6_score_" . $handID . "'>" . $p6score . "</span></td>";
                echo "<td><input class='rowActionButton btn' id='action_" . $handID . "' type='button' value='Bet' disabled></td>";
                echo "<td class='hidden'><span id='handState_" . $handID . "' class='spanFieldState'>" . $handState . "</span></td>";
                echo"</tr>";
            }
            break;
    }
}

//functions to update temp game table
function updateBet($con, $gameTable, $players, $id, $p1bet, $p2bet, $p3bet, $p4bet, $p5bet, $p6bet) {
    //create query based on the number of players
    switch ($players) {
        case 2:
            $sql = "UPDATE $gameTable SET handState = 'play', p1bet = '$p1bet', p2bet = '$p2bet' WHERE id = '$id'";
            break;
        case 3:
            $sql = "UPDATE $gameTable SET handState = 'play', p1bet = '$p1bet', p2bet = '$p2bet', p3bet = '$p3bet' WHERE id = '$id'";
            break;
        case 4:
            $sql = "UPDATE $gameTable SET handState = 'play', p1bet = '$p1bet', p2bet = '$p2bet', p3bet = '$p3bet', p4bet = '$p4bet' WHERE id = '$id'";
            break;
        case 5:
            $sql = "UPDATE $gameTable SET handState = 'play', p1bet = '$p1bet', p2bet = '$p2bet', p3bet = '$p3bet', p4bet = '$p4bet', p5bet = '$p5bet' WHERE id = '$id'";
            break;
        case 6:
            $sql = "UPDATE $gameTable SET handState = 'play', p1bet = '$p1bet', p2bet = '$p2bet', p3bet = '$p3bet', p4bet = '$p4bet', p5bet = '$p5bet', p6bet = '$p6bet' WHERE id = '$id'";
            break;
    }
    mysqli_query($con, $sql);
}

function updateDone($con, $gameTable, $players, $id, $p1done, $p2done, $p3done, $p4done, $p5done, $p6done, $p1score, $p2score, $p3score, $p4score, $p5score, $p6score, $p1prize, $p2prize, $p3prize, $p4prize, $p5prize, $p6prize) {
    //create query based on the number of players
    switch ($players) {
        case 2:
            $sql = "UPDATE $gameTable SET handState = 'finished',  p1done = '$p1done', p2done = '$p2done', p1score = '$p1score', p2score = '$p2score', p1prize = '$p1prize', p2prize = '$p2prize' WHERE id = '$id'";
            break;
        case 3:
            $sql = "UPDATE $gameTable SET handState = 'finished', p1done = '$p1done', p2done = '$p2done', p3done = '$p3done', p1score = '$p1score', p2score = '$p2score', p3score = '$p3score', p1prize = '$p1prize', p2prize = '$p2prize', p3prize = '$p3prize' WHERE id = '$id'";
            break;
        case 4:
            $sql = "UPDATE $gameTable SET handState = 'finished', p1done = '$p1done', p2done = '$p2done', p3done = '$p3done', p4done = '$p4done', p1score = '$p1score', p2score = '$p2score', p3score = '$p3score', p4score = '$p4score', p1prize = '$p1prize', p2prize = '$p2prize', p3prize = '$p3prize', p4prize = '$p4prize' WHERE id = '$id'";
            break;
        case 5:
            $sql = "UPDATE $gameTable SET handState = 'finished', p1done = '$p1done', p2done = '$p2done', p3done = '$p3done', p4done = '$p4done', p5done = '$p5done', p1score = '$p1score', p2score = '$p2score', p3score = '$p3score', p4score = '$p4score', p5score = '$p5score', p1prize = '$p1prize', p2prize = '$p2prize', p3prize = '$p3prize', p4prize = '$p4prize', p5prize = '$p5prize' WHERE id = '$id'";
            break;
        case 6:
            $sql = "UPDATE $gameTable SET handState = 'finished', p1done = '$p1done', p2done = '$p2done', p3done = '$p3done', p4done = '$p4done', p5done = '$p5done', p6done = '$p6done', p1score = '$p1score', p2score = '$p2score', p3score = '$p3score', p4score = '$p4score', p5score = '$p5score', p6score = '$p6score', p1prize = '$p1prize', p2prize = '$p2prize', p3prize = '$p3prize', p4prize = '$p4prize', p5prize = '$p5prize', p6prize = '$p6prize' WHERE id = '$id'";
            break;
    }
    mysqli_query($con, $sql);
    $nextId = $id + 1;
    $sql = "UPDATE $gameTable SET handState = 'play' WHERE id = '$nextId'";
    mysqli_query($con, $sql);
}

//function to finish the game
function finishGame($con, $owner, $players, $p1score, $p2score, $p3score, $p4score, $p5score, $p6score) {
    switch ($players) {
        case 2:
            $sql = "UPDATE whist_games SET gameState = 'finished', p1total = '$p1score', p2total = '$p2score' WHERE owner = '$owner' AND gameState = 'ongoing'";
            break;
        case 3:
            $sql = "UPDATE whist_games SET gameState = 'finished', p1total = '$p1score', p2total = '$p2score', p3total = '$p3score' WHERE owner = '$owner' AND gameState = 'ongoing'";
            break;
        case 4:
            $sql = "UPDATE whist_games SET gameState = 'finished', p1total = '$p1score', p2total = '$p2score', p3total = '$p3score', p4total = '$p4score' WHERE owner = '$owner' AND gameState = 'ongoing'";
            break;
        case 5:
            $sql = "UPDATE whist_games SET gameState = 'finished', p1total = '$p1score', p2total = '$p2score', p3total = '$p3score', p4total = '$p4score', p5total = '$p5score' WHERE owner = '$owner' AND gameState = 'ongoing'";
            break;
        case 6:
            $sql = "UPDATE whist_games SET gameState = 'finished', p1total = '$p1score', p2total = '$p2score', p3total = '$p3score', p4total = '$p4score', p5total = '$p5score', p6total = '$p6score' WHERE owner = '$owner' AND gameState = 'ongoing'";
            break;
    }
    mysqli_query($con, $sql);
}
?>

