drop table if exists sessions;
create table sessions (
	sessionString varchar(255) NOT NULL PRIMARY KEY,
	userId int,
	timestamp int,
	invalid int
);
