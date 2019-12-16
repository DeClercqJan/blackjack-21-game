<?php
session_start();
if (!isset($_COOKIE["games-lost"])) {
    setcookie("games-lost", 0);
}
if (!isset($_COOKIE["games-won"])) {
    setcookie("games-won", 0);
}
require "Blackjack.php";


if (empty($_GET) && empty($_POST)) {
    echo "you need to go the home page first in order to start playing";
} else if (!empty($_GET) && empty($_POST)) {
    if ($_GET["play-game-button"] == "Submit Query") {
        $player = new Blackjack();
        // var_dump($player);
        $player->hit($cards);
        // var_dump($card_image_url);
        // var_dump($player);
        // var_dump($player);
        $_SESSION["player"] = serialize($player);
        // $_SESSION["cards-left"] = serialize($cards);
        // var_dump($cards);
        $dealer = new Blackjack();
        $dealer->hit($cards);
        // var_dump($dealer);
        // var_dump($dealer);
        // var_dump($cards);
        include "form.php";
        include  "cards_player.php";
        $_SESSION["dealer"] = serialize($dealer);
        $_SESSION["cards-left"] = serialize($cards);
    }
} else if (empty($_GET) && !empty($_POST)) {
    include "form.php";
    if ($_POST["player-action"] == "hit") {
        $player = unserialize($_SESSION["player"]);
        // var_dump($player);
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
