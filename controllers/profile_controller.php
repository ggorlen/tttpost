<?php

/**
 * Controller to handle requests for the profile page
 */
class ProfileController implements Controller {
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

        // Redirect the user home if not logged in
        if (!$loggedIn) {
            header("Location: index.php");
        }

        // Retrieve username and permissions from the model
        $username = $this->userModel->getUsername();
        $permissions = $this->userModel->getPermissions();
        $admin = $this->userModel->getPermissions() & User::PERMISSIONS['admin'];

        // Retrieve stats info
        $stats = new Stats($this->userModel->getId());
        $wins = $stats->getWins();
        $losses = $stats->getLosses();
        $draws = $stats->getDraws();

        include LAYOUTS . 'header.php';
        include LAYOUTS . 'title.php';
        include LAYOUTS . 'navigation.php';
        include LAYOUTS . 'content_start.php';
        include VIEWS . 'profile/profile.php';

            // Retrieve list of current games
            $games = $this->userModel->getCompletedGames();

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
        include LAYOUTS . 'footer.php';
        include LAYOUTS . 'end.php';
    } // end call
} // end ProfileController

?>
