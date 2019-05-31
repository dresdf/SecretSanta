<?php

include 'dbUtil.php';
include 'whistFunctions.php';

if (!empty($_POST['start_game'])) {
    //get values
    $owner = $_POST['owner'];
    $p1name = $_POST['p1name'];
    $p2name = $_POST['p2name'];
    $p3name = $_POST['p3name'];
    $p4name = $_POST['p4name'];
    $p5name = $_POST['p5name'];
    $p6name = $_POST['p6name'];
    $players = $_POST['players'];
    $prizeThreshold = $_POST['prizeThreshold'];
    $prizeAmount = $_POST['prizeAmount'];
    $handValue = $_POST['handValue'];
    $zeroWin = $_POST['zeroWin'];
    $nvGame = $_POST['nvGame'];
    $gameTable = $_POST['gameTable'];
    
    //insert game into whist_games table
    $newGameInserted = insertNewGame($con, $owner, $players, $prizeThreshold, $prizeAmount, $handValue, $zeroWin, $nvGame, $gameTable, $p1name, $p2name, $p3name, $p4name, $p5name, $p6name);

    //create temp table for game
    if ($newGameInserted) {
        dropTable($con, $gameTable);
        $tempGameTableCreated = createWhistTable($con, $players, $gameTable);
    } else {
        header("Location:index.php");
    }

    //insert default values into the temp table
    if ($tempGameTableCreated) {
        insertDefaultValues($con, $players, $gameTable, $owner);
        header("Location:gameWhist.php");
    } else {
        header("Location:index.php");
    }
} else if (!empty($_POST['set_bet'])) {

    $gameTable = $_POST['gameTable'];
    $players = $_POST['players'];
    $id = $_POST['rowId'];
    $p1bet = checkPost($_POST['p1bet']);
    $p2bet = checkPost($_POST['p2bet']);
    $p3bet = checkPost($_POST['p3bet']);
    $p4bet = checkPost($_POST['p4bet']);
    $p5bet = checkPost($_POST['p5bet']);
    $p6bet = checkPost($_POST['p6bet']);
    updateBet($con, $gameTable, $players, $id, $p1bet, $p2bet, $p3bet, $p4bet, $p5bet, $p6bet);
} else if (!empty($_POST['set_done'])) {

    $gameTable = $_POST['gameTable'];
    $players = $_POST['players'];
    $id = $_POST['rowId'];
    $p1done = checkPost($_POST['p1done']);
    $p2done = checkPost($_POST['p2done']);
    $p3done = checkPost($_POST['p3done']);
    $p4done = checkPost($_POST['p4done']);
    $p5done = checkPost($_POST['p5done']);
    $p6done = checkPost($_POST['p6done']);

    $p1score = checkPost($_POST['p1score']);
    $p2score = checkPost($_POST['p2score']);
    $p3score = checkPost($_POST['p3score']);
    $p4score = checkPost($_POST['p4score']);
    $p5score = checkPost($_POST['p5score']);
    $p6score = checkPost($_POST['p6score']);

    $p1prize = checkPost($_POST['p1prize']);
    $p2prize = checkPost($_POST['p2prize']);
    $p3prize = checkPost($_POST['p3prize']);
    $p4prize = checkPost($_POST['p4prize']);
    $p5prize = checkPost($_POST['p5prize']);
    $p6prize = checkPost($_POST['p6prize']);
    updateDone($con, $gameTable, $players, $id, $p1done, $p2done, $p3done, $p4done, $p5done, $p6done, $p1score, $p2score, $p3score, $p4score, $p5score, $p6score, $p1prize, $p2prize, $p3prize, $p4prize, $p5prize, $p6prize);
} else if (!empty($_POST['set_finished'])) {

    $players = $_POST['players'];
    $owner = $_POST['owner'];
    $p1score = checkPost($_POST['p1score']);
    $p2score = checkPost($_POST['p2score']);
    $p3score = checkPost($_POST['p3score']);
    $p4score = checkPost($_POST['p4score']);
    $p5score = checkPost($_POST['p5score']);
    $p6score = checkPost($_POST['p6score']);

    finishGame($con, $owner, $players, $p1score, $p2score, $p3score, $p4score, $p5score, $p6score);
}else if(!empty($_POST['delete_game'])){
    $owner = $_POST['owner'];
    $gameTable = $_POST['gameTable'];
    exitGame($con, $gameTable, $owner);
}
?>

