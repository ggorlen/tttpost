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
     */
    public function __construct($data) {
        $this->db = new DB(DBHOST, DBUSER, DBPASS, DATABASE);
        $this->id = $data->id;
        $this->endTime = $data->end_time;
        $this->moveTimeLimit = $data->move_time_limit;
        $this->gameTimeLimit = $data->game_time_limit;
        $this->player1 = $data->player1_id;
        $this->player2 = $data->player2_id;
        $this->result = $data->result;
        $this->startTime = $data->start_time;
        
        // Get move data and build a board
        $query = "SELECT * FROM ttt_moves WHERE game_id = '$this->id';";
        $result = $this->db->query($query);
        $xMoves = [];
        $oMoves = [];
        $ply = 0;

        if ($result && $result->num_rows > 0) {
            while ($moveData = $result->fetch_object()) {
                if ($moveData->player_id === $this->player1) {
                    $xMoves[]= $moveData->end_location;
                }
                else {
                    $oMoves[]= $moveData->end_location;
                }

                $ply = max($moveData->ply, $ply);
            }
        }

        $this->board = new TicTacToeBoard(
            array_map("intval", $xMoves), 
            array_map("intval", $oMoves), 
            $ply + 1
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
     * Returns the ply
     *
     * @return int ply
     */
    public function getResult() {
        return $this->result;
    } // end getResult

    /**
     * TODO
     * Returns the time the game ended in the format YYYY-MM-DD
     *
     * @return string the end time
     */
    public function getEndTime() {
       return 0; 
    } // end getEndTime

    /**
     * TODO
     * Returns the time the game started in the format YYYY-MM-DD
     *
     * @return string the start time
     */
    public function getStartTime() {
       return $this->startTime; 
    } // end getStartTime

    /**
     * TODO
     * Returns the time the move time limit in seconds
     *
     * @return int the move time limit
     */
    public function getMoveTimeLimit() {
        return 0;
    } // end getMoveTimeLimit

    /**
     * TODO
     * Returns the time the game time limit in seconds
     *
     * @return int the game time limit
     */
    public function getGameTimeLimit() {
        return 0;
    } // end getGameTimeLimit
} // end TicTacToeGame

?>
