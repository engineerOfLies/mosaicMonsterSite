<?php require_once("header.php");?>
<body>

<div id="game">
<?php require_once("js/monster/scene.php");?>

<script src="js/monster/starfield.js"></script>
<script src="js/monster/actor.js"></script>
<script>
var game = new GameSystem();
var scene = game.getScene();
// do all setup here

game.addEntity("starfield",starfield_new(scene),starfield_update,starfield_draw);
var crystal = game.addEntity(
		"crystal",
		actor_new(scene,'models/crystal/crystal.json'),
		actor_update,
		actor_draw);
crystal.setScale(3,3,3);
crystal.setColor(0.5,1,0.5);
crystal.setRotVector(0,0.01,0);

game.begin();

</script>
</body>
<?php require_once("footstrap.php");?>
</html>
