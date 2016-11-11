CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `nom` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prenom` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `login` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  organisation varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `laboratoire` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
   level_utilisateur varchar(20) COLLATE utf8_unicode_ci DEFAULT 'utilisateur',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

