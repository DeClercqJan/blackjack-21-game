<?php
// VRAAG: moet ik hier ook session_start(); toevoegen?? Wordt ingeladen in een andere pagina, lijkt me. idd, is niet nodig, want krijg anders error
class Player
{
    // Add a property to this class called score. This property should have the value of the player's score at all times.
    public $score = 0;
    public $hand = [];
    public $cards_amount = 0;
    public $name = "";
    public $wins = 0;
    public $losses = 0;

    public function __construct(string $name, int $previous_wins, int $previous_losses)
    {
        $this->name = $name;
        $this->wins = $previous_wins;
        $this->losses = $previous_losses;
    }

    function hit($cards_both)
    {
        $array = get_card($cards_both);
        // TO DO: SOMETIMES THE FIRST ONE IS ALREADY FALSE -> MAKE SURE ONLY TRUE CARDS CAN BE TAKEN
        $card = $array;
        $card->in_deck = false;
        $this->score += $card->points;
        $this->cards_amount++;
        array_push($this->hand, $card);
        return $card;
    }
    function stand()
    {
        // Stand should end your turn and start the dealer's turn. (Your point total is saved.) 
    }
    function surrender()
    {
        //        Surrender should make you surrender the game. (Dealer wins.)   
        save_lose();
        reset_game();
    }
    function add_win()
    {
        $this->wins = $this->wins + 1;
    }
    function add_loss()
    {
        $this->losses = $this->wins + 1;
    }
}

class Cards
{
    public $type;
    public $points;
    public $in_deck;
    public $name;
    public function Create($name, $points, $type)
    {
        $this->name = $name;
        $this->points = $points;
        $this->in_deck = true;
        // changing names to fit image database names
        $type_1 = strtoupper(substr($type, 0, 1));
        $name_1 = strtoupper(substr($name, 0, 1));
        $this->image = "/images/cards/$name_1$type_1";
    }
    public $image;
}

class Hearts extends Cards
{
    public $type = "hearts";
    public function Create($name, $points, $type)
    {
        $this->name = $name;
        $this->points = $points;
        $this->in_deck = true;
        if ($name == 10) {
            $name_1 = strtoupper(substr($name, 0, 2));
        } else {
            $name_1 = strtoupper(substr($name, 0, 1));
        }
        $type_1 = strtoupper(substr($type, 0, 1));
        $this->image = "/images/cards/$name_1$type_1";
    }
}

class Diamonds extends Cards
{
    public $type = "Diamonds";
    public $name;
    public function Create($name, $points, $type)
    {
        $this->name = $name;
        $this->points = $points;
        $this->in_deck = true;
        if ($name == 10) {
            $name_1 = strtoupper(substr($name, 0, 2));
        } else {
            $name_1 = strtoupper(substr($name, 0, 1));
        }
        $type_1 = strtoupper(substr($type, 0, 1));
        $this->image = "/images/cards/$name_1$type_1";
    }
}

class Spades extends Cards
{
    public $type = "Spades";
    public $name;
    public function Create($name, $points, $type)
    {
        $this->name = $name;
        $this->points = $points;
        $this->in_deck = true;
        $type_1 = strtoupper(substr($type, 0, 1));
        if ($name == 10) {
            $name_1 = strtoupper(substr($name, 0, 2));
        } else {
            $name_1 = strtoupper(substr($name, 0, 1));
        }
        $this->image = "/images/cards/$name_1$type_1";
    }
}

class Clubs extends Cards
{
    public $type = "Clubs";
    public $name;
    public function Create($name, $points, $type)
    {
        $this->name = $name;
        $this->points = $points;
        $this->in_deck = true;
        $type_1 = strtoupper(substr($type, 0, 1));
        if ($name == 10) {
            $name_1 = strtoupper(substr($name, 0, 2));
        } else {
            $name_1 = strtoupper(substr($name, 0, 1));
        }
        $this->image = "/images/cards/$name_1$type_1";
    }
}

// QUESTION: WHERE TO PUT THIS; THE CREATION OF THE CARDS; CAN I RUN THEM ONCE AND KEEP USING THEM OR DO I NEED TO CALL ON THEM GAIN AND AGAIN; DO I NEED TO HAVE IT HERE IN BLACKJACK.PHP OR IN GAME.PHP?
$hearts = [];
$diamonds = [];
$spades = [];
$clubs = [];

for ($i = 2; $i < 11; $i++) {
    $x = new Hearts();
    $x->Create($i, $i, "hearts");
    array_push($hearts, $x);
}
for ($i = 2; $i < 11; $i++) {
    $x = new Diamonds();
    $x->Create($i, $i, "diamonds");
    array_push($diamonds, $x);
}
for ($i = 2; $i < 11; $i++) {
    $x = new Spades();
    $x->Create($i, $i, "spades");
    array_push($spades, $x);
}
for ($i = 2; $i < 11; $i++) {
    $x = new Clubs();
    $x->Create($i, $i, "clubs");
    array_push($clubs, $x);
}

// hm, deze moet erachter staan, anders werkt het niet
// ook: associative array niet zo interessant als ik random number wil bepalen
// $cards = ["hearts" => $hearts, "diamonds" => $diamonds, "spades" => $spades, "clubs" => $clubs];
$cards = [$hearts, $diamonds, $spades, $clubs];

foreach ($cards as $key => $value) {
    // NOTE: because these are created this way, their class is cards, not hearts ...
    switch ($key) {
        case 0:
            $type = "hearts";
            break;
        case 1:
            $type = "diamonds";
            break;
        case 2:
            $type = "spades";
            break;
        case 3:
            $type = "clubs";
            break;
    }
    $jack = new Cards();
    $jack->Create("jack", 10, $type);
    $jack->type = $type;
    array_push($cards[$key], $jack);
    $queen = new Cards();
    $queen->Create("queen", 10, $type);
    $queen->type = $type;
    array_push($cards[$key], $queen);
    $king = new Cards();
    $king->Create("king", 10, $type);
    $king->type = $type;
    array_push($cards[$key], $king);
    // TO DO: IF TIME AND MAYBE NOT HERE: ACE CAN BE EITHER 1 OR 11
    $ace = new Cards();
    $ace->Create("ace", 1, $type);
    $ace->type = $type;
    array_push($cards[$key], $ace);
}

function get_card($cards)
{
    // CHANGED THIS BECAUSE IT'S EASIER TO WORK WITH SOME PREDICTABILITY
    // $card = $cards[rand(0, 3)][rand(0, 12)];
    $card = $cards[0][rand(0, 12)];
    return $card;
}

function check_result($player, $dealer)
{
    if ($player->score > 21) {
        include "cards_dealer.php";
        echo "you lose, because you have $player->score.";
        save_lose();
        reset_game();
    }
    if ($player->score == 21 && $player->cards_amount == 2) {
        // note: did not check if this works!
        include "cards_dealer.php";
        echo "Blackjack! you win, because you have $player->score with only $player->cards cards!";
        save_win();
        reset_game();
    }
    if ($dealer->score > 21) {
        include "cards_dealer.php";
        echo "you win, because the dealer has $dealer->score.";
        save_lose();
        reset_game();
    }
    if ($_POST["player-action"] == "stand") {
        if ($player->score > $dealer->score) {
            include "cards_dealer.php";
            echo "you win, because you have $player->score and the dealer has $dealer->score";
            save_win();
            reset_game();
        } else if ($player->score < $dealer->score) {
            include "cards_dealer.php";
            echo "you lose, because you have $player->score and the dealer has $dealer->score";
            save_lose();
            reset_game();
        } else if ($player->score == $dealer->score) {
            echo "you lose, because you in case a draw, the dealer wins. You and the dealer had $player->score and $dealer->score";
            save_lose();
            reset_game();
        }
    }
}

function save_lose()
{
    // $games_lost_previous = $_COOKIE["games-lost"];
    // $games_lost_new = (int) $games_lost_previous + 1;
    // setcookie("games-lost", $games_lost_new);
    $player = unserialize($_SESSION["player"]);
    $dealer = unserialize($_SESSION["dealer"]);
    $player->add_loss();
    $dealer->add_win();
    $_SESSION["player"] = serialize($player);
    $_SESSION["dealer"] = serialize($dealer);
}


function save_win()
{
    // $games_won_previous = $_COOKIE["games-won"];
    // $games_won_new = (int) $games_won_previous + 1;
    // setcookie("games-won", $games_won_new);
    $player = unserialize($_SESSION["player"]);
    $dealer = unserialize($_SESSION["dealer"]);
    $player->add_wins();
    $dealer->add_loss();
    $_SESSION["player"] = serialize($player);
    $_SESSION["dealer"] = serialize($dealer);
}

function reset_game()
{
    // note: reset to same conditions as when originally started the game: alle cards back in the pile, player and dealer each get one, score is zero. edit: giving each player a card has been put elsewhere in order so that the flow remains logical for player and they don't get 2 cards when pressing on hit
    $cards = unserialize($_SESSION["cards-left"]);
    foreach ($cards as $type) {
        foreach ($type as $card) {
            $card->in_deck = true;
        }
    }
    $player = unserialize($_SESSION["player"]);
    $dealer = unserialize($_SESSION["dealer"]);
    $player->score = 0;
    $dealer->score = 0;
    $player->cards_amount = 0;
    $dealer->cards_amount = 0;
    $player->hand = [];
    $dealer->hand = [];
    $_SESSION["player"] = serialize($player);
    $_SESSION["dealer"] = serialize($dealer);
    $_SESSION["cards-left"] = serialize($cards);
    $_SESSION["game-has-been-reset"] = true;
    // echo "game has been reset";
}
