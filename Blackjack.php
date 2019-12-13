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
