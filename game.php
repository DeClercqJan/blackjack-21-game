<?php
session_start();
require "Blackjack.php";

// pretty version of var_dump
function var_dump_pretty($variable)
{
    echo '<pre>';
    var_dump($variable);
    echo '</pre>';
}

// if (!isset($_COOKIE["games-lost"])) {
//     setcookie("games-lost", 0);
// }
// if (!isset($_COOKIE["games-won"])) {
//     setcookie("games-won", 0);
// }

if (isset($_COOKIE)) {
    // var_dump_pretty($_COOKIE);
    $players_array_before = unserialize($_COOKIE["players_array"]);
    // var_dump_pretty($players_array_before);
}
var_dump_pretty(unserialize($_SESSION["player"]));
var_dump_pretty(unserialize($_SESSION["dealer"]));

// check to make sure people don't load the page game.php directly, not following to foreseen flow
if (empty($_GET) && empty($_POST)) {

    echo "you need to go the home page first in order to start playing";

    // check to serve people who have just filled out their name on the index page and want to start playing but haven't made any other action decision yet

} else if (!empty($_GET) && empty($_POST)) {
    if ($_GET["play-game-button"] == "Submit Query") {
        $player = new Player($_GET["playerName"], 0, 0);
        $player->hit($cards);
        $_SESSION["player"] = serialize($player);
        $dealer = new player("dealer", 0, 0);
        $dealer->hit($cards);
        include "form.php";
        include  "cards_player.php";
        $_SESSION["dealer"] = serialize($dealer);
        $_SESSION["cards-left"] = serialize($cards);
    }
    // actions if player have already clicked an action button such as "hit"
} else if (empty($_GET) && !empty($_POST)) {
    include "form.php";
    if ($_POST["player-action"] == "hit") {
        $player = unserialize($_SESSION["player"]);
        $dealer = unserialize($_SESSION["dealer"]);
        $cards_left = unserialize($_SESSION["cards-left"]);
        $player->hit($cards_left);
        if (isset($_SESSION["game-has-been-reset"]) && $_SESSION["game-has-been-reset"] == true) {
            echo "game has been reset <br>";
            $_SESSION["game-has-been-reset"] = false;
            $dealer->hit($cards_left);
            // var_dump($cards_left);
            $_SESSION["dealer"] = serialize($dealer);
        }
        // var_dump($cards_left);
        // var_dump($player);
        // OPSLAAN IN SESSIE OF COOKIE OP HET EINDE!
        include "cards_player.php";
        $_SESSION["cards-left"] = serialize($cards_left);
        $_SESSION["player"] = serialize($player);
        check_result($player, $dealer);
    } else if ($_POST["player-action"] == "stand") {
        $player = unserialize($_SESSION["player"]);
        $dealer = unserialize($_SESSION["dealer"]);
        $cards_left = unserialize($_SESSION["cards-left"]);
        if (isset($_SESSION["game-has-been-reset"]) && $_SESSION["game-has-been-reset"] == true) {
            echo "game has been reset <br>";
            $_SESSION["game-has-been-reset"] = false;
            $player->hit($cards_left);
            // var_dump($cards_left);
            $_SESSION["player"] = serialize($player);
        }
        while ($dealer->score < 15) {
            $dealer->hit($cards_left);
        }
        include  "cards_player.php";
        // include "cards_dealer.php";
        $_SESSION["cards-left"] = serialize($cards_left);
        $_SESSION["dealer"] = serialize($dealer);
        check_result($player, $dealer);
    } else if ($_POST["player-action"] == "surrender") {
        // var_dump($player);
        $player = unserialize($_SESSION["player"]);
        // var_dump($player);
        $dealer = unserialize($_SESSION["dealer"]);
        // var_dump($dealer);
        $cards_left = unserialize($_SESSION["cards-left"]);
        if (isset($_SESSION["game-has-been-reset"]) && $_SESSION["game-has-been-reset"] == true) {
            echo "game has been reset <br>";
            $_SESSION["game-has-been-reset"] = false;
            $player->hit($cards_left);
            // var_dump($cards_left);
            $_SESSION["player"] = serialize($player);
        }
        while ($dealer->score < 15) {
            $dealer->hit($cards_left);
        }
        // var_dump($dealer);  
        $player->surrender();
        echo "you surrendered so you lost. When you clicked the button, you had $player->score. The dealer would have had $dealer->score <br>";
        include "cards_player.php";
        include "cards_dealer.php";
        // var_dump($player);
        // var_dump($dealer);
    }
}
