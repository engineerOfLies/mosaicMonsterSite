<?php require_once("header.php");?>
<body>
<link href="monster.css" rel="stylesheet">

<div class="container"style="position:absolute;width:100%;">
<div class="row" id="game" style="margin: 0;padding:0;left:0;right:0;">
<div class="col-md-4" style="position:absolute;top:60px;">
	<h2 id = "title" style = "top:10px;text-align: center;color:#ffffff"></h2>
	<p id = "description" style = "color:#eeeeee"></p>
	<button id="selectButton" class="btn" style="position:relative;display:none;" onclick='handleSelection'>Select</button>
</div>
<div style="position:absolute;left:0;right:0;">
	<H1 style="text-align: center;color:#ffffff">Choose an Essence Crystal</H1>
</div>
</div>
</div>
</body>
<?php require_once("footer.php");?>
<?php require_once("js/monster/scene.php");?>

<script src="js/monster/starfield.js"></script>
<script src="js/monster/actor.js"></script>
<script src="js/monster/swarm.js"></script>
<script>
var game = new GameSystem();
var scene = game.getScene();
// controls

var currentSelection = undefined;
// do all setup here
game.addEntity("starfield",starfield_new(scene),starfield_update,starfield_draw);
var title = document.getElementById("title");
var description = document.getElementById("description");
var selectButton = document.getElementById("selectButton");
selectButton.onclick = handleSelection;

var crystal = game.addEntity(
		"material crystal",
		actor_new(scene,'models/crystal/crystal.json',new THREE.Vector3(-10,0,0)),
		actor_update,
		actor_draw);
crystal.setScale(3,3,3);
crystal.setColor(0.2,1,0.2);
crystal.setRotVector(0,0.01,0);
var particles = game.addEntity(
		"material particles",
		swarm_new(scene),
		swarm_update,
		swarm_draw);
swarm_set_velocity_variance(particles,0.1);
particles.setScale(1,1.2,1);
particles.setColor(0.2,1,0.2);
particles.setPosition(-10,0,0);
swarm_set_color_variance(particles,0.05);


crystal = game.addEntity(
		"ethereal crystal",
		actor_new(scene,'models/crystal/crystal.json',new THREE.Vector3(0,10,0)),
		actor_update,
		actor_draw);
crystal.setScale(3,3,3);
crystal.setColor(0.2,0.2,1);
crystal.setRotVector(0,0.011,0);
particles = game.addEntity(
		"ethereal particles",
		swarm_new(scene),
		swarm_update,
		swarm_draw);
swarm_set_velocity_variance(particles,0.1);
particles.setScale(1,1.2,1);
particles.setColor(0.2,0.2,1);
particles.setPosition(0,10,0);
swarm_set_color_variance(particles,0.05);

crystal = game.addEntity(
		"spiritual crystal",
		actor_new(scene,'models/crystal/crystal.json',new THREE.Vector3(10,0,0)),
		actor_update,
		actor_draw);
crystal.setScale(3,3,3);
crystal.setColor(1,0.2,0.2);
crystal.setRotVector(0,0.013,0);
particles = game.addEntity(
		"spiritual particles",
		swarm_new(scene,50000),
		swarm_update,
		swarm_draw);
swarm_set_velocity_variance(particles,0.1);
particles.setScale(1,1.2,1);
particles.setColor(1,0.2,0.2);
particles.setPosition(10,0,0);
swarm_set_color_variance(particles,0.05);

crystal = game.addEntity(
		"abyssal crystal",
		actor_new(scene,'models/crystal/crystal.json',new THREE.Vector3(0,-10,0)),
		actor_update,
		actor_draw);
crystal.setScale(3,3,3);
crystal.setColor(0.1,0,0.1);
crystal.setRotVector(0,0.015,0);
crystal.setReflectivity(0);
particles = game.addEntity(
		"abyssal particles",
		swarm_new(scene,50000),
		swarm_update,
		swarm_draw);
swarm_set_velocity_variance(particles,0.1);
particles.setScale(1,1.2,1);
particles.setColor(0.8,0.5,0.8);
particles.setPosition(0,-10,0);
swarm_set_color_variance(particles,0.05);

game.setRaycastCallback(function(intersects)
		{
			if (this.lastSelect !== undefined)
			{
				this.lastSelect.highlight(0);
			}
			for ( var i = 0; i < intersects.length; i++ )
			{
				if (intersects[i].object.userData == undefined)continue;
				var ent = intersects[i].object.userData;
			var t = "";
			var d = "";
			selectButton.style.display= "none";
				switch(ent.name)
				{
					case "abyssal crystal":
						t = "Abyssal Crystal";
						d = "The essence of the abyss.  This essence is home to deception, evasion, and infiltration.  Corruption is the core of the abyssal essence...";
						currentSelection = 1;
						this.lastSelect = ent;
						ent.highlight(1);
						selectButton.style.display= "initial";
					break;
					case "material crystal":
						t = "Material Crystal";
						d = "The essence of tangible matter.";
						currentSelection = 2;
						ent.highlight(1);
						this.lastSelect = ent;
						selectButton.style.display= "initial";
					break;
					case "ethereal crystal":
						t = "Ethereal Crystal";
						d = "The essence of energy.";
						currentSelection = 4;
						ent.highlight(1);
						this.lastSelect = ent;
						selectButton.style.display= "initial";
					break;
					case "spiritual crystal":
						t = "Spiritual Crystal";
						d = "The essence of celestial awareness.";
						currentSelection = 8;
						ent.highlight(1);
						this.lastSelect = ent;
						selectButton.style.display= "initial";
					break;
				}
				title.innerHTML = t;
				description.innerHTML = d;
			}
		});

function handleSelection()
{
	var monsterName;
	switch(this.currentSelection)
	{
		case 1:
			monsterName = "abyssal";
		break;
		case 2:
			monsterName = "material";
		break;
		case 4:
			monsterName = "ethereal";
		break;
		case 8:
			monsterName = "spiritual";
		break;
		default:
			return;
		break;
	}
	console.log("making selection for "+monsterName);
	makeMonsterSelection(monsterName);
}

game.begin();

$("#monster").addClass("active");
</script>
</html>
