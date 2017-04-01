function starfield_draw(entity)
{
	
}

function starfield_update(entity)
{
	var time = Date.now() * 0.005;
	var attributes = entity.data.mesh.geometry.attributes;
	for ( var i = 0; i < attributes.size.array.length; i++ ) {
		attributes.size.array[ i ] = 14 + 13 * Math.sin( 0.1 * i + time );
	}
	attributes.size.needsUpdate = true;
}

function starfield_new(scene)
{
	var vshader = `
			uniform float amplitude;
			attribute float size;
			attribute vec3 customColor;
			varying vec3 vColor;
			void main() {
				vColor = customColor;
				vec4 mvPosition = modelViewMatrix * vec4( position, 1.0 );
				gl_PointSize = size * ( 300.0 / -mvPosition.z );
				gl_Position = projectionMatrix * mvPosition;
			}`;
	var fshader = `
			uniform vec3 color;
			uniform sampler2D texture;
			varying vec3 vColor;
			void main() {
				gl_FragColor = vec4( color * vColor, 1.0 );
				gl_FragColor = gl_FragColor * texture2D( texture, gl_PointCoord );
			}
	`;

	var amount = 15000;
	var radius = 1000;
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
		if ( vertex.y < 0 ) {
			color.setHSL( 0.7 + 0.1 * ( i / amount ), 0.7, 0.5 );
		} else {
			color.setHSL( 0.8 + 0.1 * ( i / amount ), 0.9, 0.5 );
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
		vertexShader:   vshader,
		fragmentShader: fshader,
		blending:       THREE.AdditiveBlending,
		depthTest:      false,
		transparent:    true
	});
	//
	sphere = new THREE.Points( geometry, material );
	scene.add(sphere);
	var data = {
		mesh:sphere,
		speed:1.0
	};
	return data;
}

