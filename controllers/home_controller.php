<?php

/**
 * Controller to handle requests for the home page
 */
class HomeController implements Controller {
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

        if ($loggedIn) {
            $username = $this->userModel->getUsername();
            $permissions = $this->userModel->getPermissions();
            $admin = $this->userModel->getPermissions() & User::PERMISSIONS['admin'];

            include LAYOUTS . 'navigation.php';
            include LAYOUTS . 'content_start.php';

            // Retrieve list of current games
            $games = $this->userModel->getCurrentGames();

            if ($games && count($games) > 0) {

                // Render view for each game
                include VIEWS . 'ttt/ttt_board_grid_header.php';

                foreach ($games as $game) {
                    showGame($username, $game);
                }

                include VIEWS . 'ttt/ttt_board_grid_footer.php';
            }
            else {
                include VIEWS . 'ttt/ttt_board_empty.php';
            }

            include LAYOUTS . 'content_end.php';
        }
        else {
            include VIEWS . 'home/site_description.php';
            include VIEWS . 'home/entryway.php';
            include HELPERS . 'errors.php';
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
        return getAjax() . <<<JS
    <script>
      "use strict";

      (function () {
        function handleMove(self) {
          var gameElem = self.parentNode.parentNode.parentNode.parentNode;
          var gameId = gameElem.id.split("-")[2];
          var square = self.id.split("-")[2];

          var moveRequest = ajax(
            'index.php?page=move',
            function (responseText) {
              if (responseText) {
                var side = self.className.indexOf("movable-x") >= 0 ? "X" : "O";
                deactivateBoard(gameElem);
                self.innerHTML = side;
              }
            },
            function (responseText) {
              // TODO show error
              console.log(responseText);
            }
          );
          moveRequest.send("game_id=" + gameId + "&square=" + square);
          moveRequest = ajax(
            'index.php?page=move',
            function (responseText) {
              if (responseText) {
                var side = self.className.indexOf("movable-x") >= 0 ? "X" : "O";
                deactivateBoard(gameElem);
                self.innerHTML = side;
              }
            },
            function (responseText) {
              // TODO show error
              console.log(responseText);
            }
          );
        }

        function deactivateBoard(boardElem) {
          boardElem.classList.remove("ttt-board-toplay");
          makeImmovable(boardElem);

          // flip to play here TODO
        }

        function makeImmovable(elem) {
          elem.classList.remove("movable");
          elem.classList.remove("movable-x");
          elem.classList.remove("movable-o");

          if (elem.children.length) {
            for (var i = 0; i < elem.children.length; i++) {
              makeImmovable(elem.children[i]);
            }
          }
        }

        var movableSquares = document.getElementsByClassName("movable");

        for (var i = 0; i < movableSquares.length; i++) {
          movableSquares[i].addEventListener("mouseover", function (e) {
            if (e.target.className.indexOf("movable") >= 0) {
              e.target.innerHTML = e.target.className.indexOf("movable-x") >= 0 ? "X" : "O";
            }
          });

          movableSquares[i].addEventListener("mouseout", function (e) {
            if (e.target.className.indexOf("movable") >= 0) {
              e.target.innerHTML = "";
            }
          });

          movableSquares[i].addEventListener("click", function (e) {
            if (e.target.className.indexOf("movable") >= 0) {
              handleMove(this);
            }
          });
        }  
      })();

    </script>

JS;

    } // end getScript
} // end HomeController

?>
