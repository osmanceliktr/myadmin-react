-- --------------------------------------------------------
-- Sunucu:                       127.0.0.1
-- Sunucu sürümü:                8.2.0 - MySQL Community Server - GPL
-- Sunucu İşletim Sistemi:       Win64
-- --------------------------------------------------------

-- tablo yapısı dökülüyor osmancelikdb.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET latin5 COLLATE latin5_turkish_ci DEFAULT NULL,
  `nameSurname` varchar(50) CHARACTER SET latin5 COLLATE latin5_turkish_ci DEFAULT NULL,
  `password` varchar(120) CHARACTER SET latin5 COLLATE latin5_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin5;

-- osmancelikdb.users: ~1 rows (yaklaşık) tablosu için veriler indiriliyor şifre:pratik
DELETE FROM `users`;
INSERT INTO `users` (`id`, `username`, `nameSurname`, `password`) VALUES
	(1, 'admin', 'Admin', '$2y$10$rzQuKck/tSciegxcOCSap.TpCSF/XoqwXhAHxSOfwWA1bkD4Wk1U6');


