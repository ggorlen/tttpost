  <h2><?= $username ?></h2>
  <table>  
    <tr>
      <td>wins:</td><td> <?= isset($wins) ? $wins : 0 ?> </td>
    </tr>
    <tr>
      <td>losses:</td><td> <?= isset($losses) ? $losses : 0 ?> </td> 
    </tr>
    <tr>
      <td>draws:</td><td> <?= isset($draws) ? $draws : 0 ?> </td>
    </tr>
  <table>  
