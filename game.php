<?php
require("Blackjack.php");
session_start();
if (!isset($_COOKIE["games-lost"])) {
    setcookie("games-lost", 0);
}
if (!isset($_COOKIE["games-won"])) {
    setcookie("games-won", 0);
}
// echo "test game.php";
// var_dump($_GET);
if (isset($_GET["play-game-button"])) {
    // echo "you've succefully clicked the button";
    // On game.php instantiate the Blackjack class twice, insert it into a player variable and a dealer variable
    $player = new Blackjack();
    $dealer = new Blackjack();
    $player->hit($player->score);
    // Dealer score moet niet geweten zijn. Of toch? wat zijn de regels van blackjack eigenlijk?
    $dealer->hit($dealer->score);
    echo "player score is $player->score";
    echo "dealer score is $dealer->score";
    $_SESSION["player"] = serialize($player);
    $_SESSION["dealer"] = serialize($dealer);
    ?>
    <form method="POST" action="game.php">
        <input type="radio" id="hit" name="player-action" value="hit" checked>
        <label for="hit">hit</label>
        <input type="radio" id="stand" name="player-action" value="stand">
        <label for="stand">stand</label>
        <input type="radio" id="surrender" name="player-action" value="surrender">
        <label for="surrender">surrender</label>
        <input type="submit">
    </form>
<?php
} else if (isset($_POST["player-action"])) {
    //var_dump($_POST);
    var_dump($_SESSION["player"]);
    var_dump($_SESSION["dealer"]);
    // krijg error message ( ! ) Notice: main(): The script tried to execute a method or access a property of an incomplete object. Please ensure that the class definition ; of the object you are trying to operate on was loaded _before_ unserialize() gets called or provi
    $player = unserialize($_SESSION["player"]);
    $dealer = unserialize($_SESSION["dealer"]);
    // var_dump($player);
    // var_dump($dealer);
    // deze nog afhankelijk maken van actie
    if ($_POST["player-action"] == "hit") {
        // var_dump($player);
        $player->hit($player->score);
    } else if ($_POST["player-action"] == "stand") {
        // var_dump($player);
        // VRAAG: WAT MOET IK DOEN MET STAND; IS DAT WEL NODIG?
        $player->stand();
        while ($dealer->score < 15) {
            $dealer->hit($dealer->score);
        }
        // VRAAG: MOET HET SPEL DAN METEEN VOLLEDIG AFGELOPEN ZIJN?
        if ($dealer->score > 21) {
            $player->status = "win";
        } else if ($player->score > $dealer->score && $player->score <= 21) {
            $player->status = "win";
        } else {
            $player->status = "lose";
        }
    } else if ($_POST["player-action"] == "surrender") {
        // var_dump($player);
        $player->surrender();
    }

    // TO DO: RESULTS_PHASE IN AFZONDERLIJK FUNCTIE STEKEN OFZO; EERSTE POGING NIET SUCCESVOL. EDIT DENK DAT IK HETN U WEL HEB, DOOR GESCHEIDEN SCOPES TE OVERBRUGEN DOOR MIDDEL VAN PARAMETER MEE TE GEVEN AAN FUNCTIE
    function results_phase($player, $dealer)
    {
        var_dump($player);
        var_dump($dealer);
        if ($player->score == 21) {
            $player->status = 21;
        }
        if ($player->score == 21 && $player->cards == 2) {
            $player->status = "win, blackjack even";
        }
        if ($player->score > 21) {
            $player->status = "lose";
        }
        // zorgen dat timing goed is

        if ($player->status == "undecided") {
            echo "player score is $player->score";
            // echo "dealer score is $dealer->score";
        } else if ($player->status == "win") {
            echo "you win, cuz you have $player->score and the dealer has $dealer->score";
            // eventueel deze zaken nog in afzonderlijk reset-functie steken
            $player->score = 0;
            $player->status = "undecided";
            $games_won_previous = $_COOKIE["games-won"];
            $games_won_new = (int) $games_won_previous + 1;
            setcookie("games-won", $games_won_new);
            echo "you have now lost $games_won_new games. Play again.";
        } else if ($_POST["player-action"] == "surrender") {
            echo "you lose, cuz  you surrendered, you idiot";
            $player->score = 0;
            $player->status = "undecided";
            $games_lost_previous = $_COOKIE["games-lost"];
            $games_lost_new = (int) $games_lost_previous + 1;
            setcookie("games-lost", $games_lost_new);
            echo "you have now lost $games_lost_new games. Play again.";
        } else {
            echo "you lose, cuz you have $player->score and the dealer has $dealer->score";
            $player->score = 0;
            $player->status = "undecided";
            $games_lost_previous = $_COOKIE["games-lost"];
            $games_lost_new = (int) $games_lost_previous + 1;
            setcookie("games-lost", $games_lost_new);
            echo "you have now lost $games_lost_new games. Play again.";
        }
    }
    results_phase($player, $dealer);

    $_SESSION["player"] = serialize($player);
    $_SESSION["dealer"] = serialize($dealer);
    // Use forms to send to the game.php page what the player's action is. (i.e. hit/stand/surrender)

    ?>
    <form method="POST" action="game.php">
        <input type="radio" id="hit" name="player-action" value="hit" checked>
        <label for="hit">hit</label>
        <input type="radio" id="stand" name="player-action" value="stand">
        <label for="stand">stand</label>
        <input type="radio" id="surrender" name="player-action" value="surrender">
        <label for="surrender">surrender</label>
        <input type="submit">
    </form>
<?php


} else {
    echo "you need to go to the home page and click the button to play";
}
