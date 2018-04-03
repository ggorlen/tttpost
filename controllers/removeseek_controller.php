<?php

/**
 * Controller to handle requests for destroying seeks
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

        // Start a session
        $this->userModel->loadSession();

        // Determine whether user is logged in
        $loggedIn = $this->userModel->loggedIn();

        // Redirect the user to home if not logged in
        if (!$loggedIn || !isset($_POST) || count($_POST) === 0) {
            header("Location: index.php");
        }

        $username = $this->userModel->getUsername();
        $userId = $this->userModel->getId();
        $permissions = $this->userModel->getPermissions();
        $admin = $this->userModel->getPermissions() & User::PERMISSIONS['admin'];

        // Attempt removal of specified seek
        $seek = new Seeks();
        echo $seek->removeSeek((int)$_POST["id"], $this->userModel);
    } // end call
} // end RemoveSeekController

?>
