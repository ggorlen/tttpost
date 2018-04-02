<?php

/**
 * Model for a Tic Tac Toe game
 */
class TicTacToeGame implements Game {
    private const GAME_TYPE = 'tic tac toe';
    private $db;
    private $id;
    private $endTime;
    private $moveTimeLimit;
    private $gameTimeLimit;
    private $board;
    private $player1;
    private $player2;
    private $result;
    private $startTime;


    /**
     * Constructor for a TicTacToeGame object
     *
     * @param $data a hash of arguments representing a game:
     *              id, end_time, move_time_limit
     */
    public function __construct($data) {
        $this->db = new DB(DBHOST, DBUSER, DBPASS, DATABASE);
        $this->id = intval($this->db->real_escape_string($data->id));
        $this->endTime = intval($this->db->real_escape_string($data->end_time));
        $this->moveTimeLimit = intval($this->db->real_escape_string($data->move_time_limit));
        $this->gameTimeLimit = intval($this->db->real_escape_string($data->game_time_limit));
        $this->player1 = intval($this->db->real_escape_string($data->player1_id));
        $this->player2 = intval($this->db->real_escape_string($data->player2_id));
        $this->result = $this->db->real_escape_string($data->result);
        $this->startTime = intval($this->db->real_escape_string($data->start_time));

        // Get player data
        $query = "SELECT username FROM ttt_users WHERE id = '$this->player1';";
        $result = $this->db->query($query);

        if ($result && $result->num_rows === 1) {
            $this->player1Username = $result->fetch_object()->username;
        }

        $query = "SELECT username FROM ttt_users WHERE id = '$this->player2';";
        $result = $this->db->query($query);

        if ($result && $result->num_rows === 1) {
            $this->player2Username = $result->fetch_object()->username;
        }
        
        // Get move data and build a board
        $xMoves = [];
        $oMoves = [];

        $query = "SELECT end_location FROM ttt_moves 
                  WHERE game_id = '$this->id' 
                  AND player_id = '$this->player1';";
        $result = $this->db->query($query);

        if ($result && $result->num_rows > 0) {
            while ($moveData = $result->fetch_object()) {
                $xMoves[]= $moveData->end_location;
            }
        }

        $query = "SELECT end_location FROM ttt_moves 
                  WHERE game_id = '$this->id' 
                  AND player_id = '$this->player2';";
        $result = $this->db->query($query);

        if ($result && $result->num_rows > 0) {
            while ($moveData = $result->fetch_object()) {
                $oMoves[]= $moveData->end_location;
            }
        }

        $this->board = new TicTacToeBoard(
            array_map("intval", $xMoves), 
            array_map("intval", $oMoves), 
            count($xMoves) + count($oMoves)
        );
    } // end __construct

    /**
     * Returns the game board
     *
     * @return array the board
     */
    public function getBoard() {
        return $this->board->getBoard();
    } // end getBoard

    /**
     * Returns the game id
     *
     * @return integer game id
     */
    public function getID() {
        return $this->id;
    } // end getID

    /**
     * Makes a move on the game board
     *
     * @return true if move successful, false otherwise
     */
    public function move($playerId, $square) {

        // TODO

    } // end getBoard

    /**
     * Returns the game type
     *
     * @return string game type
     */
    public function getGameType() {
        return TicTacToeGame::GAME_TYPE;
    } // end getGameType

    /**
     * Returns the id of player1
     *
     * @return int id of player1
     */
    public function getPlayer1() {
        return $this->player1;
    } // end getPlayer1

    /**
     * Returns the id of player2
     *
     * @return int id of player2
     */
    public function getPlayer2() {
        return $this->player2;
    } // end getPlayer2

    /**
     * Returns the username of player1
     *
     * @return int username of player1
     */
    public function getPlayer1Username() {
        return $this->player1Username;
    } // end getPlayer1Username

    /**
     * Returns the username of player2
     *
     * @return int username of player2
     */
    public function getPlayer2Username() {
        return $this->player2Username;
    } // end getPlayer2Username

    /**
     * Returns the ply
     *
     * @return int ply
     */
    public function getPly() {
        return $this->board->getPly();
    } // end getPly

    /**
     * Returns the current player id
     *
     * @return int the current player id
     */
    public function getCurrentPlayer() {
        return $this->board->getPly() & 1 ? 
               $this->player2 : $this->player1;
    } // end getCurrentPlayer

    /**
     * Returns the result of the game, if any
     *
     * @return string result
     */
    public function getResult() {
        return $this->result;
    } // end getResult

    /**
     * Returns the time the game ended
     *
     * @return int the end time
     */
    public function getEndTime() {
       return $this->endTime; 
    } // end getEndTime

    /**
     * Returns the time the game started
     *
     * @return int the start time
     */
    public function getStartTime() {
       return $this->startTime; 
    } // end getStartTime

    /**
     * Returns the time the move time limit in seconds
     *
     * @return int the move time limit
     */
    public function getMoveTimeLimit() {
        return $this->moveTimeLimit;
    } // end getMoveTimeLimit

    /**
     * Returns the time the game time limit in seconds
     *
     * @return int the game time limit
     */
    public function getGameTimeLimit() {
        return $this->gameTimeLimit;
    } // end getGameTimeLimit
} // end TicTacToeGame

?>
