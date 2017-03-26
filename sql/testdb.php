#!/usr/bin/php
<?php
require_once("auth.inc");


function displayHelp()
{
	global $argv;
	echo "usage:\n";
	echo $argv[0]." -a [register|auth|validate] -u <username> -p <password -s <sessionId> -r [patient|therapist|scientist|admin] -e <email>\n";
	exit(0);
}

for($i = 1;$i < $argc;$i++)
{
	switch($argv[$i])
	{
		case "-a":
			$i++;
			$action = $argv[$i];
		break;
		case "-e":
			$i++;
			$email = $argv[$i];
		break;
		case "-s":
			$i++;
			$session = $argv[$i];
		break;
		case "-r":
			$i++;
			$role = $argv[$i];
		break;
		case "-p":
			$i++;
			$password = $argv[$i];
		break;
		case "-u":
			$i++;
			$username = $argv[$i];
		break;
		default:
		case "-h":
		case "--help":
			displayHelp();
		break;
	}
}
if (!isset($action))
{
	displayHelp();
}

switch($action)
{
	case "register":
		if ((!isset($username)) || (!isset($password)) || (!isset($email)) || (!isset($role)))
		{
			displayHelp();
		}
		$db = new AuthDB("../ini/monsterdb.ini");
		$response = $db->registerUser($username,$password,$role,$email);
		echo "response:\n";
		print_r($response);
		echo "\n";
		exit (0);
		break;
	case "auth":
		if ((!isset($username)) || (!isset($password)))
		{
			displayHelp();
		}
		$db = new AuthDB("../ini/monsterdb.ini");
		$response = $db->userLogin($username,$password);
		echo "response:\n";
		print_r($response);
		echo "\n";
		exit (0);
		break;
	case "validate":
		if ((!isset($username)) || (!isset($session)))
		{
			displayHelp();
		}
		$db = new AuthDB("../ini/monsterdb.ini");
		$response = $db->validateSession($username,$session);
		echo "response:\n";
		print_r($response);
		echo "\n";
		exit (0);
		break;
	default:
		displayHelp();
		break;
}

?>
