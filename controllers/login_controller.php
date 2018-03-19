<?php

/**
 * Controller to handle requests for logins
 */
class LoginController implements Controller {
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

        // Start a session
        $user = $this->model;
        $user->loadSession();

        if ($user->loggedIn()) {
            $user->logout();
        }

        $form = array_map("trim", $_POST);
        $errors = [];
        
        if (!isset($form["username"]) || strlen($form["username"]) === 0) {
            $errors[]= "username required";
        }
        
        if (!isset($form["password"]) || strlen($form["password"]) === 0) {
            $errors[]= "password required";
        }
        
        if (count($errors) === 0) { 
            if ($user->login($form["username"], $form["password"])) {
                header("Location: index.php");
                exit;
            }
            else {
                $errors[]= "invalid username or password";
            }
        }

        include HELPERS . 'redirect_with_errors.php';

    } // end call
} // end LoginController

?>
