<?php

/**
 * Controller for seeks
 */
class SeeksController implements Controller {
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
        include LAYOUTS . 'header.php';
        include LAYOUTS . 'title.php';
        include LAYOUTS . 'navigation.php';
        include LAYOUTS . 'content_start.php';

        $seekModel = new Seeks();
        $seeks = $seekModel->getSeeks();

        // Show link to make new seek and list of available seeks
        include VIEWS . 'seeks/new_seek.php';

        if ($seeks) {
            include VIEWS . 'seeks/format_seeks.php';
            echo formatSeeks($seeks, $userId, $admin);
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
        function handleNewSeek(responseText) {

          // TODO just prepare the one new node
          var html = responseText.split("\\n");
          seeksContainer.innerHTML = html.slice(1, html.length - 1).join("\\n");
          prepareSeekNodes();
        }

        function handleNewSeekFailure(responseText) {

          // TODO
          console.log(responseText);
        }

        function prepareSeekNode(node) {
          node.addEventListener("click", function (e) {
            var self = this;
            var id = e.target.parentNode.parentNode.id.split("-");
            id = id[id.length-1];
            
            if (e.target.innerText.indexOf("remove") >= 0) { // TODO brittle
              var removeSeekRequest = ajax(
                'index.php?page=removeseek', 
                function (responseText) { 
                  self.parentNode.removeChild(self);
                },
                function (responseText) { 
                  // TODO show error
                  console.log(responseText);
                }
              );
              removeSeekRequest.send("id=" + id);
            }
            else if (e.target.innerText.indexOf("join") >= 0) { // TODO brittle
              var joinSeekRequest = ajax(
                'index.php?page=joinseek', 
                function (responseText) { 
                  self.parentNode.removeChild(self);
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

        function prepareSeekNodes() {  
          var seeks = document.getElementsByClassName("ttt-seek");
        
          for (var i = 0; i < seeks.length; i++) {
            prepareSeekNode(seeks[i]);
          }
        }

        var newSeek = document.getElementById("ttt-new-seek-btn");
        var seeksContainer = document.getElementById("ttt-seeks-container");

        newSeek.addEventListener("click", function () {
          var newSeekRequest = ajax(
            'index.php?page=newseek', 
            handleNewSeek, 
            handleNewSeekFailure
          );
          newSeekRequest.send();
          newSeekRequest = ajax(
            'index.php?page=newseek', 
            handleNewSeek, 
            handleNewSeekFailure
          );
        });

        prepareSeekNodes();
      })();

    </script>

JS;
    } // end getScript
} // end NewGameController

?>
