        <div class="ttt-seeks-container">
          <table>
            <tr>
              <th>
                user
              </th>
              <th>
                created
              </th>
              <th>
                action
              </th>
            </tr>
        <?php
          foreach ($seeks as $seek) {
            echo '<tr class="ttt-seek" id="ttt-seek-' . $seek['id'] . '">
                    <td>
                      ' . $seek['username'] . 
                   '</td>
                    <td>
                      ' . date('Y/m/d h:i A', $seek['timestamp']) .
                   '</td>';
      
            if ($seek['user_id'] === $userId) {
              echo '<td><a href="javascript:void(0)">remove</a></td>';
            }
            else {
              echo '<td><a href="javascript:void(0)">join</a>';

              if ($admin) {
                echo ' [admin <a href="javascript:void(0)">remove</a>]';
              }

              echo '</td>';
            }
      
      
            echo '</tr>';
          }
        ?>
          </table>
        </div>
