<?php
//require_once '../config/config.php';
//require_once 'db.php';


define("TABLE_NAME", "confirmations"); 


//$post = json_decode(file_get_contents("php://input"), true);
$post = $_POST;

if (isset($post) && isset($post["name"]) &&
    count($post["name"]) && isset($post["email"]) &&
    filter_var($post["email"], FILTER_VALIDATE_EMAIL)) {

    $db = new DB($dbhost, $dbuser, $dbpass, $database);
    unset($dbhost, $dbuser, $dbpass, $database);

    do {
        // Reference: https://stackoverflow.com/a/2088983/6243352
        $hash = md5(uniqid(rand(), true));
        $query = "SELECT * FROM " . TABLE_NAME . " WHERE id = '$hash';";
        $result = $this->db->query($query);
    while ($result && $result->num_rows !== 0);

    // fetch user from table

    $query = "INSERT INTO " . TABLE_NAME . " (
                id,
                username,
              ) VALUES (?, ?);";
    $statement = $this->db->prepare($query);
    $statement->bind_param('ss', $hash, $username);

    if ($statement->execute()) {
        $statement->close();
        return true;
    }


    
    $to = $post["email"];
    $subject = "Confirm your registration for tttpost";
    $headers = "From: " . $post["email"] . " \n";
    $headers .= "Reply-To: noreply@gmail.com\n";
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\n";
    
    $msg = "Hello from tttpost! Please follow this link to complete registration: " .
      '<a href="https://hills.ccsf.edu/~ggorlen/assignment05/confirm_registration.php?id="' . $hash // TODO hardcoded domain
    
    echo mail($to, $subject, $msg, $headers);
}
?>
