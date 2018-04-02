        <div class="ttt-seeks-container">
        <?php
          foreach ($seeks as $seek) {
            echo '<div class="ttt-seek" id="ttt-seek-' . $seek['id'] . '">
                    <div>
                      user: ' . $seek['username'] . 
                   '</div>
                    <div>
                      created: ' . date('Y/m/d h:i A', $seek['timestamp']) .
                   '</div>';
      
            if ($seek['user_id'] === $userId) {
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
