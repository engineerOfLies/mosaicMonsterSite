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

function getPlayerProfile($request)
{
	validateSession($request['session']);
	$session = json_decode($request['session']);
	$pdb = new PlayerDB();
	return $pdb->getProfile($session->id);
}

$request = $_POST;
$response = "unsupported request type";
switch ($request["type"])
{
	case "getPlayerProfile":
		$response = getPlayerProfile($request);
	break;
}
echo json_encode($response);

?>


