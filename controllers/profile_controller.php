<?php

/**
 * Controller to handle requests for the profile page
 */
class ProfileController implements Controller {
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

        // Redirect the user home if not logged in
        if (!$loggedIn) {
            header("Location: index.php");
        }

        // Retrieve username and permissions from the model
        $username = $this->model->getUsername();
        $permissions = $this->model->getPermissions();
        $admin = $this->model->getPermissions() & User::PERMISSIONS['admin'];

        // Retrieve (TODO: profile) and stats info
        $stats = new Stats($this->model);
        $wins = $stats->getWins();
        $losses = $stats->getLosses();
        $draws = $stats->getDraws();

        include LAYOUTS . 'navigation.php';
        include VIEWS . 'profile/profile.php';
        include LAYOUTS . 'footer.php';
    } // end call
} // end ProfileController

?>
