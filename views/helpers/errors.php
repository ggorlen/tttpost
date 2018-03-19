<?php

if (isset($_POST["errors"])) {
    echo "<div class='error-container'><ul>";

    foreach ($_POST["errors"] as $error) {
        echo "<li class='error'>" . $error . "</li>";
    }

    echo "</ul></div>";
}

?>
