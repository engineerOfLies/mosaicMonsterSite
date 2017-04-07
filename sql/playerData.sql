drop table if exists playerData;
create table playerData(
	id int not null primary key,
	monsterId int,
	screenname varchar(32),
	starttime bigint,
	playtime bigint,
	experience bigint,
	level int,
	material float(7,4),
	ethereal float(7,4),
	spiritual float(7,4),
	abyssal float(7,4)
);
