drop table if exists monsterData;
create table monsterData(
	id int primary key not null auto_increment,
	playerId int not null,
	index (id,playerId),

);
