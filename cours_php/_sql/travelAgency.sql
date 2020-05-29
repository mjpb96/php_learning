-- pour importer le fichier SQL en ligne de commande
-- SOURCE _sql/travelagency.sql;

-- supprimer la base de données si elle existe
DROP DATABASE IF EXISTS travelagency;

-- créer la base de données
CREATE DATABASE travelagency;

-- table role
CREATE TABLE travelagency.role(
	id TINYINT(1) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(20) NOT NULL UNIQUE
);

-- table user
CREATE TABLE travelagency.user(
	id TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	login VARCHAR(30) NOT NULL UNIQUE,
	password VARCHAR(150) NOT NULL,
	role_id TINYINT(1) UNSIGNED NOT NULL,
	CONSTRAINT fk_user_role_id
	FOREIGN KEY(role_id)
	REFERENCES travelagency.role(id)
);

-- table travel
CREATE TABLE travelagency.travel(
	id TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(200) NOT NULL UNIQUE,
	description TEXT NOT NULL,
	image VARCHAR(50) NOT NULL UNIQUE,
	steps JSON NOT NULL	
);

-- table period
-- vérifier le moteur de stockage MySQL qui doit être en INNODB
-- pour modifier le moteur de stockage, modifier le fichier my.ini sur Windows / my.cnf sur Unix
-- modifier l'entrée default_storage_engine = INNODB
CREATE TABLE travelagency.period(
	id TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	start DATE NOT NULL,
	days TINYINT(2) UNSIGNED NOT NULL,
	price SMALLINT UNSIGNED NOT NULL,
	travel_id TINYINT UNSIGNED NOT NULL,
	CONSTRAINT fk_period_travel_id
	FOREIGN KEY(travel_id)
	REFERENCES travelagency.travel(id)
	ON DELETE CASCADE
);

-- insertions
INSERT INTO
	travelagency.role
VALUES
	(NULL, 'admin'),
	(NULL, 'user')
;

INSERT INTO
	travelagency.user
VALUE
	(NULL, 'admin', '$argon2i$v=19$m=65536,t=4,p=1$ZW9aRGhrNEUzWS5jOG5XdQ$1tNZHvdw5osjofSJI3zHTKrCb1Q9DqKYnCs4dEGsfh4', 1)
;