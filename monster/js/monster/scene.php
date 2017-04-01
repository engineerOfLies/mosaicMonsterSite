<script src="../build/three.js"></script>
<script src="js/Detector.js"></script>
<script src="js/loaders/collada/Animation.js"></script>
<script src="js/loaders/collada/AnimationHandler.js"></script>
<script src="js/loaders/collada/KeyFrameAnimation.js"></script>

<script src="js/monster/entity.js"></script>

<script>

class GameSystem
{
	constructor()
	{
		if ( ! Detector.webgl ) Detector.addGetWebGLMessage();
		this.entityList = new EntityList();
		this.WIDTH = window.innerWidth;
		this.HEIGHT = window.innerHeight;
		this.scene = new THREE.Scene();
	}

	begin()
	{
		this.init();
		this.animate();
	}

	init()
	{
		this.camera = new THREE.PerspectiveCamera( 28, this.WIDTH / this.HEIGHT, 1, 10000 );
		this.camera.position.z = 100;

		//
		this.renderer = new THREE.WebGLRenderer();
		this.renderer.setPixelRatio( window.devicePixelRatio );
		this.renderer.setSize( this.WIDTH, this.HEIGHT );
		var container = document.getElementById( 'game' );
		container.appendChild( this.renderer.domElement );
		// lights
		this.scene.add( new THREE.AmbientLight( 0xcccccc ) );
		var pointLight = new THREE.PointLight( 0x4444cc, 2, 30 );
		pointLight.position.set( 5, 5, 5 );
		this.scene.add( pointLight );

		pointLight = new THREE.PointLight( 0xcc4444, 2, 30 );
		pointLight.position.set( -5, 7, 7 );
		this.scene.add( pointLight );

		pointLight = new THREE.PointLight( 0x44cc44, 2, 30 );
		pointLight.position.set( 0, -7, 7 );
		this.scene.add( pointLight );
		//
		window.addEventListener( 'resize', function(){this.onWindowResize();}.bind(this), false );
	}

	onWindowResize()
	{
		this.camera.aspect = window.innerWidth / window.innerHeight;
		this.camera.updateProjectionMatrix();
		this.renderer.setSize( window.innerWidth, window.innerHeight );
	}
	animate()
	{
		requestAnimationFrame( function(){this.animate();}.bind(this) );
		this.entityList.updateAll();
		this.render();
	}

	render()
	{
		this.entityList.drawAll();
		this.renderer.render( this.scene, this.camera );
	}

	getScene()
	{
		return this.scene;
	}

	addEntity(name,entity,updateFunc,drawFunc)
	{
		var ent = this.entityList.spawn(name,entity,updateFunc,drawFunc);
		return ent;// so the new entity function can be called right within the same call line
	}
}
</script>
