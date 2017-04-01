<?php require_once("header.php");?>
<body>

<div id="container">
		<script src="../build/three.js"></script>
		<script src="js/Detector.js"></script>
		<script src="./js/GPUParticleSystem.js" charset="utf-8"></script>
		<script src="js/loaders/collada/Animation.js"></script>
		<script src="js/loaders/collada/AnimationHandler.js"></script>
		<script src="js/loaders/collada/KeyFrameAnimation.js"></script>


		<script src="js/monster/entity.js"></script>
		<script src="js/monster/starfield.js"></script>
		<script src="js/monster/swarm.js"></script>
		<script src="js/monster/actor.js"></script>

		<script>
		if ( ! Detector.webgl ) Detector.addGetWebGLMessage();
		var entityList = new EntityList();
		var renderer, scene, camera, stats;
		var sfield,swarm,model;
		var noise = [];
		var WIDTH = window.innerWidth;
		var HEIGHT = window.innerHeight;
		var showHUD = false;
		init();
		animate();
		function init() {
			camera = new THREE.PerspectiveCamera( 28, WIDTH / HEIGHT, 1, 10000 );
			camera.position.z = 100;
			scene = new THREE.Scene();

			//
			renderer = new THREE.WebGLRenderer();
			renderer.setPixelRatio( window.devicePixelRatio );
			renderer.setSize( WIDTH, HEIGHT );
			var container = document.getElementById( 'container' );
			container.appendChild( renderer.domElement );
			// lights
			scene.add( new THREE.AmbientLight( 0xcccccc ) );
			pointLight = new THREE.PointLight( 0xff4400, 5, 30 );
			pointLight.position.set( 5, 0, 0 );
			scene.add( pointLight );
			//
			window.addEventListener( 'resize', onWindowResize, false );
			entityList.spawn("starfield",starfield_new(scene),starfield_update,starfield_draw);
			entityList.spawn("swarm",swarm_new(scene),swarm_update,swarm_draw);
			entityList.spawn(
					"model",
					actor_new(scene,new THREE.Vector3(0,0,-5),	//position
							new THREE.Vector3(0,0,0),			//rotation
							new THREE.Vector3(0.05,0.05,0.05),	 	//scale
							'models/animated/flamingo.js',//model
							undefined,							//custom update
							"idle"),							//action
					actor_update,
					actor_draw);
		}
		function onWindowResize() {
			camera.aspect = window.innerWidth / window.innerHeight;
			camera.updateProjectionMatrix();
			renderer.setSize( window.innerWidth, window.innerHeight );
		}
		function animate() {
			requestAnimationFrame( animate );
			entityList.updateAll();
			render();
		}
		function render() {
			entityList.drawAll();
			renderer.render( scene, camera );
		}
	</script>
</body>
<?php require_once("footstrap.php");?>
</html>
