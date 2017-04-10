<?php
require_once("../../../monsterdb/auth.inc");
require_once("../../../monsterdb/player.inc");

if (!isset($_POST))
{
	$msg = "NO POST MESSAGE SET";
	echo json_encode($msg);
	exit(0);
}

function file_dump($dump)
{
	file_put_contents("/tmp/monsterput",print_r($dump, true));
}

function getPlayerMonsterModel($request)
{
	validateSession($request['session']);
	$session = json_decode($request['session']);
	$pdb = new PlayerDB();
	return $pdb->getPlayerMonsterModel($session->id);
}

function getMonsterStats($request)
{
	validateSession($request['session']);
	$session = json_decode($request['session']);
	$pdb = new PlayerDB();
	return $pdb->getPlayerMonsterData($session->id);
}

function makeMonsterSelection($request)
{
	validateSession($request['session']);
	$session = json_decode($request['session']);
	$pdb = new PlayerDB();
	return $pdb->giveStartingMonster($session->id,$request['monsterName']);
}

function playerPartnerCheck($request)
{
	validateSession($request['session']);
	$session = json_decode($request['session']);
	$pdb = new PlayerDB();
	return $pdb->playerPartnerCheck($session->id);
}

$request = $_POST;
$response = "unsupported request type";
switch ($request["type"])
{
	case "getMonsterStats":
		$response = getMonsterStats($request);
	break;
	case "makeMonsterSelection":
		$response = makeMonsterSelection($request);
	break;
	case "getPlayerMonsterModel":
		$response = getPlayerMonsterModel($request);
	break;
	case "playerPartnerCheck":
		$response = playerPartnerCheck($request);
	break;
}
echo json_encode($response);

?>



