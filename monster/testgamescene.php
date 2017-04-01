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
/*var crystal = game.addEntity(
		"crystal",
		actor_new(scene,new THREE.Vector3(0,0,0),	//position
			new THREE.Vector3(0,0,0),			//rotation
			new THREE.Vector3(1,1,1),	 	//scale
			'models/crystal/crystal.json',//model
			undefined,							//custom update
			"idle"),							//action
		actor_update,
		actor_draw);
*/
game.begin();

</script>
</body>
<?php require_once("footstrap.php");?>
</html>
