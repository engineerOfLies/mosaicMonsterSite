<?php

require_once("err.inc");
require_once("auth.inc");
class PlayerDB
{
	private $db;

	public function __construct($confFile = "/var/www/monsterini/monsterdb.ini")
	{
		$conf = parse_ini_file($confFile,false);
		$this->db = new mysqli("localhost",$conf["username"],$conf["password"],$conf["db"]);
		if ($this->db->errno != 0)
		{
			echo "failed to connect to the database: ".$this->db->error.PHP_EOL;
		}
	}
	public function __destruct()
	{
		$this->db->close();
	}

	public function playerPartnerCheck($sessionId)
	{
		$auth = new AuthDB();
		$userId = $auth->getUserIdBySession($sessionId);
		if ($userId == NULL)
		{
			return array("status"=>"fail");
		}
		$query = "select monsterId from playerData where id=$userId;";
		$results = $this->db->query($query);
		if ($this->db->errno != 0)
		{
			err("playerPartnerCheck:failed with query:\n$query\n re:".$this->db->error.PHP_EOL);
			return array("status"=>"fail");
		}
		if ($this->results->num_rows == 1)
		{
			return array("status"=>"none");
		}
		return array("status"=>"ok");
	}

	public function getPlayerMonsterModel($sessionId)
	{
		$auth = new AuthDB();
		$userId = $auth->getUserIdBySession($sessionId);
		if ($userId == NULL)
		{
			return array("status"=>"fail");
		}
		$query="select model,color,effects from monsterDef,monsterData where monsterData.playerId=$userId and monsterData.monsterId=monsterDef.id;";
		$results = $this->db->query($query);
		if ($this->db->errno != 0)
		{
			err("failed to getPlayerMonsterModel with query:\n$query\n re:".$this->db->error.PHP_EOL);
			return array("status"=>"fail");
		}
		if ($results->num_rows == 0)
		{
			return array("status"=>"fail");	
		}
		return $results->fetch_assoc();
	}

	public function getMonsterModel($monsterName)
	{
		$monster = $this->getMonsterDefById($monsterName);
		if (isset($monster['status']))
		{
			return $monster;
		}
		return array(
				"model"=>$monster["model"],
				"color"=>$monster["color"],
				"effects"=>$monster["effects"]);
	}

	public function giveStartingMonster($sessionId,$monsterName)
	{
		$auth = new AuthDB();
		$userId = $auth->getUserIdBySession($sessionId);
		if ($userId == NULL)
		{
			return array("status"=>"fail");
		}
		$monster = $this->getMonsterDefById($monsterName);
		if (isset($monster['status']))
		{
			return $monster;
		}
		err(print_r($monster,true));
		$query = "insert into monsterData (playerId,monsterId,level,birthdate,material,ethereal,spiritual,abyssal,health,stamina,mana,basehealth,basestamina,basemana,basespeed,basefatigue,strength,dexterity,focus,resolve) values ($userId,"
			.$monster['id'].",".$monster["level"].",".time().",".$monster['material'].","
			.$monster['ethereal'].",".$monster['spiritual'].",".$monster['abyssal'].","
			.$monster['basehealth'].",".$monster['basestamina'].",".$monster['basemana'].",".$monster['basehealth'].","
			.$monster['basestamina'].",".$monster['basemana'].",".$monster['basespeed'].",".$monster['basefatigue'].","
			.$monster['basestrength'].",".$monster['basedexterity'].",".$monster['basefocus'].",".$monster['baseresolve'].");";
		$this->db->query($query);
		if ($this->db->errno != 0)
		{
			err("failed to insert new monster with query:\n$query\nRe: ".$this->db->error);
			return array("status"=>"fail");
		}
		return "ok";
	}

	public function getPlayerMonsterData($sessionId)
	{
		$auth = new AuthDB();
		$userId = $auth->getUserIdBySession($sessionId);
		if ($userId == NULL)
		{
			return array("status"=>"fail");
		}
		$query = "select * from monsterData,monsterDef where monsterData.playerId=$userId and monsterData.monsterId = monsterDef.id;";
		$results = $this->db->query($query);
		if ($this->db->errno != 0)
		{
			err("failed to get player data with query: $query");
			return array("status"=>"fail");
		}
		$row = $results->fetch_assoc();
		return $row;
	}

	public function getMonsterDefById($monsterName)
	{
		$query = "select * from monsterDef where sname = '$monsterName';";
		$result = $this->db->query($query);
		if ($result->num_rows != 1)
		{
			err("failed to get monster data for $monsterName with query:\n$query\nre: ".$this->db->error);
			return array("status"=>"fail");
		}
		$row = $result->fetch_assoc();
		return $row;	
	}

	public function getMonsterStats($sessionId)
	{
		$auth = new AuthDB();
		$userId = $auth->getUserIdBySession($sessionId);
		if ($userId == NULL)
		{
			return array("status"=>"fail");
		}
		$query = "select * from monsterData where playerId = $userId;";
		$result = $this->db->query($query);
		if ($result->num_rows != 1)
		{
			return array("status"=>"fail");
		}
		$row = $result->fetch_assoc();
		return $row;
	}

	public function getProfile($sessionId)
	{
		$auth = new AuthDB();
		$userId = $auth->getUserIdBySession($sessionId);
		if ($userId == NULL)
		{
			return array("status"=>"fail");
		}
		$query = "select * from playerData where id = $userId;";
		$result = $this->db->query($query);
		if ($result->num_rows != 1)
		{
			return array("status"=>"fail");
		}
		$row = $result->fetch_assoc();
		return $row;
	}
}
?>
