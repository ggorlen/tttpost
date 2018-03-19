<?php

/**
 * Game interface
 */
interface Game {
    public function toHTML();
    public function getBoard();
    public function getGameType();
    public function getPlayer1();
    public function getPlayer2();
    public function getPlayerToMove();
    public function getResult();
}

?>
