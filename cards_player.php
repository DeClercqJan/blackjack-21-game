<?php
// var_dump($player);
// var_dump($dealer);
echo "player cards:";
foreach ($player->hand as $card_held) {
    echo "<img src=$card_held->image.jpg style='height: 100px;'>";
}
echo "</br>";

