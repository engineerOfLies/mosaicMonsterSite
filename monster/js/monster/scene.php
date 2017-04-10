<script src="../build/three.js"></script>
<script src="js/Detector.js"></script>
<script src="js/loaders/collada/Animation.js"></script>
<script src="js/loaders/collada/AnimationHandler.js"></script>
<script src="js/loaders/collada/KeyFrameAnimation.js"></script>
<script src="./js/GPUParticleSystem.js" charset="utf-8"></script>
<script src="js/libs/dat.gui.min.js"></script>

<script src="js/monster/entity.js"></script>

<script>

class GameSystem
{
	constructor(container = "game",fullscreen = true)
	{
		if ( ! Detector.webgl ) Detector.addGetWebGLMessage();
		this.entityList = new EntityList();
		this.scene = new THREE.Scene();
		this.raycaster = new THREE.Raycaster();
		this.mouse = new THREE.Vector2();
		this.fullscreen = fullscreen;
		this.container = document.getElementById( container );
		if (this.fullscreen)
		{
			this.WIDTH = window.innerWidth;
			this.HEIGHT = window.innerHeight;
		}
		else
		{
			this.WIDTH = this.container.offsetWidth;
			this.HEIGHT = this.container.offsetHeight;	
		}
		this.clicked = 0;
	}

	begin()
	{
		this.init();
		this.animate();
	}

	setRaycastCallback(callback)
	{
		this.rayCastCallback = callback;
	}

	init()
	{
		this.camera = new THREE.PerspectiveCamera( 28, this.WIDTH / this.HEIGHT, 1, 10000 );
		this.camera.position.z = 100;


		//
		this.renderer = new THREE.WebGLRenderer({ alpha: true });
//		this.renderer = new THREE.CanvasRenderer( { alpha: true });
		this.renderer.setPixelRatio( window.devicePixelRatio );
		this.renderer.setSize( this.WIDTH, this.HEIGHT );
		this.container.insertBefore(this.renderer.domElement,this.container.childNodes[0]);

		// lights
		this.scene.add( new THREE.AmbientLight( 0xcccccc ) );
		var pointLight = new THREE.PointLight( 0x4444cc, 2, 30 );
		pointLight.position.set( 15, 15, 15 );
		this.scene.add( pointLight );

		pointLight = new THREE.PointLight( 0xcc4444, 2, 30 );
		pointLight.position.set( -15, 17, 17 );
		this.scene.add( pointLight );

		pointLight = new THREE.PointLight( 0x44cc44, 2, 30 );
		pointLight.position.set( 0, -17, 17 );
		this.scene.add( pointLight );
		//
		window.addEventListener( 'resize', function(){this.onWindowResize();}.bind(this), false );
		document.addEventListener( 'mousemove', function(event){this.onDocumentMouseMove(event);}.bind(this), false );
		document.addEventListener( 'click', function(event){this.onMouseClick(event);}.bind(this), false );
	}

	onMouseClick( event )
	{	
		this.clicked = event.buttons;
		if (this.rayCastCallback !== undefined)
		{
			this.raycaster.setFromCamera( this.mouse, this.camera );
			var intersects = this.raycaster.intersectObjects( this.scene.children );
			this.rayCastCallback(intersects);
		}
	}

	onDocumentMouseMove( event )
	{
		event.preventDefault();
		var rect = this.renderer.domElement.getBoundingClientRect();
		this.mouse.x = ( ( event.clientX - rect.left ) / ( rect.right - rect.left ) ) * 2 - 1;
		this.mouse.y = - ( ( event.clientY - rect.top ) / ( rect.bottom - rect.top) ) * 2 + 1;
	}

	onWindowResize()
	{
		if (this.fullscreen)
		{
			this.WIDTH = window.innerWidth;
			this.HEIGHT = window.innerHeight;
		}
		else
		{
			this.WIDTH = this.container.offsetWidth;
			this.HEIGHT = this.container.offsetHeight;	
		}
		this.WIDTH = this.container.offsetWidth;
		this.HEIGHT = this.container.offsetWidth;
		this.camera.aspect = this.WIDTH / this.HEIGHT;
		this.camera.updateProjectionMatrix();
		this.renderer.setSize( this.WIDTH, this.HEIGHT );
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
		this.clicked = 0;

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
