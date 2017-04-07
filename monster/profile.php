<?php include('header.php'); ?>


<div class="container"style="position:absolute;width:100%;">
<div class="row" style="margin: 0;padding:0;left:0;right:0;">
	<H1 style="text-align: center;">Player Profile</H1>
</div>
<div class="row" style="margin: 0;padding:0;left:0;right:0;height:100%">
<div class="col-md-3">
	<h2 id = "name" style = "text-align: center;"></h2>
	<p>Level : </p>
	<p>Experience : </p>
	<p>Material : </p>
	<p>Ethereal : </p>
	<p>Spiritual : </p>
	<p>Abyssal : </p>
	<div style="overflow:scroll;flex: 0 1 auto;">
	<button class="btn btn-primary">View Inventory</button>
	</div>	
</div>
<div id="game" class="col-md-4" style="left:0;right:0;top:0;bottom:0;">
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
getPlayerProfile(updateProfile);

game.begin();
if (sessionStorage.sessionId === undefined)
{
	location.href = "login.php";
}
$("#profile").addClass("active");
function updateProfile()
{
	if (sessionStorage.player === undefined)
	{
		console.log("profile failed to load");
		return;
	}
	var profile = JSON.parse(sessionStorage.profile);
	var name = document.getElementById("name");
	name.innerHTML = profile.screenname;
	var partner = document.getElementById("partner");
}
</script>
</html>

