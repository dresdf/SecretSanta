<?php

/*
 * Script for selecting secret santa
 */

//sql support
include 'dbUtil.php';

//initialize arrays
$giver = array();
$receiver = array();
$final = array();


//set time limit for script execution to 5 min, up from 30 seconds
//        set_time_limit(300);

$select_querry = "SELECT Prenume FROM $tableName ORDER by ID";
$selection = mysqli_query($con, $select_querry);


//fill the first two arrays with db values
while ($row = mysqli_fetch_array($selection, MYSQLI_ASSOC)) {
    $giver[] = $row['Prenume'];
    $receiver[] = $row['Prenume'];
}
print_r($giver);
echo '<br>';
print_r($receiver);
echo '<br>';

//check for constraints and fill third array
foreach ($giver as $g) {
    if (!empty($g)) {
        $size = sizeof($receiver) - 1;
        $random = rand(0, $size);

        array_push($final, $receiver[$random]);
        unset($receiver[$random]);
        //shuffle array to reset keys. unset() removes the key also
        shuffle($receiver);
    }
}
print_r($final);

//fill db with results
if (!empty($final)) {
    for ($i = 0; $i < sizeof($final); $i++) {
        $newFriend = $final[$i];
        $tempGiver = $giver[$i];
        $sql = "UPDATE $tableName SET Friend = '$newFriend' WHERE Prenume = '$tempGiver'";
        mysqli_query($con, $sql);
    }
}
