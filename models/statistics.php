<?php

/**
 * Statistics class for a user
 */
final class Stats {
    private $db;
    private $user;
    private $id;
    private $wins;
    private $losses;
    private $draws;

    /**
     * Constructor function for a statistics object
     *
     * @param $user the user
     */
    public function __construct($user) {
        $this->db = new DB(DBHOST, DBUSER, DBPASS, DATABASE);
        $this->user = $user;
        $this->id = $this->db->real_escape_string($this->user->getId());
    }

    /**
     * Returns the number of wins a user has
     *
     * @return the number of wins
     */
    public function getWins() {
        $query = '
            SELECT wins FROM ttt_stats
            INNER JOIN test_users
            ON test_users.id = ttt_stats.id
            WHERE ttt_stats.id = ' . $this->id . ';'
        ;

        $result = $this->db->query($query);

        if ($result->num_rows === 1) {
            $row = $result->fetch_object();
            return (int)$row->wins;
        }

        return null;
    }

    /**
     * Returns the number of losses a user has
     *
     * @return the number of losses
     */
    public function getLosses() {
        $query = '
            SELECT losses FROM ttt_stats
            INNER JOIN test_users
            ON test_users.id = ttt_stats.id
            WHERE ttt_stats.id = ' . $this->id . ';'
        ;

        $result = $this->db->query($query);

        if ($result->num_rows === 1) {
            $row = $result->fetch_object();
            return (int)$row->losses;
        }

        return null;
    }

    /**
     * Returns the number of draws a user has
     *
     * @return the number of draws
     */
    public function getDraws() {
        $query = '
            SELECT draws FROM ttt_stats
            INNER JOIN test_users
            ON test_users.id = ttt_stats.id
            WHERE ttt_stats.id = ' . $this->id . ';'
        ;

        $result = $this->db->query($query);

        if ($result->num_rows === 1) {
            $row = $result->fetch_object();
            return (int)$row->draws;
        }

        return null;
    }


    // TODO setters
}

?>
