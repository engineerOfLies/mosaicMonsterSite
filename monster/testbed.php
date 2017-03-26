<?php require_once("header.php");?>
<body>

<div id="container">
<script src="../build/three.js"></script>

		<script src="js/Detector.js"></script>
		<script src="./js/GPUParticleSystem.js" charset="utf-8"></script>
		<script src="js/monster/entity.js"></script>
		<script src="js/monster/starfield.js"></script>
		<script src="js/monster/swarm.js"></script>

		<script>
		if ( ! Detector.webgl ) Detector.addGetWebGLMessage();
		var entityList = new EntityList();
		var renderer, scene, camera, stats;
		var sfield,swarm;
		var noise = [];
		var WIDTH = window.innerWidth;
		var HEIGHT = window.innerHeight;
		var showHUD = false;
		init();
		animate();
		function init() {
			camera = new THREE.PerspectiveCamera( 40, WIDTH / HEIGHT, 1, 10000 );
			camera.position.z = 300;
			scene = new THREE.Scene();

			//
			renderer = new THREE.WebGLRenderer();
			renderer.setPixelRatio( window.devicePixelRatio );
			renderer.setSize( WIDTH, HEIGHT );
			var container = document.getElementById( 'container' );
			container.appendChild( renderer.domElement );
			//
			window.addEventListener( 'resize', onWindowResize, false );
			sfield = starfield_new(scene);
			entityList.spawn("starfield",sfield,starfield_update,starfield_draw);
//			entityList.spawn("swarm",swarm_new(scene),swarm_update,swarm_draw);
		}
		function onWindowResize() {
			camera.aspect = window.innerWidth / window.innerHeight;
			camera.updateProjectionMatrix();
			renderer.setSize( window.innerWidth, window.innerHeight );
		}
		function animate() {
			requestAnimationFrame( animate );
			entityList.drawAll();
			render();
		}
		function render() {
			renderer.render( scene, camera );
		}
	</script>
</body>
<?php require_once("footstrap.php");?>
</html>
