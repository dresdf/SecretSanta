$(document).ready(function () {
    //iniatize variables
    var owner = $('#owner_span').html();
    var players = parseInt($('#player_span').html());
    var gameTable = $('#gameTable_span').html();
    var prizeThreshold = parseInt($('#prizeThreshold_span').html());
    var prizeAmount = parseInt($('#prizeAmount_span').html());
    var handValue = parseInt($('#handValue_span').html());
//    var zeroWin = $('#zeroWin_span').html();//false/true
    var p1score = 0;
    var p2score = 0;
    var p3score = 0;
    var p4score = 0;
    var p5score = 0;
    var p6score = 0;
    var p1prize = 0;
    var p2prize = 0;
    var p3prize = 0;
    var p4prize = 0;
    var p5prize = 0;
    var p6prize = 0;
    var maxGames = getMaxGames(players);

    $('input[type="number"]').attr('min', 0);
    $('input[type="number"]').attr('max', 8);

    $('#exit_game').click(function () {
        swal({title: "Are you sure?", text: "You will not be able to recover this game!", type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Yes, delete it!", cancelButtonText: "No, cancel plx!", closeOnConfirm: false, closeOnCancel: false}, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: "POST",
                    url: "gameplayWhist.php",
                    data: {
                        delete_game: '1',
                        owner: owner,
                        gameTable: gameTable
                    },
                    success: function () {
                    }
                });
                swal({title: "Victory!", text: "Your Game has been deleted."}, function () {
                    window.location.href = "main.php";
                });
//                
            } else {
                swal("Cancelled", "Your game is safe :)", "error");
            }
        });

    });

    //check which hand is currently in play and activate  betting for it
    for (var i = 1; i <= maxGames; i++) {
        var state = $('#handState_' + i).html();
        
        if (state === 'play') {
            switch (players) {
                case 2:
                    $('#p1_bet_' + i).removeAttr('disabled');
                    $('#p2_bet_' + i).removeAttr('disabled');
                    break;
                case 3:
                    $('#p1_bet_' + i).removeAttr('disabled');
                    $('#p2_bet_' + i).removeAttr('disabled');
                    $('#p3_bet_' + i).removeAttr('disabled');
                    break;
                case 4:
                    $('#p1_bet_' + i).removeAttr('disabled');
                    $('#p2_bet_' + i).removeAttr('disabled');
                    $('#p3_bet_' + i).removeAttr('disabled');
                    $('#p4_bet_' + i).removeAttr('disabled');
                    break;
                case 5:
                    $('#p1_bet_' + i).removeAttr('disabled');
                    $('#p2_bet_' + i).removeAttr('disabled');
                    $('#p3_bet_' + i).removeAttr('disabled');
                    $('#p4_bet_' + i).removeAttr('disabled');
                    $('#p5_bet_' + i).removeAttr('disabled');
                    break;
                case 6:
                    $('#p1_bet_' + i).removeAttr('disabled');
                    $('#p2_bet_' + i).removeAttr('disabled');
                    $('#p3_bet_' + i).removeAttr('disabled');
                    $('#p4_bet_' + i).removeAttr('disabled');
                    $('#p5_bet_' + i).removeAttr('disabled');
                    $('#p6_bet_' + i).removeAttr('disabled');
                    break;
            }
            $('#action_' + i).removeAttr('disabled');

            break;
        }else if (state === 'inactive') {
            switch (players) {
                case 2:
                    $('#p1_bet_' + i).removeAttr('disabled');
                    $('#p2_bet_' + i).removeAttr('disabled');
                    break;
                case 3:
                    $('#p1_bet_' + i).removeAttr('disabled');
                    $('#p2_bet_' + i).removeAttr('disabled');
                    $('#p3_bet_' + i).removeAttr('disabled');
                    break;
                case 4:
                    $('#p1_bet_' + i).removeAttr('disabled');
                    $('#p2_bet_' + i).removeAttr('disabled');
                    $('#p3_bet_' + i).removeAttr('disabled');
                    $('#p4_bet_' + i).removeAttr('disabled');
                    break;
                case 5:
                    $('#p1_bet_' + i).removeAttr('disabled');
                    $('#p2_bet_' + i).removeAttr('disabled');
                    $('#p3_bet_' + i).removeAttr('disabled');
                    $('#p4_bet_' + i).removeAttr('disabled');
                    $('#p5_bet_' + i).removeAttr('disabled');
                    break;
                case 6:
                    $('#p1_bet_' + i).removeAttr('disabled');
                    $('#p2_bet_' + i).removeAttr('disabled');
                    $('#p3_bet_' + i).removeAttr('disabled');
                    $('#p4_bet_' + i).removeAttr('disabled');
                    $('#p5_bet_' + i).removeAttr('disabled');
                    $('#p6_bet_' + i).removeAttr('disabled');
                    break;
            }
            $('#action_' + i).removeAttr('disabled');

            break;
        }
    }
    
    //change button text for played hands
    for (var i = 1; i <= maxGames; i++) {
        var state = $('#handState_' + i).html();
        if (state === 'finished') {
            $('#action_' + i).attr("value", "Played");

        }
    }
    $('input').attr('autocomplete', 'off');



//    //clear/reenter placeholder for name input
    var placeholder;
    $('.playerName').click(function () {
        placeholder = $(this).attr('placeholder');
        $(this).attr('placeholder', '');
    }).focusout(function () {
        if ($(this).text() === '') {
            $(this).attr('placeholder', placeholder);
        }
    });

    //clear/reenter default for inputs
    var defaultValue;
    $('.addForm').click(function () {
        defaultValue = $(this).val();
        $(this).val('');

    }).focusout(function () {
        if ($(this).val() === '') {
            $(this).val(defaultValue);
        }
    });

    //clear input content on click
    var inputContent;
    $('input[type="number"]').click(function(){
       inputContent = $(this).val(); 
       $(this).val('');
    }).focusout(function () {
        if ($(this).val() === '') {
            $(this).val(inputContent);
        }
    });

    //show player name input box based on number selected
    $('#playerNumber').change(function () {
        var playerNumber = parseInt($('#playerNumber option:selected').val());
        $('.playerName').attr('disabled', 'disabled');
        $('.playerName').attr('placeholder', '');
        switch (playerNumber) {
            case 2:
                $('#player1').removeAttr('disabled');
                $('#player1').attr('placeholder', 'Player 1');
                $('#player2').removeAttr('disabled');
                $('#player2').attr('placeholder', 'Player 2');
                break;
            case 3:
                $('#player1').removeAttr('disabled');
                $('#player2').removeAttr('disabled');
                $('#player3').removeAttr('disabled');

                $('#player1').attr('placeholder', 'Player 1');
                $('#player2').attr('placeholder', 'Player 2');
                $('#player3').attr('placeholder', 'Player 3');
                break;
            case 4:
                $('#player1').removeAttr('disabled');
                $('#player2').removeAttr('disabled');
                $('#player3').removeAttr('disabled');
                $('#player4').removeAttr('disabled');

                $('#player1').attr('placeholder', 'Player 1');
                $('#player2').attr('placeholder', 'Player 2');
                $('#player3').attr('placeholder', 'Player 3');
                $('#player4').attr('placeholder', 'Player 4');
                break;
            case 5:
                $('#player1').removeAttr('disabled');
                $('#player2').removeAttr('disabled');
                $('#player3').removeAttr('disabled');
                $('#player4').removeAttr('disabled');
                $('#player5').removeAttr('disabled');

                $('#player1').attr('placeholder', 'Player 1');
                $('#player2').attr('placeholder', 'Player 2');
                $('#player3').attr('placeholder', 'Player 3');
                $('#player4').attr('placeholder', 'Player 4');
                $('#player5').attr('placeholder', 'Player 5');

                break;
            case 6:
                $('#player1').removeAttr('disabled');
                $('#player2').removeAttr('disabled');
                $('#player3').removeAttr('disabled');
                $('#player4').removeAttr('disabled');
                $('#player5').removeAttr('disabled');
                $('#player6').removeAttr('disabled');

                $('#player1').attr('placeholder', 'Player 1');
                $('#player2').attr('placeholder', 'Player 2');
                $('#player3').attr('placeholder', 'Player 3');
                $('#player4').attr('placeholder', 'Player 4');
                $('#player5').attr('placeholder', 'Player 5');
                $('#player6').attr('placeholder', 'Player 6');
                break;
        }
    });


    //button action in choose game
    $('#startJocButton').on("click", function () {

//        window.location.href = "gameWhist.php";

        //initialize variables
        var owner = $('#owner_span').html();
        var p1name = $('#player1').val();
        var p2name = $('#player2').val();
        var p3name = $('#player3').val();
        var p4name = $('#player4').val();
        var p5name = $('#player5').val();
        var p6name = $('#player6').val();
        var players = parseInt($('#playerNumber option:selected').val());
        var prizeThreshold = parseInt($('#prizeThresholdInput').val());
        var prizeAmount = parseInt($('#prizeAmountInput').val());
        var handValue = parseInt($('#handValueInput').val());
        var zeroWin = $('#zeroWinSelector option:selected').val();
        var nvGame = $('#nvGameSelector option:selected').val();
        var gameTable = owner + "_whist";


        // ajax call
        $.ajax({
            type: "POST",
            url: "gameplayWhist.php",
            data: {
                start_game: '1',
                owner: owner,
                p1name: p1name,
                p2name: p2name,
                p3name: p3name,
                p4name: p4name,
                p5name: p5name,
                p6name: p6name,
                players: players,
                prizeThreshold: prizeThreshold,
                prizeAmount: prizeAmount,
                handValue: handValue,
                zeroWin: zeroWin,
                nvGame: nvGame,
                gameTable: gameTable
            },
            success: function () {

                window.location.href = "gameWhist.php";
            },
            error: function () {
                window.location.href = "gameWhist.php";
            }
        });
//        window.location.href = "gameWhist.php";

    });

    //button action in whist sheet
    $(".rowActionButton").on("click", function () {
        var btnVal = $(this).attr("value");//get value of button
        var rowId = parseInt($(this).parent().parent().attr('id'));//get value of tr id and cast it as int
        //getting the values that user typed
        var currentHand = parseInt($('#hand_' + rowId).html());
        var p1bet = parseInt($('#p1_bet_' + rowId).val());
        var p2bet = parseInt($('#p2_bet_' + rowId).val());
        var p3bet = parseInt($('#p3_bet_' + rowId).val());
        var p4bet = parseInt($('#p4_bet_' + rowId).val());
        var p5bet = parseInt($('#p5_bet_' + rowId).val());
        var p6bet = parseInt($('#p6_bet_' + rowId).val());
        var p1done = parseInt($('#p1_done_' + rowId).val());
        var p2done = parseInt($('#p2_done_' + rowId).val());
        var p3done = parseInt($('#p3_done_' + rowId).val());
        var p4done = parseInt($('#p4_done_' + rowId).val());
        var p5done = parseInt($('#p5_done_' + rowId).val());
        var p6done = parseInt($('#p6_done_' + rowId).val());


        if (btnVal === "Bet") {

            if (checkEmptyInput($('#p1_bet_' + rowId).val(), $('#p2_bet_' + rowId).val(), $('#p3_bet_' + rowId).val(), $('#p4_bet_' + rowId).val(), $('#p5_bet_' + rowId).val(), $('#p6_bet_' + rowId).val())) {
                if (checkBetNumber(p1bet, p2bet, p3bet, p4bet, p5bet, p6bet, currentHand)) {
                    //change value of button
                    $(this).attr("value", "Done");
                    placeBetUI(rowId);

                    // insert data in DB
                    // ajax call
                    $.ajax({
                        type: "POST",
                        url: "gameplayWhist.php",
                        data: {
                            set_bet: '1',
                            players: players,
                            gameTable: gameTable,
                            rowId: rowId,
                            p1bet: p1bet,
                            p2bet: p2bet,
                            p3bet: p3bet,
                            p4bet: p4bet,
                            p5bet: p5bet,
                            p6bet: p6bet

                        },
                        success: function () { // this happen after we get result

                            alert("Bets Inserted!");
                        }
                    });
                } else {
                    alert("A bet is incorect!");
                }
            } else {
                alert("A bet is empty!");

            }


        } else if (btnVal === "Done") {
            if (checkEmptyInput($('#p1_done_' + rowId).val(), $('#p2_done_' + rowId).val(), $('#p3_done_' + rowId).val(), $('#p4_done_' + rowId).val(), $('#p5_done_' + rowId).val(), $('#p6_done_' + rowId).val())) {

                if (checkDoneNumber(p1done, p2done, p3done, p4done, p5done, p6done, currentHand)) {
                    //change value of button and disable it
                    $(this).attr("value", "Played");
                    $(this).attr('disabled', 'disabled');

                    placeDoneUI(rowId);


                    //update score
                    switch (players) {
                        case 2:
                            p1score = handScore(p1bet, p1done, p1score);//update score
                            p1prize = modifyPrize(p1bet, p1done, p1prize);//update prize
                            p1score = checkPrize(p1prize, p1score);//check if prize threshold is reached
                            p1prize = resetPrize(p1prize, p1score);//reset prize count if streak broken

                            p2score = handScore(p2bet, p2done, p2score);
                            p2prize = modifyPrize(p2bet, p2done, p2prize);
                            p2score = checkPrize(p2prize, p2score);
                            p2prize = resetPrize(p2prize, p2score);
                            break;
                        case 3:
                            p1score = handScore(p1bet, p1done, p1score);
                            p1prize = modifyPrize(p1bet, p1done, p1prize);
                            p1score = checkPrize(p1prize, p1score);
                            p2score = handScore(p2bet, p2done, p2score);
                            p2prize = modifyPrize(p2bet, p2done, p2prize);
                            p2score = checkPrize(p2prize, p2score);
                            p3score = handScore(p3bet, p3done, p3score);
                            p3prize = modifyPrize(p3bet, p3done, p3prize);
                            p3score = checkPrize(p3prize, p3score);
                            break;
                        case 4:
                            p1score = handScore(p1bet, p1done, p1score);
                            p1prize = modifyPrize(p1bet, p1done, p1prize);
                            p1score = checkPrize(p1prize, p1score);
                            p2score = handScore(p2bet, p2done, p2score);
                            p2prize = modifyPrize(p2bet, p2done, p2prize);
                            p2score = checkPrize(p2prize, p2score);
                            p3score = handScore(p3bet, p3done, p3score);
                            p3prize = modifyPrize(p3bet, p3done, p3prize);
                            p3score = checkPrize(p3prize, p3score);
                            p4score = handScore(p4bet, p4done, p4score);
                            p4prize = modifyPrize(p4bet, p4done, p4prize);
                            p4score = checkPrize(p4prize, p4score);
                            break;
                        case 5:
                            p1score = handScore(p1bet, p1done, p1score);
                            p1prize = modifyPrize(p1bet, p1done, p1prize);
                            p1score = checkPrize(p1prize, p1score);
                            p2score = handScore(p2bet, p2done, p2score);
                            p2prize = modifyPrize(p2bet, p2done, p2prize);
                            p2score = checkPrize(p2prize, p2score);
                            p3score = handScore(p3bet, p3done, p3score);
                            p3prize = modifyPrize(p3bet, p3done, p3prize);
                            p3score = checkPrize(p3prize, p3score);
                            p4score = handScore(p4bet, p4done, p4score);
                            p4prize = modifyPrize(p4bet, p4done, p4prize);
                            p4score = checkPrize(p4prize, p4score);
                            p5score = handScore(p5bet, p5done, p5score);
                            p5prize = modifyPrize(p5bet, p5done, p5prize);
                            p5score = checkPrize(p5prize, p5score);
                            break;
                        case 6:
                            p1score = handScore(p1bet, p1done, p1score);
                            p1prize = modifyPrize(p1bet, p1done, p1prize);
                            p1score = checkPrize(p1prize, p1score);
                            p2score = handScore(p2bet, p2done, p2score);
                            p2prize = modifyPrize(p2bet, p2done, p2prize);
                            p2score = checkPrize(p2prize, p2score);
                            p3score = handScore(p3bet, p3done, p3score);
                            p3prize = modifyPrize(p3bet, p3done, p3prize);
                            p3score = checkPrize(p3prize, p3score);
                            p4score = handScore(p4bet, p4done, p4score);
                            p4prize = modifyPrize(p4bet, p4done, p4prize);
                            p4score = checkPrize(p4prize, p4score);
                            p5score = handScore(p5bet, p5done, p5score);
                            p5prize = modifyPrize(p5bet, p5done, p5prize);
                            p5score = checkPrize(p5prize, p5score);
                            p6score = handScore(p6bet, p6done, p6score);
                            p6prize = modifyPrize(p6bet, p6done, p6prize);
                            p6score = checkPrize(p6prize, p6score);

                            break;
                    }

                    //insert data in DB 
                    $.ajax({
                        type: "POST",
                        url: "gameplayWhist.php",
                        data: {
                            set_done: '1',
                            players: players,
                            gameTable: gameTable,
                            rowId: rowId,
                            p1done: p1done,
                            p2done: p2done,
                            p3done: p3done,
                            p4done: p4done,
                            p5done: p5done,
                            p6done: p6done,
                            p1score: p1score,
                            p2score: p2score,
                            p3score: p3score,
                            p4score: p4score,
                            p5score: p5score,
                            p6score: p6score,
                            p1prize: p1prize,
                            p2prize: p2prize,
                            p3prize: p3prize,
                            p4prize: p4prize,
                            p5prize: p5prize,
                            p6prize: p6prize


                        },
                        success: function () { // this happen after we get result

                            $('#p1_score_' + rowId).html(p1score);
                            $('#p2_score_' + rowId).html(p2score);
                            $('#p3_score_' + rowId).html(p3score);
                            $('#p4_score_' + rowId).html(p4score);
                            $('#p5_score_' + rowId).html(p5score);
                            $('#p6_score_' + rowId).html(p6score);
                            $('#handState_' + rowId).html('finished');
                            $('#handState_' + (rowId + 1)).html('play');

                            if (checkLastHand(rowId)) {

                                $.ajax({
                                    type: "POST",
                                    url: "gameplayWhist.php",
                                    data: {
                                        set_finished: '1',
                                        owner: owner,
                                        players: players,
                                        p1score: p1score,
                                        p2score: p2score,
                                        p3score: p3score,
                                        p4score: p4score,
                                        p5score: p5score,
                                        p6score: p6score,
                                    },
                                    success: function () {
                                        alert("Game Finished!!");
                                    }


                                });
                            }

                        }
                    });

                } else {
                    alert("A Done is incorrect!");
                }

            } else {
                alert("A done is empty!");
            }

        }
    });



    /*  
     * Helper functions for gameplay
     * 
     */

    //check input for empty values
    function checkEmptyInput(p1, p2, p3, p4, p5, p6) {
        switch (players) {
            case 2:
                if (!p1 || !p2) {
                    return false;
                } else {
                    return true;
                }
                break;
            case 3:
                if (!p1 || !p2 || !p3) {
                    return false;
                } else {
                    return true;
                }
                break;
            case 4:
                if (!p1 || !p2 || !p3 || !p4) {
                    return false;
                } else {
                    return true;
                }
                break;
            case 5:
                if (!p1 || !p2 || !p3 || !p4 || !p5) {
                    return false;
                } else {
                    return true;
                }
                break;
            case 6:
                if (!p1 || !p2 || !p3 || !p4 || !p5 || !p6) {
                    return false;
                } else {
                    return true;
                }
                break;
        }

    }

    //check if bet === hands or if bet > hands
    function checkBetNumber(p1, p2, p3, p4, p5, p6, currHand) {
        switch (players) {
            case 2:
                if ((p1 + p2) === currHand || p1 > currHand || p2 > currHand) {
                    return false;
                }
                break;
            case 3:
                if ((p1 + p2 + p3) === currHand || p1 > currHand || p2 > currHand || p3 > currHand) {
                    return false;
                }
                break;
            case 4:
                if ((p1 + p2 + p3 + p4) === currHand || p1 > currHand || p2 > currHand || p3 > currHand || p4 > currHand) {
                    return false;
                }
                break;
            case 5:
                if ((p1 + p2 + p3 + p4 + p5) === currHand || p1 > currHand || p2 > currHand || p3 > currHand || p4 > currHand || p5 > currHand) {
                    return false;
                }
                break;
            case 6:
                if ((p1 + p2 + p3 + p4 + p5 + p6) === currHand || p1 > currHand || p2 > currHand || p3 > currHand || p4 > currHand || p5 > currHand || p6 > currHand) {
                    return false;
                }
                break;
        }
        return true;
    }

    //check if done > hands
    function checkDoneNumber(p1, p2, p3, p4, p5, p6, currHand) {
        switch (players) {
            case 2:
                if ((p1 + p2) !== currHand || p1 > currHand || p2 > currHand) {
                    return false;
                }
                break;
            case 3:
                if ((p1 + p2 + p3) !== currHand || p1 > currHand || p2 > currHand || p3 > currHand) {
                    return false;
                }
                break;
            case 4:
                if ((p1 + p2 + p3 + p4) !== currHand || p1 > currHand || p2 > currHand || p3 > currHand || p4 > currHand) {
                    return false;
                }
                break;
            case 5:
                if ((p1 + p2 + p3 + p4 + p5) !== currHand || p1 > currHand || p2 > currHand || p3 > currHand || p4 > currHand || p5 > currHand) {
                    return false;
                }
                break;
            case 6:
                if ((p1 + p2 + p3 + p4 + p5 + p6) !== currHand || p1 > currHand || p2 > currHand || p3 > currHand || p4 > currHand || p5 > currHand || p6 > currHand) {
                    return false;
                }
                break;
        }
        return true;
    }

    //function for beting(UI changes)
    function placeBetUI(count) {

        switch (players) {
            case 2:
                //disable bet
                $('#p1_bet_' + count).attr('disabled', 'disabled');
                $('#p2_bet_' + count).attr('disabled', 'disabled');

                //enable done
                $('#p1_done_' + count).removeAttr('disabled');
                $('#p2_done_' + count).removeAttr('disabled');
                break;
            case 3:
                //disable bet
                $('#p1_bet_' + count).attr('disabled', 'disabled');
                $('#p2_bet_' + count).attr('disabled', 'disabled');
                $('#p3_bet_' + count).attr('disabled', 'disabled');

                //enable done
                $('#p1_done_' + count).removeAttr('disabled');
                $('#p2_done_' + count).removeAttr('disabled');
                $('#p3_done_' + count).removeAttr('disabled');
                break;
            case 4:
                //disable bet
                $('#p1_bet_' + count).attr('disabled', 'disabled');
                $('#p2_bet_' + count).attr('disabled', 'disabled');
                $('#p3_bet_' + count).attr('disabled', 'disabled');
                $('#p4_bet_' + count).attr('disabled', 'disabled');

                //enable done
                $('#p1_done_' + count).removeAttr('disabled');
                $('#p2_done_' + count).removeAttr('disabled');
                $('#p3_done_' + count).removeAttr('disabled');
                $('#p4_done_' + count).removeAttr('disabled');
                break;
            case 5:
                //disable bet
                $('#p1_bet_' + count).attr('disabled', 'disabled');
                $('#p2_bet_' + count).attr('disabled', 'disabled');
                $('#p3_bet_' + count).attr('disabled', 'disabled');
                $('#p4_bet_' + count).attr('disabled', 'disabled');
                $('#p5_bet_' + count).attr('disabled', 'disabled');

                //enable done
                $('#p1_done_' + count).removeAttr('disabled');
                $('#p2_done_' + count).removeAttr('disabled');
                $('#p3_done_' + count).removeAttr('disabled');
                $('#p4_done_' + count).removeAttr('disabled');
                $('#p5_done_' + count).removeAttr('disabled');
                break;
            case 6:
                //disable bet
                $('#p1_bet_' + count).attr('disabled', 'disabled');
                $('#p2_bet_' + count).attr('disabled', 'disabled');
                $('#p3_bet_' + count).attr('disabled', 'disabled');
                $('#p4_bet_' + count).attr('disabled', 'disabled');
                $('#p5_bet_' + count).attr('disabled', 'disabled');
                $('#p6_bet_' + count).attr('disabled', 'disabled');

                //enable done
                $('#p1_done_' + count).removeAttr('disabled');
                $('#p2_done_' + count).removeAttr('disabled');
                $('#p3_done_' + count).removeAttr('disabled');
                $('#p4_done_' + count).removeAttr('disabled');
                $('#p5_done_' + count).removeAttr('disabled');
                $('#p6_done_' + count).removeAttr('disabled');
                break;
        }
    }

    //function for done(UI changes
    function placeDoneUI(count) {
        switch (players) {
            case 2:
                //disable done
                $('#p1_done_' + count).attr('disabled', 'disabled');
                $('#p2_done_' + count).attr('disabled', 'disabled');

                //enable next button and bet
                $('#action_' + (count + 1)).removeAttr('disabled');
                $('#p1_bet_' + (count + 1)).removeAttr('disabled');
                $('#p2_bet_' + (count + 1)).removeAttr('disabled');
                break;
            case 3:
                //disable done
                $('#p1_done_' + count).attr('disabled', 'disabled');
                $('#p2_done_' + count).attr('disabled', 'disabled');
                $('#p3_done_' + count).attr('disabled', 'disabled');

                //enable next button and bet
                $('#action_' + (count + 1)).removeAttr('disabled');
                $('#p1_bet_' + (count + 1)).removeAttr('disabled');
                $('#p2_bet_' + (count + 1)).removeAttr('disabled');
                $('#p3_bet_' + (count + 1)).removeAttr('disabled');
                break;
            case 4:
                //disable done
                $('#p1_done_' + count).attr('disabled', 'disabled');
                $('#p2_done_' + count).attr('disabled', 'disabled');
                $('#p3_done_' + count).attr('disabled', 'disabled');
                $('#p4_done_' + count).attr('disabled', 'disabled');

                //enable next button and bet
                $('#action_' + (count + 1)).removeAttr('disabled');
                $('#p1_bet_' + (count + 1)).removeAttr('disabled');
                $('#p2_bet_' + (count + 1)).removeAttr('disabled');
                $('#p3_bet_' + (count + 1)).removeAttr('disabled');
                $('#p4_bet_' + (count + 1)).removeAttr('disabled');
                break;
            case 5:
                //disable done
                $('#p1_done_' + count).attr('disabled', 'disabled');
                $('#p2_done_' + count).attr('disabled', 'disabled');
                $('#p3_done_' + count).attr('disabled', 'disabled');
                $('#p4_done_' + count).attr('disabled', 'disabled');
                $('#p5_done_' + count).attr('disabled', 'disabled');

                //enable next button and bet
                $('#action_' + (count + 1)).removeAttr('disabled');
                $('#p1_bet_' + (count + 1)).removeAttr('disabled');
                $('#p2_bet_' + (count + 1)).removeAttr('disabled');
                $('#p3_bet_' + (count + 1)).removeAttr('disabled');
                $('#p4_bet_' + (count + 1)).removeAttr('disabled');
                $('#p5_bet_' + (count + 1)).removeAttr('disabled');
                break;
            case 6:
                //disable done
                $('#p1_done_' + count).attr('disabled', 'disabled');
                $('#p2_done_' + count).attr('disabled', 'disabled');
                $('#p3_done_' + count).attr('disabled', 'disabled');
                $('#p4_done_' + count).attr('disabled', 'disabled');
                $('#p5_done_' + count).attr('disabled', 'disabled');
                $('#p6_done_' + count).attr('disabled', 'disabled');

                //enable next button and bet
                $('#action_' + (count + 1)).removeAttr('disabled');
                $('#p1_bet_' + (count + 1)).removeAttr('disabled');
                $('#p2_bet_' + (count + 1)).removeAttr('disabled');
                $('#p3_bet_' + (count + 1)).removeAttr('disabled');
                $('#p4_bet_' + (count + 1)).removeAttr('disabled');
                $('#p5_bet_' + (count + 1)).removeAttr('disabled');
                $('#p6_bet_' + (count + 1)).removeAttr('disabled');
                break;
        }
    }

    //function for hand score
    function handScore(bet, done, score) {
        if (bet === done) {
            var points = bet;
            score = score + points + handValue;
        } else if (bet !== done) {
            var points = bet - done;
            if (points < 0) {
                points = points * -1;
            }
            score = score - points;
        }
        return score;
    }

    //modify prize
    function modifyPrize(bet, done, prize) {
        if (bet === done) {
            if (prize >= 0) {
                prize = prize + 1;
            } else if (prize < 0) {
                prize = 1;
            }
        } else if (bet !== done) {
            if (prize <= 0) {
                prize = prize - 1;
            } else if (prize > 0) {
                prize = -1;
            }
        }
        return prize;
    }

    //check prize 
    function checkPrize(prize, score) {
        if (prizeThreshold === prize) {
            score = score + prizeAmount;
        } else if ((prizeThreshold * -1) === prize) {
            score = score - prizeAmount;
        }
        return score;
    }

    //function to reset prize if needed
    function resetPrize(prize) {
        if (prizeThreshold === prize) {
            prize = 0;
        } else if ((prizeThreshold * -1) === prize) {
            prize = 0;
        }
        return prize;
    }

    //function to check if last hand
    function checkLastHand(handNumber) {
        switch (players) {
            case 2:
                if (handNumber === 18) {
                    return false;
                }
                break;
            case 3:
                if (handNumber === 21) {
                    return true;
                }
                break;
            case 4:
                if (handNumber === 24) {
                    return true;
                }
                break;
            case 5:
                if (handNumber === 27) {
                    return true;
                }
                break;
            case 6:
                if (handNumber === 30) {
                    return true;
                }
                break;
        }
        return false;
    }

    function getMaxGames(count) {
        switch (count) {
            case 2:
                return 18;
                break;
            case 3:
                return 21;
                break;
            case 4:
                return 24;
                break;
            case 5:
                return 27;
                break;
            case 6:
                return 30;
                break;
        }
    }








//end of file
});