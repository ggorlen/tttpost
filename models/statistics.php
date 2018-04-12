<?php

/**
 * Statistics model for a user
 */
final class Stats {
    public const TABLE_NAME = 'ttt_stats';

    private $db;
    private $userId;
    private $wins;
    private $losses;
    private $draws;

    /**
     * Constructor function for a statistics object
     *
     * @param $user the user
     */
    public function __construct($userId) {
        $this->db = new DB(DBHOST, DBUSER, DBPASS, DATABASE);
        $this->userId = $userId;
    } // end __construct

    /**
     * Adds a new user to the stats table
     *
     * @return true if add was successful, false otherwise
     */
    public static function addUser($userId) {
        $db = new DB(DBHOST, DBUSER, DBPASS, DATABASE);
        $query = 'INSERT INTO ' . Stats::TABLE_NAME . ' (
                    id,
                    wins,
                    losses,
                    draws 
                  ) VALUES (?, ?, ?, ?);';
        $statement = $db->prepare($query);
        $statement->bind_param('ssss', $userId, $d = 0, $d = 0, $d = 0);

        if ($statement->execute()) {
            $statement->close();
            return true;
        }

        $statement->close();
        return false;
    } // end addUser

    /**
     * Returns the number of wins a user has
     *
     * @return the number of wins
     */
    public function getWins() {
        $query = '
            SELECT wins FROM ' . Stats::TABLE_NAME . ' 
            WHERE id = ' . $this->userId . ';'
        ;
        $result = $this->db->query($query);

        if ($result->num_rows === 1) {
            $row = $result->fetch_object();
            return (int)$row->wins;
        }

        return null;
    } // end getWins

    /**
     * Returns the number of losses a user has
     *
     * @return the number of losses
     */
    public function getLosses() {
        $query = '
            SELECT losses FROM ' . Stats::TABLE_NAME . ' 
            WHERE id = ' . $this->userId . ';'
        ;
        $result = $this->db->query($query);

        if ($result->num_rows === 1) {
            $row = $result->fetch_object();
            return (int)$row->losses;
        }

        return null;
    } // endGetLosses

    /**
     * Returns the number of draws a user has
     *
     * @return the number of draws
     */
    public function getDraws() {
        $query = '
            SELECT draws FROM ' . Stats::TABLE_NAME . ' 
            WHERE id = ' . $this->userId . ';'
        ;
        $result = $this->db->query($query);

        if ($result->num_rows === 1) {
            $row = $result->fetch_object();
            return (int)$row->draws;
        }

        return null;
    } // end getDraws

    /**
     * Increment the number of wins for a user by 1
     *
     * @return true if query successful, false otherwise
     */
    public function addWin() {
        $query = '
            UPDATE ' . Stats::TABLE_NAME . ' 
            SET wins = wins + 1 
            WHERE id = ' . $this->userId . ';'
        ;
        return $this->db->query($query);
    } // end addWin

    /**
     * Increment the number of draws for a user by 1
     *
     * @return true if query successful, false otherwise
     */
    public function addDraw() {
        $query = '
            UPDATE ' . Stats::TABLE_NAME . ' 
            SET draw = draw + 1 
            WHERE id = ' . $this->userId . ';'
        ;
        return $this->db->query($query);
    } // end addDraw

    /**
     * Increment the number of losses for a user by 1
     *
     * @return true if query successful, false otherwise
     */
    public function addLoss() {
        $query = '
            UPDATE ' . Stats::TABLE_NAME . ' 
            SET losses = losses + 1 
            WHERE id = ' . $this->userId . ';'
        ;
        return $this->db->query($query);
    } // end addLosses
} // end Stats

?>
