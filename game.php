<?php
echo "test game.php";
var_dump($_GET);
if (isset($_GET["play-game-button"])) {
    echo "you've succefully clicked the button";
} else {
    echo "you need to go to the home page and click the button to play";
}
require("Blackjack.php");
// On game.php instantiate the Blackjack class twice, insert it into a player variable and a dealer variable
