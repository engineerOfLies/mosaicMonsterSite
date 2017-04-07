<?php include('header.php'); ?>


<div class="container"style="position:absolute;width:100%;">
<div class="row" style="margin: 0;padding:0;left:0;right:0;">
	<H1 style="text-align: center;">Monster Partner Stats</H1>
</div>
<div class="row" style="margin: 0;padding:0;left:0;right:0;height:100%">
<div class="col-md-2">
	<h2 id = "partner">Partner</h2>
	<p>Form: </p>
	<p>Stage : </p>
	<p>Age : </p>
	<h3>Affinity</h3>
	<p>Material : </p>
	<p>Ethereal : </p>
	<p>Spiritual : </p>
	<p>Abyssal : </p>
</div>
<div class="col-md-3">
	<h3>Attributes</h3>
	<p>Health: </p>
	<p>Stamina: </p>
	<p>Mana: </p>
	<p>strength:</p>
	<p>dexterity:</p>
	<p>focus:</p>
	<p>resolve:</p>
	<button class="btn btn-primary">View Skills</button>
</div>
<div class="col-md-5" id="game" style="left:0;right:0;top:0;bottom:0;">
</div>
</div>
</div>

<?php include('footer.php'); ?>
<?php require_once("js/monster/scene.php");?>

<script src="js/monster/starfield.js"></script>
<script src="js/monster/actor.js"></script>
<script src="js/monster/swarm.js"></script>
<script>
var game = new GameSystem("game",false);
var scene = game.getScene();
getMonsterStats(updateMonsterStats);

game.begin();
if (sessionStorage.sessionId === undefined)
{
	location.href = "login.php";
}
$("#monster").addClass("active");
function updateMonsterStats()
{
	if (sessionStorage.monster === undefined)
	{
		console.log("profile failed to load");
		return;
	}
	var monster = JSON.parse(sessionStorage.monster);
}
</script>
</html>


