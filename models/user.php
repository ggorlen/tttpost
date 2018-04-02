<?php

/**
 * Represents a user
 */
class User {
    public const PERMISSIONS = [
        "user"  => 1 << 0, // TODO new users will default to 0 but after confirming email will be set to permission 1
        "admin" => 1 << 7
    ];

    private const TABLE_NAME = 'ttt_users';

    private $id;
    private $username;
    private $email;
    private $password;
    private $permissions;
    private $session;
    private $db;

    /**
     * Constructor for a User
     *
     * @param $dbhost the hostname of the database
     * @param $dbuser the username for the database connection
     * @param $dbpass the password for the database
     * @param $database the name of the database
     * @return a User instance
     */
    public function __construct($dbhost, $dbuser, $dbpass, $database) {
        $this->session = new Session($dbhost, $dbuser, $dbpass, $database);
        $this->db = new DB($dbhost, $dbuser, $dbpass, $database);
        unset($dbhost, $dbuser, $dbpass, $database);
    } // end __construct

    /**
     * Getter for id
     *
     * @return int $id
     */
    public function getId() {
        return $this->id;
    } // end getId

    /**
     * Getter for username
     *
     * @return string $username
     */
    public function getUsername() {
        return $this->username;
    } // end getUsername

    /**
     * Getter for permissions
     *
     * @return int permissions
     */
    public function getPermissions() {
        return $this->permissions;
    } // endGetPermissions

    /**
     * Returns whether this user is logged in
     *
     * @return true if logged in, false otherwise
     */
    public function loggedIn() {
        return isset($_SESSION["User"]) && $_SESSION["User"] === $this->username;
    } // end loggedIn

    /**
     * Load a session for this user if possible
     *
     * @return true if session is active, false otherwise
     */
    public function loadSession() {
        if (isset($_SESSION["User"])) {

            // Populate instance data with db query using session username
            $username = $this->db->real_escape_string($_SESSION["User"]);
            $query = "SELECT * FROM " . User::TABLE_NAME . " WHERE username = '$username';";
            $result = $this->db->query($query);

            if ($result && $result->num_rows === 1 && 
                $userData = $result->fetch_object()) {

                $this->id = $userData->id;
                $this->username = $userData->username;
                $this->email = $userData->email;
                $this->password = $userData->password;
                $this->permissions = $userData->permissions;

                return true; 
            }
        }

        return false;
    } // end loadSession

    /**
     * Logs in a user, saving their username in a $_SESSION variable
     *
     * @param $username the user's unique username
     * @param $password the user's password
     * @return true if the user was successfully logged in, false otherwise
     */
    public function login($username, $password) {
        $username = $this->db->real_escape_string($username);
        $query = "SELECT * FROM " . User::TABLE_NAME . " WHERE username = '$username';";
        $result = $this->db->query($query);
        
        if ($result && $result->num_rows === 1 && 
            $userData = $result->fetch_object()) {

            if (isset($userData->password) && 
                password_verify($password, $userData->password)) {

                $this->id = $userData->id;
                $this->username = $userData->username;
                $this->email = $userData->email;
                $this->password = $userData->password;
                $this->permissions = $userData->permissions;

                $_SESSION["User"] = $this->username;
                return true;
            }
        }

        return false;
    } // end login

    /**
     * Logs this user out
     *
     * @return true if the user was successfully logged out, false otherwise
     */
    public function logout() {
        $result = session_destroy();
        unset($_SESSION[$this->username]);
        return $result;
    } // end logout

    /**
     * Registers a new user
     *
     * @param $username the user's unique username
     * @param $password the user's password
     * @param $email the user's email
     * @param $permissions the permissions settings for this user
     * @return true if the user was created successfully, false otherwise
     */
    public function register($username, $password, $email, $permissions = 0) {
        $username = $this->db->real_escape_string($username);
        $email = $this->db->real_escape_string($email);
        $permissions = $this->db->real_escape_string($permissions);
        $hash = password_hash($password, PASSWORD_BCRYPT);
        unset($password);
        $query = "INSERT INTO " . User::TABLE_NAME . " (
                    username,
                    email,
                    password,
                    permissions
                  ) VALUES (?, ?, ?, ?);";
        $statement = $this->db->prepare($query);
        $statement->bind_param('ssss', $username, $email, $hash, $permissions);

        if ($statement->execute()) {
            $statement->close();
            return true;
        }

        $statement->close();
        return false;
    } // end register

    /**
     * Retrieves a list of current games for this user
     *
     * @return an array of Game objects
     */
    public function getCurrentGames() {
        $query = "SELECT * FROM ttt_games 
                  WHERE '$this->id' IN (player1_id, player2_id);"; 
        $result = $this->db->query($query);
        
        if ($result && $result->num_rows > 0) {
            $games = [];

            while ($gameData = $result->fetch_object()) {
                $games[]= new TicTacToeGame($gameData);
            }

            return $games;
        }

        return false;
    } // getCurrentGames

    // TODO
    private function unregister($password) {}
    private function changeUsername($password, $newUsername) {}
    private function changePassword($password, $newPassword) {}
    private function changeEmail($password, $email) {}
    private function changePermissions($targetUsername, $newPermissions) {}
} // end User

?>
