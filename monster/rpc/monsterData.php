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

function getMonsterStats($request)
{
	validateSession($request['session']);
	$session = json_decode($request['session']);
	$pdb = new PlayerDB();
	return $pdb->getMonsterStats($session->id);
}

function makeMonsterSelection($request)
{
	validateSession($request['session']);
	$session = json_decode($request['session']);
	$pdb = new PlayerDB();
	return $pdb->giveStartingMonster($session->d,$request['monsterName']);
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
}
echo json_encode($response);

?>



