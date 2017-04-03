function swarm_update(entity)
{
}

function swarm_set_direction(entity,x,y,z,speed)
{
	entity.data.direction.x = x;
	entity.data.direction.y = y;
	entity.data.direction.z = z;
	entity.data.speed = speed;
}

function swarm_set_color_variance(entity,variance)
{
	entity.data.color_variance = variance;
}
function swarm_set_velocity_variance(entity,variance)
{
	if (!entity)return;
	entity.data.variance = variance;
}


function swarm_draw(entity)
{
	var delta = entity.data.clock.getDelta();
	var particleSystem = entity.data.geometry;
	var options = entity.data.options;
	entity.data.tick += delta;
	var tick = entity.data.tick;
	var color = new THREE.Color( 0xffffff );
	var hsl = entity.color.getHSL(hsl);
	if (tick < 0) tick = 0;
	options.color = entity.color.getHex();
	if (delta > 0) {
		if (entity.data.color_variance)
		{
			color.setHSL( hsl.h + (entity.data.color_variance * Math.sin(tick)), hsl.s, hsl.l );
			options.color = color.getHex();
		}
		options.velocity.copy(entity.data.direction);
		options.position.x = entity.position.x + entity.data.offset.x;
		options.position.y = entity.position.y + entity.data.offset.y;
		options.position.z = entity.position.z + entity.data.offset.z;
		options.position.multiplyScalar(0.001);
		for (var x = 0; x < entity.data.spawn_rate * delta; x++) {
			options.velocity.x = entity.data.direction.x + ((Math.random() * 2.0 - 1.0) * entity.data.variance);
			options.velocity.y = entity.data.direction.y + ((Math.random() * 2.0 - 1.0) * entity.data.variance);
			options.velocity.z = entity.data.direction.z + ((Math.random() * 2.0 - 1.0) * entity.data.variance);
			options.velocity.normalize();
			options.velocity.multiplyScalar(entity.data.speed);
			options.velocity.x *= entity.scale.x;
			options.velocity.y *= entity.scale.y;
			options.velocity.z *= entity.scale.z;
			particleSystem.spawnParticle(options);
		}
	}
	particleSystem.update(tick);
}

function swarm_new(scene,maxcount = 100000)
{
	var particleSystem;
	particleSystem = new THREE.GPUParticleSystem({
					maxParticles: maxcount
			});
	var options = {
		  position: new THREE.Vector3(),
		  positionRandomness: 0,
		  velocity: new THREE.Vector3(),
		  velocityRandomness: 0,
		  color: 0xcccccc,
		  colorRandomness: 0,
		  turbulence: 0,
		  lifetime: 1,
		  size: 10,
		  sizeRandomness: 1
	};
	var data = {
		geometry: particleSystem,
		direction: new THREE.Vector3(),
		variance: 0,
		speed : 1,
		clock : new THREE.Clock(true),
		tick : 0,
		spawn_rate: 15000,
		color_variance: 0,
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

