<?php

/**
 * Controller to handle requests for registration
 */
class RegisterController implements Controller {
    private $model;

    /**
     * Couples this controller with its model
     */
    public function __construct() {

        // Populate this model with a user object
        $this->model = new User();
    } // end __construct

    /**
     * Executes the controller action
     */
    public function call() {
        $form = array_map("trim", $_POST);
        $username = $form["username"];
        $password = $form["password"];
        $passwordVerify = $form["password-verify"];
        $email = $form["email"];
        $emailVerify = $form["email-verify"];
        $errors = [];
        
        // TODO move validation to the model
        if (!isset($username)) {
            $errors[]= "username required";
        }
        
        if (!preg_match('/^[A-Za-z0-9_-]+$/', $username)) {
            $errors[]= "username can only contain letters, numbers, underscores and dashes";
        }
        
        if (strlen($username) > 20) {
            $errors[]= "username must be less than 20 characters";
        }
        
        if (!isset($password)) {
            $errors[]= "password required";
        }
        
        if (!isset($passwordVerify)) {
            $errors[]= "password verification required";
        }
        
        if ($password !== $passwordVerify) {
            $errors[]= "passwords must match";
        }
        
        if (!isset($email)) {
            $errors[]= "email required";
        }
        
        if (!isset($emailVerify)) {
            $errors[]= "email verification required";
        }
        
        if (isset($email) && isset($emailVerify)) { 
            if ($email !== $emailVerify) {
                $errors[]= "emails must match";
            }
            else {
                $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[]= "invalid email address provided";
                }
            }
        }
        
        if (count($errors) === 0) {
            $user = new User(DBHOST, DBUSER, DBPASS, DATABASE);
        
            if ($user->register($username, $password, $email)) { 
                
                // TODO send confirmation email with unqiue hash
        
                header("Location: index.php");
                exit;
            }
            else {
                $errors[]= "username is already taken.";
            }
        }

        include HELPERS . 'redirect_with_errors.php';
    } // end call
} // end RegisterController

?>
