<?php

require_once("err.inc");
/**
	@brief used for web php to validate a session information from a request
	@param session Mixed, expected to have name and id of the session to validate
*/
function validateSession($session)
{
	$session = json_decode($session);
	if (!isset($session))
	{
		err("no session information provided");	
	}
	$auth = new AuthDB();
	$sessionId = $session->id;
	$name = $session->name;
	$valid = $auth->validateSession($name,$sessionId);
	if ($valid["status"] != "success")
	{
		err($valid["status"]);
	}
	return "ok";
}

class AuthDB
{
	private $db;

	public function __construct($confFile = "/var/www/monsterini/monsterdb.ini")
	{
		$conf = parse_ini_file($confFile,false);
		$this->db = new mysqli("localhost",$conf["username"],$conf["password"],$conf["db"]);
		$this->salt = $conf['salt'];
		$this->timeout = $conf['timeout'];
		if ($this->db->errno != 0)
		{
			echo "failed to connect to the database: ".$this->db->error.PHP_EOL;
		}
	}
	public function __destruct()
	{
		$this->db->close();
	}

	private function saltPassword($password)
	{
		return hash("sha256",$this->salt.$password);
	}

	public function register($username,$password,$email,$display)
	{
		file_put_contents("/tmp/monster.log","processing\n",FILE_APPEND);
		$response = $this->registerUser($username,$password,"p",$email);
		file_put_contents("/tmp/monster.log","got herre\n",FILE_APPEND);
		if ($response['status'] != "success")return $response;
		$pid = $response['playerId'];
		$now = time();
		$dn = $this->db->real_escape_string($display);
		$query = "insert into playerData (id,monsterId,screenname,starttime,experience,level,material,ethereal,spiritual,abyssal)VALUES($pid,-1,'$dn',$now,0,1,0,0,0,0);";
		file_put_contents("/tmp/monster.log",$query,FILE_APPEND);
		$this->db->query($query);
		if ($this->db->errno != 0)
		{
			err("Failed to add new user profile: ".$this->db->error);
			return array("status"=>"failed to add new profile");
		}
		return $response;
	}

	public function registerUser($username,$password,$role,$email)
	{
		$un = $this->db->real_escape_string(strtolower($username));
		$pw = $this->db->real_escape_string($this->saltPassword($password));
		$r = trim(strtolower($role));
		$em = $this->db->real_escape_string($email);
		switch($r)
		{
			case "player":
			case "p":
				$ur = "p";
				break;
			case "administrator":
			case "admin":
				$ur = "ad";
				break;
			default:
				return array(
					"status"=>"fail",
					"message"=>"unsupported user role");
				break;
		}
		$query = "select * from auth where username = '$un' or email = '$em';";
		$result = $this->db->query($query);
		if ($result->num_rows != 0)
		{
			return array(
					"status"=>"fail",
					"message"=>"username or email already in use");
		}
		$insert = "insert into auth (username,password,role,email) values ('$un','$pw','$ur','$em');";
		$result = $this->db->query($insert);
		if ($this->db->errno != 0)
		{
			echo "error: failed to insert row with query:".PHP_EOL;
			echo $insert.PHP_EOL;
			return array(
					"status"=>"fail",
					"message"=>"failed to insert row");	
		}
		return array(
			"status"=>"success",
			"playerId"=>$this->db->insert_id);
	}
	
	public function validateUser($username, $password)
	{
		$un = $this->db->real_escape_string($username);
		$pw = $this->db->real_escape_string($this->saltPassword($password));
		$query = "select * from auth where username = '$un';";
		$result = $this->db->query($query);
		while ($row = $result->fetch_assoc())
		{
			if (($row['username'] == $un) && ($row['password'] == $pw))
			{
				return array(
					"status"=>"success",
					"userId"=> $row['userId'],
					"role"=> $row['role']);
			}
		}
		return array(
				"status"=>"fail");	
	}

	public function userLogin($username, $password)
	{
		$result = $this->validateUser($username,$password);
		if ($result["status"] != "success")
		{
			return $result;
		}
		$sessionId = sha1(time()+$this->salt+$result['userId']);
		//invalidate all other sessions for this user
		$invalidate = "update sessions set invalid = 1 where userId = '".$result['userId']."';";
		$this->db->query($invalidate);
		//new session ID for this user
		$query = "insert into sessions (sessionString,userId,timestamp,invalid) values ('$sessionId',".$result['userId'].",".time().",0);";
		$this->db->query($query);
		if ($this->db->errno != 0)
		{
			echo "error: failed to insert row with query:".PHP_EOL;
			echo $query.PHP_EOL;
			return array(
					"status"=>"fail",
					"message"=>"failed to insert row");	
		}
		return array(
			"status"=>"success",
			"username"=>$username,
			"role"=>$result["role"],
			"sessionId"=>$sessionId
		);
	}

	public function getUserIdBySession($sessionId)
	{
		$si = $this->db->real_escape_string($sessionId);
		$query = "select userId from sessions where sessionString = '$si';";
		$results = $this->db->query($query);
		if ($results->num_rows != 1)
		{
			return NULL;
		}
		$row = $results->fetch_assoc();
		return $row["userId"];
	}

	public function validateSession($username,$sessionId)
	{
		$un = $this->db->real_escape_string($username);
		$si = $this->db->real_escape_string($sessionId);
		$sessionQuery = "select timestamp,invalid from sessions,auth where auth.userId = sessions.userId and sessions.sessionString = '$si'";
		$result = $this->db->query($sessionQuery);
		while ($row = $result->fetch_assoc())
		{
			if ($row["invalid"] == 1)
			{
				return array(
						"status"=>"fail");
			}
			if ($row["timestamp"] < (time() - $this->timeout))
			{
				return array(
						"status"=>"timeout");
			}
			$update = "update sessions set timestamp = ".time()." where sessionString = '$si'";
			$result = $this->db->query($update);
			if ($this->db->errno != 0)
			{
				echo "error: failed to insert session row with query:".PHP_EOL;
				echo $query.PHP_EOL;
				return array(
						"status"=>"fail",
						"message"=>"failed to insert row");	
			}
			return array(
				"status"=>"success"
			);	
		}
		return array(
			"status"=>"fail");
	}
}

?>

