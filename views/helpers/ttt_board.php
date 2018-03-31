<div class="ttt-board" id="ttt-game-<?= $gameID ?>">
  <table>

    <?php
    foreach ($board as $i => $square) {
        if ($i % 3 === 0) {
            echo "<tr>\n";
        }

        echo "<td" . ($square === " " && $userHasMove ? ' class="movable"' : "") . 
             " id=\"ttt-square-$i\">$square</td>\n";

        if ($i % 3 === 2) {
            echo "</tr>\n";
        }
    }
    ?>

  </table>

  <div>started: <?= $startTime ?></div>
  <div>X: <?= $player1Username ?></div>
  <div>O: <?= $player2Username ?></div>
  <div>to play: <?= $toPlay ?></div>

</div>
