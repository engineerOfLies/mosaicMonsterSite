<?php include('header.php'); ?>

		<style>
			#info {
				color: #fff;
				position: absolute;
				top: 0px; width: 100%;
				padding: 5px;
				z-index:100;
			}
		</style>
<div id="container">
<div id="title"></div>
</div>
<script src="../build/three.js"></script>

		<script src="js/Detector.js"></script>
		<script src="js/libs/stats.min.js"></script>

		<script type="x-shader/x-vertex" id="vertexshader">
			uniform float amplitude;
			attribute float size;
			attribute vec3 customColor;
			varying vec3 vColor;
			void main() {
				vColor = customColor;
				vec4 mvPosition = modelViewMatrix * vec4( position, 1.0 );
				gl_PointSize = size * ( 300.0 / -mvPosition.z );
				gl_Position = projectionMatrix * mvPosition;
			}
		</script>

		<script type="x-shader/x-fragment" id="fragmentshader">
			uniform vec3 color;
			uniform sampler2D texture;
			varying vec3 vColor;
			void main() {
				gl_FragColor = vec4( color * vColor, 1.0 );
				gl_FragColor = gl_FragColor * texture2D( texture, gl_PointCoord );
			}
		</script>


		<script>
		if ( ! Detector.webgl ) Detector.addGetWebGLMessage();
		var renderer, scene, camera, stats;
		var sphere;
		var noise = [];
		var WIDTH = window.innerWidth;
		var HEIGHT = window.innerHeight;
		init();
		animate();
		function init() {
			camera = new THREE.PerspectiveCamera( 40, WIDTH / HEIGHT, 1, 10000 );
			camera.position.z = 300;
			scene = new THREE.Scene();
			var amount = 100000;
			var radius = 2000;
			var positions = new Float32Array( amount * 3 );
			var colors = new Float32Array( amount * 3 );
			var sizes = new Float32Array( amount );
			var vertex = new THREE.Vector3();
			var color = new THREE.Color( 0xffffff );
			for ( var i = 0; i < amount; i ++ ) {
				vertex.x = ( Math.random() * 2 - 1 ) * radius;
				vertex.y = ( Math.random() * 2 - 1 ) * radius;
				vertex.z = ( Math.random() * 2 - 1 ) * radius;
				vertex.toArray( positions, i * 3 );
				if ( vertex.x < 0 ) {
					color.setHSL( 0.5 + 0.1 * ( i / amount ), 0.7, 0.5 );
				} else {
					color.setHSL( 0.7 + 0.1 * ( i / amount ), 0.9, 0.5 );
				}
				color.toArray( colors, i * 3 );
				sizes[ i ] = 10;
			}
			var geometry = new THREE.BufferGeometry();
			geometry.addAttribute( 'position', new THREE.BufferAttribute( positions, 3 ) );
			geometry.addAttribute( 'customColor', new THREE.BufferAttribute( colors, 3 ) );
			geometry.addAttribute( 'size', new THREE.BufferAttribute( sizes, 1 ) );
			//
			var material = new THREE.ShaderMaterial( {
				uniforms: {
					amplitude: { value: 1.0 },
					color:     { value: new THREE.Color( 0xffffff ) },
					texture:   { value: new THREE.TextureLoader().load( "textures/sprites/spark1.png" ) }
				},
				vertexShader:   document.getElementById( 'vertexshader' ).textContent,
				fragmentShader: document.getElementById( 'fragmentshader' ).textContent,
				blending:       THREE.AdditiveBlending,
				depthTest:      false,
				transparent:    true
			});
			//
			sphere = new THREE.Points( geometry, material );
			scene.add( sphere );
			//
			renderer = new THREE.WebGLRenderer();
			renderer.setPixelRatio( window.devicePixelRatio );
			renderer.setSize( WIDTH, HEIGHT );
			var container = document.getElementById( 'container' );
			container.appendChild( renderer.domElement );
			stats = new Stats();
			container.appendChild( stats.dom );
			//
			window.addEventListener( 'resize', onWindowResize, false );
		}
		function onWindowResize() {
			camera.aspect = window.innerWidth / window.innerHeight;
			camera.updateProjectionMatrix();
			renderer.setSize( window.innerWidth, window.innerHeight );
		}
		function animate() {
			requestAnimationFrame( animate );
			render();
			stats.update();
		}
		function render() {
			var time = Date.now() * 0.005;
			sphere.rotation.z = 0.01 * time;
			var geometry = sphere.geometry;
			var attributes = geometry.attributes;
			for ( var i = 0; i < attributes.size.array.length; i++ ) {
				attributes.size.array[ i ] = 14 + 13 * Math.sin( 0.1 * i + time );
			}
			attributes.size.needsUpdate = true;
			renderer.render( scene, camera );
		}
	</script>
</body>
<?php include('footer.php'); ?>
<script>
if (sessionStorage.sessionId === undefined)
{
	location.href = "login.php";
}
$("#monster").addClass("active");
document.getElementById("title").innerHTML = "<h1> Welcome "+sessionStorage.username+"!</h1>";
</script>
</html>

