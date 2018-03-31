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

            foreach ($games as $game) {
                $board = $game->getBoard();
                $startTime = date("Y/m/d h:m A", $game->getStartTime());
                $player1 = $game->getPlayer1();
                $player2 = $game->getPlayer2();
                $currentPlayer = $game->getCurrentPlayer();

                include HELPERS . 'ttt_board.php';
            }
        }
        else {
            include VIEWS . 'home/entryway.php';
            include HELPERS . 'errors.php';
        }

        include LAYOUTS . 'footer.php';
    } // end call
} // end HomeController

?>
