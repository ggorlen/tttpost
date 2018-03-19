<!DOCTPE html>
<html lang="en">
  <head>
    <title>...</title>
  </head>
  <body>
    <!-- Reference: https://stackoverflow.com/a/5576700/6243352 -->
    <form id="redirect" action="index.php" method="post">
      <?php
      foreach ($errors as $i => $error) {
          echo '<input type="hidden" name="errors[' . $i . ']" value="' . htmlentities($error) . '">';
      }
      ?>
      <noscript><input type="submit" value="Click here if you are not redirected"/></noscript>
    </form>
    <script>document.getElementById('redirect').submit();</script>
  </body>
</html>
