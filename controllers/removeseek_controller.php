<?php

/**
 * Controller to handle requests for new seeks
 */
class RemoveSeekController {
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
        }

        // Start a session
        $this->userModel->loadSession();

        // Determine whether user is logged in
        $loggedIn = $this->userModel->loggedIn();

        // Redirect the user to home if not logged in
        if (!$loggedIn) {
            header("Location: index.php");
        }

        $username = $this->userModel->getUsername();
        $permissions = $this->userModel->getPermissions();
        $admin = $this->userModel->getPermissions() & User::PERMISSIONS['admin'];

        // Make a new seek
        $seek = new Seeks();
        echo $seek->newSeek($this->userModel->getId());
    } // end call
} // end NewSeekController

?>
