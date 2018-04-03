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
              //location.reload(); // TODO
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
          seeks[i].addEventListener("click", function (e) {
            var id = e.target.parentNode.parentNode.id.split("-");
            id = id[id.length-1];
            
            if (e.target.innerText === "remove") { // TODO brittle
              var self = this;
              var removeSeekRequest = ajax(
                'index.php?page=removeseek', 
                function (responseText) { 
                  console.log(responseText);
                  //self.parentNode.removeChild(self);
                  location.reload(); // TODO
                },
                function (responseText) { 
                  // TODO show error
                  console.log(responseText);
                }
              );
              removeSeekRequest.send("id=" + id);
            }
            else if (e.target.innerText === "join") { // TODO brittle
              //this.parentNode.removeChild(this);
              var joinSeekRequest = ajax(
                'index.php?page=joinseek', 
                function (responseText) { 
                  console.log(responseText);
                  location.reload(); // TODO
                },
                function (responseText) { 
                  // TODO show error
                  console.log(responseText);
                }
              );
              joinSeekRequest.send("id=" + id);
            }
          });
        }
      })();

    </script>

JS;
    } // end getScript
} // end NewGameController

?>
