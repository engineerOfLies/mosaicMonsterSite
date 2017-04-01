function actor_update(entity)
{	
	var delta = entity.data.clock.getDelta();
	THREE.AnimationHandler.update( delta );
	entity.data.mixer.update( delta );
}

function actor_draw(entity)
{
}

function actor_new(scene,model)
{
	var loader = new THREE.JSONLoader();
	var mesh,mixer;
	mixer = new THREE.AnimationMixer( scene );
	loader.load( model, function ( geometry, materials ) {
			// adjust color a bit
			var material = materials[ 0 ];
			material.morphTargets = true;
			material.color.setHex( 0xffffff );
			var faceMaterial = new THREE.MultiMaterial( materials );
			// leave space for big monster
			mesh = new THREE.Mesh( geometry, faceMaterial );
			mesh.scale.set(1,1,1);
			mesh.position.set(0,0,0);
			mesh.rotation.set(0,0,0);
			mesh.matrixAutoUpdate = false;
			mesh.updateMatrix();
			scene.add( mesh );
			if (geometry.animations !== undefined)
			{
				mixer.clipAction( geometry.animations[0], mesh )
					.setDuration( 1 )			// one second
					.startAt( - Math.random() )	// random phase (already running)
					.play();					// let's go
			}
			data.geometry = mesh;
			data.material = material;
	}.bind(this) );

	var data = {
		clock : new THREE.Clock(true),
		mixer : mixer
	};
	return data;
}
