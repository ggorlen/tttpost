      <nav>
        <ul>
          <?= isset($username) ? ("<li>welcome, <a href=\"" . APP .
          "index.php?page=profile\">" . $username . ($admin ? '</a> [admin]' : '</a>') . "</li>") : '' ?>
          <li><a href="<?= APP . 'index.php' ?>">current games</a></li>
          <li><a href="<?= APP . 'index.php?page=new' ?>">seek</a></li>
          <li><a href="<?= APP . 'index.php?page=logout ' ?>">log out</a></li>
        </ul>
      </nav>
