LOAD DATA LOCAL INFILE '/var/www/monsterdb/monsterlist.csv' 
INTO TABLE monsterDef
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;