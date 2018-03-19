<nav>
  <ul>
    <?= isset($username) ? ("<li>welcome, " . $username . ($admin ? ' [administrator]' : '') . "</li>") : '' ?>
    <li><a href="<?= APP . 'index.php' ?>">current games</a></li>
    <li><a href="<?= APP . 'index.php?page=new' ?>">new game</a></li>
    <li><a href="<?= APP . 'index.php?page=profile ' ?>">profile</a></li>
    <li><a href="<?= APP . 'index.php?page=logout ' ?>">log out</a></li>
  </ul>
</nav>
