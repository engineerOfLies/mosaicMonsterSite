<?php include('header.php'); ?>


<div class="container"style="position:absolute;width:100%;">
  <div class="row">
  <div class="col-md-3"></div>
  <div class="col-md-6">
	<div id="game" class= "bluesky" style="width:100%;left:0;min-height:420px;margin:0;"></div>
  <div class="row" style= "margin:0;padding:0;">
	<div class="btn-group btn-group-lg dropup" style="width:50%">
		<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" style="width:100%;">ACTION</button>
		<ul class="dropdown-menu" id="action" role="menu">
			<li><a href="#"><H4 style="text-align:center;">Battle</H4></a></li>
			<li><a href="#"><H4 style="text-align:center;">Explore</H4></a></li>
			<li><a href="#"><H4 style="text-align:center;">Dungeon</H4></a></li>
			<li><a href="#"><H4 style="text-align:center;">Train</H4></a></li>
			<li><a href="#"><H4 style="text-align:center;">Travel</H4></a></li>
		</ul>
	</div>
	<div class="btn-group btn-group-lg dropup" style="width:50%">
		<button class="btn dropdown-toggle" type="button" data-toggle="dropdown" style="width:100%;">CARE</button>
		<ul class="dropdown-menu dropdown-menu-right" id="care" role="menu">
			<li><a href="#"><H4 style="text-align:center;">Rest</H4></a></li>
			<li><a href="#"><H4 style="text-align:center;">Feed</H4></a></li>
			<li><a href="#"><H4 style="text-align:center;">Item</H4></a></li>
			<li><a href="#"><H4 style="text-align:center;">Play</H4></a></li>
			<li><a href="monster.php"><H4 style="text-align:center;">Stats</H4></a></li>
		</ul>
	</div>
	</div>
  </div>
  </div>
  </div>
</div>

<?php include('footer.php'); ?>
<?php require_once("js/monster/scene.php");?>

<script src="js/monster/starfield.js"></script>
<script src="js/monster/actor.js"></script>
<script src="js/monster/swarm.js"></script>
<script>
if (sessionStorage.sessionId === undefined)
{
	location.href = "login.php";
}
$("#monster").addClass("active");

playerPartnerCheck(handlePlayerCheck);

var gameDiv = document.getElementById("game");
var game = new GameSystem("game",false);
var scene = game.getScene();

var terrain = game.addEntity(
		"terrain",
		actor_new(scene,'models/grasslands/grasslands.json'),
		actor_update,
		actor_draw);

game.begin();

function handlePlayerCheck()
{
	getPlayerMonsterModel(handleMonsterModel);
}
function handleMonsterModel()
{
	var crystal = game.addEntity(
			"player_monster",
			actor_new(scene,sessionStorage.monstermodel),
			actor_update,
			actor_draw);
	crystal.setScale(5,5,5);
	crystal.setColorHex(sessionStorage.monstercolor);
	crystal.setEffects(sessionStorage.monstereffects);
}
</script>
</html>



