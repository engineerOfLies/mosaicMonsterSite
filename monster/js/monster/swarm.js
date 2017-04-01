function swarm_update(entity)
{
	var tick = entity.data.tick;
	switch (entity.data.action)
	{
		case "wobble":
			entity.data.offset.x = Math.sin(tick * 1.5) * 5;
			entity.data.offset.y = Math.sin(tick * 1.33) * 5;
			entity.data.offset.z = Math.sin(tick * 2.83) * 5;
			entity.data.step --;
			if (entity.data.step <= 0)
			{
				entity.data.action.step = 100;
				entity.data.action.name = "return";
			}
		break;
		case "return":
			entity.data.offset.x *= 0.75;
			entity.data.offset.y *= 0.75;
			entity.data.offset.z *= 0.75;
			entity.data.step --;
			if (entity.data.step <= 0)
			{
				entity.data.action.step = 1000;
				entity.data.action.name = "none";
			}
		break;
		case "none":
			entity.data.step --;
			if (entity.data.action.step <= 0)
			{
				entity.data.action.step = 1000;
				entity.data.action.name = "wobble";
			}
		break;
	}
}

function swarm_draw(entity)
{
	var delta = entity.data.clock.getDelta();
	var particleSystem = entity.data.geometry;
	var options = entity.data.options;
	entity.data.tick += delta;
	var tick = entity.data.tick;
	var color = new THREE.Color( 0xffffff );
	if (tick < 0) tick = 0;
	if (delta > 0) {
		color.setHSL( 0.6 + 0.3 * Math.sin(tick), 0.7, 0.5 );
		options.color = color.getHex();
		options.position.x = entity.data.position.x + entity.data.offset.x;
		options.position.y = entity.data.position.y + entity.data.offset.y;
		options.position.z = entity.data.position.z + entity.data.offset.z;
		for (var x = 0; x < 150000 * delta; x++) {
			particleSystem.spawnParticle(options);
		}
	}
	particleSystem.update(tick);
}

function swarm_new(scene)
{
	var particleSystem;
	particleSystem = new THREE.GPUParticleSystem({
					maxParticles: 250000
			});
	var options = {
		  position: new THREE.Vector3(),
		  positionRandomness: .7,
		  velocity: new THREE.Vector3(),
		  velocityRandomness: .3,
		  color: 0xaa88ff,
		  colorRandomness: .2,
		  turbulence: .2,
		  lifetime: 1,
		  size: 5,
		  sizeRandomness: 1
	};
	var data = {
		geometry: particleSystem,
		clock : new THREE.Clock(true),
		tick : 0,
		options : options,
		offset: new THREE.Vector3(),
		action : {
			name: "wobble",
			style: "loop",
			step : 1000},
	};
	scene.add(particleSystem);
	return data;
}

