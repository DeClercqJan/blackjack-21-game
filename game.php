<?php
require("Blackjack.php");
session_start();
// echo "test game.php";
// var_dump($_GET);
if (isset($_GET["play-game-button"])) {
    // echo "you've succefully clicked the button";
    // On game.php instantiate the Blackjack class twice, insert it into a player variable and a dealer variable
    $player = new Blackjack();
    $dealer = new Blackjack();
    $player->hit();
    echo "player score is $player->score";
    echo "dealer score is $dealer->score";
    $_SESSION["player"] = serialize($player);
    $_SESSION["dealer"] = serialize($dealer);
    ?>
    <form method="POST" action="game.php">
        <input type="checkbox" id="hit" name="player-action" checked>
        <label for="hit">hit</label>
        <input type="checkbox" id="stand" name="player-action">
        <label for="stand">stand</label>
        <input type="checkbox" id="surrender" name="player-action">
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
    // deze nog afhankelijk maken van actie
    $player->hit($player->score);
    echo "player score is $player->score";
    echo "dealer score is $dealer->score";
    $_SESSION["player"] = serialize($player);
    $_SESSION["dealer"] = serialize($dealer);
    // Use forms to send to the game.php page what the player's action is. (i.e. hit/stand/surrender)

    ?>
    <form method="POST" action="game.php">
        <input type="checkbox" id="hit" name="player-action" checked>
        <label for="hit">hit</label>
        <input type="checkbox" id="stand" name="player-action">
        <label for="stand">stand</label>
        <input type="checkbox" id="surrender" name="player-action">
        <label for="surrender">surrender</label>
        <input type="submit">
    </form>
<?php
} else {
    echo "you need to go to the home page and click the button to play";
}
