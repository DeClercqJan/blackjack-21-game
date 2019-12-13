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
    public $points;
    public $in_deck;
}

class Hearts extends Cards
{
    public $type = "hearts";
    public $name;
    public function Create($name, $points)
    {
        $this->name = $name;
        // aha, ik kan hier zomaar aan die points;
        $this->points = $points;
        $this->in_deck = true;
    }
}

$test = new Hearts();
$test->Create("ace", 15);
var_dump($test);

$hearts = [];
for ($i = 2; $i < 11; $i++) {
    echo "test $i";
    $test = new Hearts();
    $test->Create($i, $i);
    array_push($hearts, $test);
}

// will only run once
$hearts_ace = new Hearts();
// TO DO (ACE CAN BE 11)
$hearts_ace->Create("ace", 1);

    


var_dump($hearts);

$cards = [];
array_push($cards, $hearts);
var_dump($cards);
