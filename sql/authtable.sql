drop table if exists auth;
create table auth (
	userId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	username varchar(32),
	password varchar(255),
	role varchar(4),
	email varchar(255)
);
