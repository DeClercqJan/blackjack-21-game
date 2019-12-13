<?php
session_start();
require "Blackjack.php";

var_dump($_GET);
var_dump($_POST);

if (empty($_GET) && empty($_POST)) {
    echo "you need to go the home page first in order to start playing";
} else if (!empty($_GET) && empty($_POST)) {
    if ($_GET["play-game-button"] == "Submit Query") {
        include "form.html";
        $player = new Blackjack();
        // var_dump($player);
        $player->hit($cards);
        var_dump($player);
        $_SESSION["player"] = serialize($player);
        // $_SESSION["cards-left"] = serialize($cards);
        // var_dump($cards);
        $dealer = new Blackjack();
        $dealer->hit($cards);
        var_dump($dealer);
        var_dump($cards);
        $_SESSION["dealer"] = serialize($dealer);
        $_SESSION["cards-left"] = serialize($cards);
    }
} else if (empty($_GET) && !empty($_POST)) {
    echo "you have clicked some button";
    include "form.html";
    if ($_POST["player-action"] == "hit") {
        $player = unserialize($_SESSION["player"]);
        // var_dump($player);
        $cards_left = unserialize($_SESSION["cards-left"]);
        $player->hit($cards_left);
        // var_dump($cards_left);
        var_dump($player);
        // OPSLAAN IN SESSIE OF COOKIE OP HET EINDE!
        $_SESSION["cards-left"] = serialize($cards_left);
        $_SESSION["player"] = serialize($player);
    }
}
