<?php
require("Blackjack.php");
session_start();
if (!isset($_COOKIE["games-lost"])) {
    setcookie("games-lost", 0);
}
// echo "test game.php";
// var_dump($_GET);
if (isset($_GET["play-game-button"])) {
    // echo "you've succefully clicked the button";
    // On game.php instantiate the Blackjack class twice, insert it into a player variable and a dealer variable
    $player = new Blackjack();
    $dealer = new Blackjack();
    $player->hit($player->score);
    // Dealer score moet niet geweten zijn
    // $dealer->hit($dealer->score);
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
    var_dump($_SESSION["player"]);
    var_dump($_SESSION["dealer"]);
    // krijg error message ( ! ) Notice: main(): The script tried to execute a method or access a property of an incomplete object. Please ensure that the class definition ; of the object you are trying to operate on was loaded _before_ unserialize() gets called or provi
    $player = unserialize($_SESSION["player"]);
    $dealer = unserialize($_SESSION["dealer"]);
    var_dump($player);
    var_dump($dealer);
    // deze nog afhankelijk maken van actie
    var_dump($_POST);
    if ($_POST["player-action"] == "hit") {
        var_dump($player);
        $player->hit($player->score);
    }
    if ($player->score > 21) {
        $player->status = "you lose";
    }

        // TO DO: RESULTS_PHASE IN AFZONDERLIJK FUNCTIE STEKEN OFZO; EERSTE POGING NIET SUCCESVOL. EDIT DENK DAT IK HETN U WEL HEB, DOOR GESCHEIDEN SCOPES TE OVERBRUGEN DOOR MIDDEL VAN PARAMETER MEE TE GEVEN AAN FUNCTIE
    function results_phase($player)
    {
        if ($player->status == "undecided") {
            echo "player score is $player->score";
            // echo "dealer score is $dealer->score";
        } else {
            echo "you lose, cuz you have $player->score";
            $player->score = 0;
            $player->status = "undecided";
            $games_lost_previous = $_COOKIE["games-lost"];
            $games_lost_new = (int) $games_lost_previous + 1;
            setcookie("games-lost", $games_lost_new);
            echo "you have now lost $games_lost_new games. Play again.";
        }
    }
    results_phase($player);

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
