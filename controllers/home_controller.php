<?php

/**
 * Controller to handle requests for the home page
 */
class HomeController {
    private $model;

    /**
     * Couples this controller with its model
     */
    public function __construct() {

        // Populate this model with a user object
        $this->model = new User(DBHOST, DBUSER, DBPASS, DATABASE);
    } // end __construct

    /**
     * Executes the controller action
     */
    public function call() {
        include LAYOUTS . 'header.php';
        include LAYOUTS . 'title.php';

        // Start a session
        $this->model->loadSession();

        // Determine whether user is logged in
        $loggedIn = $this->model->loggedIn();

        if ($loggedIn) {
            $username = $this->model->getUsername();
            $permissions = $this->model->getPermissions();
            $admin = $this->model->getPermissions() & User::PERMISSIONS['admin'];

            include LAYOUTS . 'navigation.php';

            // Retrieve list of current games
            $games = $this->model->getCurrentGames();

            if ($games && count($games) > 0) {

                // Render view for each game
                include VIEWS . 'ttt/ttt_board_grid_header.php';

                foreach ($games as $game) {
                    $this->showGame($username, $game);
                }

                include VIEWS . 'ttt//ttt_board_grid_footer.php';
            }
        }
        else {
            include VIEWS . 'home/entryway.php';
            include HELPERS . 'errors.php';
        }

        include LAYOUTS . 'footer.php';
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
} // end HomeController

?>
