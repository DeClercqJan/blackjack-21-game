<?php
// VRAAG: moet ik hier ook session_start(); toevoegen?? Wordt ingeladen in een andere pagina, lijkt me. idd, is niet nodig, want krijg anders error
class Blackjack
{
    // Add a property to this class called score. This property should have the value of the player's score at all times.
    public $score = 0;
    function hit()
    { }
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
    public $type = "hearts";
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
    public $type = "hearts";
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
    public $type = "hearts";
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
    // echo "test $i";
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

// var_dump($hearts);
// var_dump($diamonds);
// var_dump($spades);
// var_dump($clubs);

// hm, deze moet erachter staan, anders werkt het niet
$cards = ["hearts" => $hearts, "diamonds" => $diamonds, "spades" => $spades, "clubs" => $clubs];
// var_dump($cards);

foreach ($cards as $key => $value) {
    // var_dump($key);
    // var_dump($value);
    // echo "test $type";
    $jack = new Cards();
    $jack->Create("jack", 10);
    $jack->type = $key;
    // var_dump($x);
    array_push($cards[$key], $jack);
    $queen = new Cards();
    $queen->Create("queen", 10);
    $queen->type = $key;
    array_push($cards[$key], $queen);
    $king = new Cards();
    $king->Create("king", 10);
    $king->type = $key;
    array_push($cards[$key], $king);
    // TO DO: IF TIME AND MAYBE NOT HERE: ACE CAN BE EITHER 1 OR 11
    $ace = new Cards();
    $ace->Create("ace", 1);
    $ace->type = $key;
    array_push($cards[$key], $ace);
}

var_dump($cards);
