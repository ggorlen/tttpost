<?php

/**
 * Controller to handle requests for new games
 */
class NewGameController {
    private $userModel;

    /**
     * Couples this controller with its model
     */
    public function __construct() {

        // Populate this model with a user object
        $this->userModel = new User(DBHOST, DBUSER, DBPASS, DATABASE);
    } // end __construct

    /**
     * Executes the controller action
     */
    public function call() {
        include LAYOUTS . 'header.php';
        include LAYOUTS . 'title.php';

        // Start a session
        $this->userModel->loadSession();

        // Determine whether user is logged in
        $loggedIn = $this->userModel->loggedIn();

        // Redirect the user to home if not logged in
        if (!$loggedIn) {
            header("Location: index.php");
        }

        $username = $this->userModel->getUsername();
        $userId = $this->userModel->getId();
        $permissions = $this->userModel->getPermissions();
        $admin = $this->userModel->getPermissions() & User::PERMISSIONS['admin'];
        include LAYOUTS . 'navigation.php';
        include LAYOUTS . 'content_start.php';

        $seekModel = new Seeks();
        $seeks = $seekModel->getSeeks();

        // Show link to make new seek and list of available seeks
        include VIEWS . 'newgame/new_seek.php';

        if ($seeks) {
            $seeks = array_reverse($seeks);
            include VIEWS . 'newgame/show_seeks.php';
        }

        include LAYOUTS . 'content_end.php';
        include LAYOUTS . 'footer.php';
        echo $this->getScript();
        include LAYOUTS . 'end.php';
    } // end call

    /**
     * Returns the script associated with this controller
     *
     * @return string script
     */
    private function getScript() {
        return getAjax() . <<<JS
    <script>
      "use strict";

      (function () {
        var newSeek = document.getElementById("ttt-new-seek-btn");

        newSeek.addEventListener("click", function () {
          var newSeekRequest = ajax(
            'index.php?page=newseek', 
            function (responseText) { 
              location.reload(); // TODO
            },
            function (responseText) { 
              // TODO show error
              console.log(responseText);
            }
          );
          newSeekRequest.send();
          newSeekRequest = ajax(
            'index.php?page=newseek', 
            function (responseText) { 
              location.reload(); // TODO
            },
            function (responseText) { 
              // TODO show error
              console.log(responseText);
            }
          );
        });

        var seeksContainer = document.getElementsByClassName("ttt-seeks-container")[0];
        var seeks = document.getElementsByClassName("ttt-seek");

        for (var i = 0; i < seeks.length; i++) {
          var seeksId = seeks[i].id.split("-");
          seeks[i].addEventListener("click", function (e) {
            
            if (e.target.innerText === "remove seek") { // TODO brittle
              this.parentNode.removeChild(this);
              var removeSeekRequest = ajax(
                'index.php?page=removeseek', 
                function (responseText) { 
                },
                function (responseText) { 
                  // TODO show error
                  console.log(responseText);
                }
              );
              removeSeekRequest.send("id=" + seeksId[seeksId.length-1]);
            }
            else if (e.target.innerText === "join game") { // TODO brittle
              //this.parentNode.removeChild(this);
              var joinSeekRequest = ajax(
                'index.php?page=joinseek', 
                function (responseText) { 
                  location.reload(); // TODO
                },
                function (responseText) { 
                  // TODO show error
                  console.log(responseText);
                }
              );
              joinSeekRequest.send("id=" + seeksId[seeksId.length-1]);
            }
          });
        }
      })();

    </script>

JS;
    } // end getScript
} // end NewGameController

?>
