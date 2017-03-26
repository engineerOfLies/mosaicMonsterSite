drop table if exists playerInventory;
create table playerInventory(
	playerId int not null primary key,
	itemId int not null primary key,
	count int
);
