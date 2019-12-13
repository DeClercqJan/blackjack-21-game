<?php
session_start();
// if (isset($_GET["play-game-button"])) {
// echo "test";
require "Blackjack.php";

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

if ($_POST["player-action"] == "hit") {
    // var_dump($_POST);
    // echo "post not empty";

    $card_taken = unserialize($_SESSION["card-taken"]);
    var_dump($card_taken);
    $cards_left = unserialize($_SESSION["cards-left"]);
    // var_dump($cards_left);

    // $card = get_card($cards);
    $card = get_card($cards_left);
    var_dump($card);
    $card->in_deck = false;
    var_dump($card);

    $_SESSION["card-taken"] = serialize($card);
    $_SESSION["cards-left"] = serialize($cards);

    var_dump($cards_left);
    // to make sure card is in deck;
    /*
    if ($card->in_deck = true) {
        echo "in deck";
        $card->in_deck = false;
        // $card->in_deck = false;
        // checken of ik het ook in de array aanpas zo 
        // var_dump($card);
        // var_dump($cards);
        //return $card;
    } else if ($card->in_deck = false) {
        echo "not in deck";
        // get_card($cards);
    }
    */
    // var_dump($card);
    // var_dump($cards);
}

// } else {
//   echo "you need to go the home page first in order to start playing";
// }
