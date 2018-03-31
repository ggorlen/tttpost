<div class="ttt-seeks-container">
  <?php
    foreach ($seeks as $seek) {
      echo '<div class="ttt-seek" id="' . $seek['id'] . '">
              <div>
                user: ' . $seek['username'] . 
             '</div>
              <div>
                time: ' . date('Y/m/d h:iA', $seek['timestamp']) .
             '</div>';

      if ($seek['id'] === $userId) {
        echo '<div><a href="#">remove seek</a></div>';
      }
      else {
        echo '<div><a href="#">join game</a></div>';
      }

      if ($admin) {
        echo '<div>[ admin <a href="#">remove seek</a> ]</div>';
      }

      echo '</div>';
    }
  ?>
</div>
