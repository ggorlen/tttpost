<?php

/**
 * Controller to handle requests for new seeks
 */
class MoveController implements Controller {
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
        if (!$loggedIn || count($_POST) < 2 || 
            !isset($_POST["game_id"]) || 
            !isset($_POST["square"])) {
            header("Location: index.php");
        }

        $username = $this->userModel->getUsername();
        $permissions = $this->userModel->getPermissions();
        $admin = $this->userModel->getPermissions() & User::PERMISSIONS['admin'];

        // Make game object by id and apply move to it
        $game = $this->userModel->getGameById((int)$_POST["game_id"]);
        echo $game->move((int)$this->userModel->getId(), (int)$_POST["square"]);

        // return the new board or false

    } // end call
} // end MoveController

?>
