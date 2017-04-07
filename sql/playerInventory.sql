drop table if exists playerInventory;
create table playerInventory(
	playerId int not null,
	itemId int not null,
	count int,
	Primary Key (playerId,ItemId)
);
