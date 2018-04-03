<?php

/**
 * Controller to handle requests for the home page
 */
class HomeController {
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
                    $this->showGame($username, $game);
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
     * Creates a game view
     */
    private function showGame($username, $game) {
        $board = $game->getBoard();
        $gameID = $game->getId();
        $startTime = date("Y/m/d h:m A", $game->getStartTime());
        $player1 = $game->getPlayer1();
        $player2 = $game->getPlayer2();
        $player1Username = $game->getPlayer1Username();
        $player2Username = $game->getPlayer2Username();
        $currentPlayer = $game->getCurrentPlayer();
        $toPlay = $currentPlayer === $player1 ? "X" : "O";
        $userHasMove = false;
        
        if ($username === $player1Username && $currentPlayer === $player1 ||
            $username === $player2Username && $currentPlayer === $player2) {
            $userHasMove = true;
        }

        include VIEWS . 'ttt/ttt_board.php';
    } // end showGame

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
        var movableSquares = document.getElementsByClassName("movable");

        for (var i = 0; i < movableSquares.length; i++) {
          movableSquares[i].addEventListener("click", function () {

            // TODO
            var gameId = this
              .parentNode
              .parentNode
              .parentNode
              .parentNode
              .id
              .split("-");
            gameId = gameId[gameId.length-1];

            var square = this.id.split("-");
            square = square[square.length-1];

            var moveRequest = ajax(
              'index.php?page=move',
              function (responseText) {
                console.log(responseText);
                location.reload(); // TODO
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
                console.log(responseText);
                location.reload(); // TODO
              },
              function (responseText) {
                // TODO show error
                console.log(responseText);
              }
            );
          });
        }  
      })();

    </script>

JS;

    } // end getScript
} // end HomeController

?>
