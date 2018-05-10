<?php

/**
 * Controller to handle requests for new seeks
 */
class NewSeekController implements Controller {
    private $userModel;

    /**
     * Couples this controller with its model
     */
    public function __construct() {

        // Populate this model with a user object
        $this->userModel = new User();
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
        $permissions = $this->userModel->getPermissions();
        $admin = $this->userModel->getPermissions() & User::PERMISSIONS['admin'];

        // Make a new seek
        $seek = new Seeks();

        if ($seek->newSeek($this->userModel->getId())) {

            // Return updated seek view
            // TODO: just return the new seek or JSON
            include VIEWS . 'seeks/format_seeks.php';
            echo formatSeeks($seek->getSeeks(), $this->userModel->getId(), $admin);
        }

        // Seek creation failed
        return false;
    } // end call
} // end NewSeekController

?>
