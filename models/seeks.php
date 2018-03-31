<?php

/**
 * Seeks model
 */
final class Seeks {
    private $db;

    /**
     * Constructor function for a Seeks model
     */
    public function __construct() {
        $this->db = new DB(DBHOST, DBUSER, DBPASS, DATABASE);
    } // end __construct

    /**
     * Returns a list of active seeks
     *
     * @return a list of active seeks or false on query failure
     */
    public function getSeeks() {
        $query = '
            SELECT * FROM ttt_seeks
            INNER JOIN ttt_users 
            ON ttt_seeks.user_id = ttt_users.id
            ;
        ';
        $result = $this->db->query($query);

        if ($result && $result->num_rows > 0) {
            $seeks = [];

            while ($row = $result->fetch_object()) {
                $seeks[]= [
                    'id' => $row->id,
                    'user_id' => $row->user_id,
                    'timestamp' => $row->timestamp,
                    'username' => $row->username
                ];
            }

            return $seeks;
        }

        return false;
    } // end getSeeks

    /**
     * Turns a seek into a game
     *
     * @param $seekId the id of the player joining the seek
     * @return true if successful, false otherwise
     */
    public function startGame($seekId) {
        $query = '
            SELECT draws FROM ttt_stats
            INNER JOIN ttt_users
            ON ttt_users.id = ttt_stats.id
            WHERE ttt_stats.id = ' . $this->id . ';'
        ;

        $result = $this->db->query($query);

        if ($result->num_rows === 1) {
            $row = $result->fetch_object();
            return (int)$row->draws;
        }

        return null;
    } // end getDraws

    /**
     * Creates a new seek
     *
     * @param $userId the id of the player initiating the seek
     * @return true if successful, false otherwise
     */
    public function newSeek($userId) {
        $userId = $this->db->real_escape_string($userId);
        $query = '
            INSERT INTO ttt_seeks (user_id, timestamp)
            VALUES (' . $userId . ', ' . time() . ');'
        ;
        return $this->db->query($query);
    } // end newSeek

    /**
     * Removes a seek by id
     *
     * @param $seekId the id of the seek to remove
     * @return true if successful, false otherwise
     */
    public function removeSeek($seekId) {
        $seekId = $this->db->real_escape_string($seekId);
        $query = '
            DELETE FROM ttt_seeks
            WHERE id = ' . $seekId . ';'
        ;
        return $this->db->query($query);
    } // end removeSeek
} // end Seeks

?>