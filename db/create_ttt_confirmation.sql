use test_ggorlen;

DROP TABLE IF EXISTS ttt_confirmations;

CREATE TABLE IF NOT EXISTS `ttt_confirmations` (
  `id` int(10) unsigned NOT NULL UNIQUE,
  `user_id` varchar(100) NOT NULL UNIQUE,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES test_users(`id`)
);
