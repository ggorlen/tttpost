<div class="ttt-board">
  <div>started: <?= $startTime ?></div>
  <div>X: <?= $player1 ?></div>
  <div>O: <?= $player2 ?></div>
  <div>to play: <?= $currentPlayer ?></div>

  <table>

    <?php
    foreach ($board as $i => $square) {
        if ($i % 3 === 0) {
            echo "<tr>";
        }

        echo "<td>$square</td>";

        if ($i % 3 === 2) {
            echo "</tr>";
        }
    }
    ?>

  </table>
</div>
