        <div class="profile-container">
          <div class="profile-item">
            <h2><?= $username ?></h2>
          </div>
          <div class="profile-item">
            <table>  
              <tr>
                <td>wins:</td><td> <?= isset($wins) ? $wins : "n/a" ?> </td>
              </tr>
              <tr>
                <td>losses:</td><td> <?= isset($losses) ? $losses : "n/a" ?> </td> 
              </tr>
              <tr>
                <td>draws:</td><td> <?= isset($draws) ? $draws : "n/a" ?> </td>
              </tr>
            </table>  
          </div>
        </div>
