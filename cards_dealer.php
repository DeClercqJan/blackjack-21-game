<?php
echo "dealer cards:";
foreach ($dealer->hand as $card_held) {
    echo "<img src=$card_held->image.jpg style='height: 100px;'>";
}
echo "</br>";
