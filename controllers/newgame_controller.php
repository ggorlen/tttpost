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
        include VIEWS . 'newgame/show_seeks.php';

        include LAYOUTS . 'footer.php';
    } // end call
} // end NewGameController

?>
