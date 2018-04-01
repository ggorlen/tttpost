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

        // Check for requests for joining and creating seeks
        if (isset($_POST) && count($_POST) > 0) {
            var_dump($_POST);
        }

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

        $seekModel = new Seeks();
        $seeks = $seekModel->getSeeks();

        // Show link to make new seek and list of available seeks
        include VIEWS . 'newgame/new_seek.php';

        if ($seeks) {
            $seeks = array_reverse($seekModel->getSeeks());
            include VIEWS . 'newgame/show_seeks.php';
        }

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
        return <<<JS
    <script>
      "use strict";

      function ajax(url, onSuccess, onFailure, requestType, contentType) {
        var request = new XMLHttpRequest();

        request.onreadystatechange = function () {
          if (request.readyState === 4) {
            if (request.status === 200) {
              onSuccess(request.responseText);
            }
            else {
              onFailure(request.responseText);
            }
          }
        };

        request.open(requestType ? requestType : "post", url);
        request.setRequestHeader(
          "Content-type", 
          contentType ? contentType : "application/x-www-form-urlencoded"
        );
        return request;
      }

      (function () {
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
        var newSeek = document.getElementById("ttt-new-seek-btn");

        newSeek.addEventListener("click", function () {
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
          (function() {
            var removeSeekRequest = ajax(
              'index.php?page=removeseek', 
              function (responseText) { 
              },
              function (responseText) { 
                // TODO show error
                console.log(responseText);
              }
            );
            var seeksId = seeks[i].id.split("-");
            seeks[i].addEventListener("click", function (e) {
              if (e.target.innerText === "remove seek") { // TODO brittle
                this.parentNode.removeChild(this);
                removeSeekRequest.send("id=" + seeksId[seeksId.length-1]);
              }
            });
          })();
        }
      })();

    </script>

JS;
    } // end getScript
} // end NewGameController

?>
