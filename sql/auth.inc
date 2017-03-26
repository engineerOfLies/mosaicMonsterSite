<?php
class AuthDB
{
	private $db;

	public function __construct($confFile = "/var/www/ini/dbaccess.ini")
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

	public function registerUser($username,$password,$role,$email)
	{
		$un = $this->db->real_escape_string($username);
		$pw = $this->db->real_escape_string($this->saltPassword($password));
		$r = trim(strtolower($role));
		$em = $this->db->real_escape_string($email);
		switch($r)
		{
			case "patient":
			case "p":
				$ur = "p";
				break;
			case "therapist":
			case "t":
				$ur = "t";
				break;
			case "scientist":
			case "doctor":
				$ur = "s";
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
					"message"=>"username or password already in use");
		}
		$insert = "insert into auth (username,password,role,email) values ('$un','$pw','$ur','$em');";
		$result = $this->db->query($insert);
		if ($this->db->affected_rows != 1)
		{
			echo "error: failed to insert row with query:".PHP_EOL;
			echo $insert.PHP_EOL;
			return array(
					"status"=>"fail",
					"message"=>"failed to insert row");	
		}
		return array(
			"status"=>"success");
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
		if ($this->db->affected_rows != 1)
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
			if ($this->db->affected_rows != 1)
			{
				echo "error: failed to insert row with query:".PHP_EOL;
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

