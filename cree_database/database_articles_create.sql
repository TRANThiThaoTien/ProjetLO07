CREATE TABLE IF NOT EXISTS `articles` (
  id int(12) NOT NULL AUTO_INCREMENT,
  titre varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  categorie varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  annee int(6)  DEFAULT NULL,
  lieu varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  liste_id_auteurs varchar(100) DEFAULT NULL,
  resume text  CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  photo varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  etat varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'En attente',  
  temps datetime,
  primary key(id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;



