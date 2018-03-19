USE test_ggorlen;

DROP TABLE IF EXISTS ttt_games;

CREATE TABLE IF NOT EXISTS `ttt_games` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `board` varchar(255) NOT NULL,
  `end_time` int(10) unsigned DEFAULT NULL,
  `move_time_limit` int(10) unsigned DEFAULT NULL,
  `game_time_limit` int(10) unsigned DEFAULT NULL,
  `player1_id` int(10) unsigned NOT NULL, 
  `player2_id` int(10) unsigned,
  `ply` int(10) unsigned NOT NULL,
  `result` varchar(10),
  `start_time` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`player1`) REFERENCES test_users(`id`),
  FOREIGN KEY (`player2`) REFERENCES test_users(`id`) 
);
