<?php
// VRAAG: moet ik hier ook session_start(); toevoegen?? Wordt ingeladen in een andere pagina, lijkt me. idd, is niet nodig, want krijg anders error
class Blackjack
{
    // Add a property to this class called score. This property should have the value of the player's score at all times.
    public $score = 0;
    public $cards = 0;
    function hit($cards_both)
    {
        // $card = get_card($cards_both);
        $array = get_card($cards_both);
        // TO DO: SOMETIMES THE FIRST ONE IS ALREADY FALSE -> MAKE SURE ONLY TRUE CARDS CAN BE TAKEN
        $card = $array;
        var_dump($card);
        $card->in_deck = false;
        var_dump($card);
        $this->score += $card->points;
    }
    function stand()
    {
        // Stand should end your turn and start the dealer's turn. (Your point total is saved.) 
    }
    function surrender()
    {
        //        Surrender should make you surrender the game. (Dealer wins.)   
    }
}

class Cards
{
    public $type;
    public $points;
    public $in_deck;
    public $name;
    public function Create($name, $points)
    {
        // aha, ik kan hier zomaar aan die points;
        $this->name = $name;
        $this->points = $points;
        $this->in_deck = true;
    }
}

class Hearts extends Cards
{
    public $type = "hearts";
}

class Diamonds extends Cards
{
    public $type = "Diamonds";
    public $name;
    public function Create($name, $points)
    {
        $this->name = $name;
        $this->points = $points;
        $this->in_deck = true;
    }
}

class Spades extends Cards
{
    public $type = "Spades";
    public $name;
    public function Create($name, $points)
    {
        $this->name = $name;
        $this->points = $points;
        $this->in_deck = true;
    }
}

class Clubs extends Cards
{
    public $type = "Clubs";
    public $name;
    public function Create($name, $points)
    {
        $this->name = $name;
        $this->points = $points;
        $this->in_deck = true;
    }
}

// QUESTION: WHERE TO PUT THIS; THE CREATION OF THE CARDS; CAN I RUN THEM ONCE AND KEEP USING THEM OR DO I NEED TO CALL ON THEM GAIN AND AGAIN; DO I NEED TO HAVE IT HERE IN BLACKJACK.PHP OR IN GAME.PHP?
$hearts = [];
$diamonds = [];
$spades = [];
$clubs = [];

for ($i = 2; $i < 11; $i++) {
    $x = new Hearts();
    $x->Create($i, $i);
    array_push($hearts, $x);
}
for ($i = 2; $i < 11; $i++) {
    $x = new Diamonds();
    $x->Create($i, $i);
    array_push($diamonds, $x);
}
for ($i = 2; $i < 11; $i++) {
    $x = new Spades();
    $x->Create($i, $i);
    array_push($spades, $x);
}
for ($i = 2; $i < 11; $i++) {
    $x = new Clubs();
    $x->Create($i, $i);
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
    $jack->Create("jack", 10);
    $jack->type = $type;
    array_push($cards[$key], $jack);
    $queen = new Cards();
    $queen->Create("queen", 10);
    $queen->type = $type;
    array_push($cards[$key], $queen);
    $king = new Cards();
    $king->Create("king", 10);
    $king->type = $type;
    array_push($cards[$key], $king);
    // TO DO: IF TIME AND MAYBE NOT HERE: ACE CAN BE EITHER 1 OR 11
    $ace = new Cards();
    $ace->Create("ace", 1);
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
