function actor_update(entity)
{	
	var delta = entity.data.clock.getDelta();
	THREE.AnimationHandler.update( delta );
	entity.data.mixer.update( delta );
}

function actor_draw(entity)
{
}

function actor_new(scene,model,position=undefined)
{
	var loader = new THREE.JSONLoader();
	var mesh,mixer;
	mixer = new THREE.AnimationMixer( scene );
	loader.load( model, function ( geometry, materials ) {
			var material = materials[ 0 ];
			material.morphTargets = true;
			material.color.setHex( 0xffffff );
			var faceMaterial = new THREE.MultiMaterial( materials );
//			geometry.normalize ();
			mesh = new THREE.Mesh( geometry, faceMaterial );
			mesh.scale.set(1,1,1);
			if (position === undefined)
			{
				mesh.position.set(0,0,0);
			}
			else
			{
				mesh.position.copy(position);
			}
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
		mixer : mixer,
		initialPosition : position
	};
	return data;
}
