<?php
session_start();
// echo "test game.php";
// var_dump($_GET);
if (isset($_GET["play-game-button"])) {
    // echo "you've succefully clicked the button";
    // On game.php instantiate the Blackjack class twice, insert it into a player variable and a dealer variable
    require("Blackjack.php");
    $player = new Blackjack();
    $dealer = new Blackjack();
    $_SESSION["player"] = $player;
    $_SESSION["dealer"] = $dealer;
    echo $player->hit();
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
    require("Blackjack.php");
    var_dump($_SESSION["player"]);
    var_dump($_SESSION["dealer"]);
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
