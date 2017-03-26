drop table if exists monsterHistory;
create table monsterHistory(
	playermonsterId int not null primary key,
	monsterId int not null primary key,
	became int
);
