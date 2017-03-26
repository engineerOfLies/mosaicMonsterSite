function swarm_draw(entity)
{
	
}
function swarm_update(entity)
{
	var delta = entity.clock.getDelta();
	var particlSystem = entity.data;
	entity.tick += delta;
	if (entity.tick < 0) entity.tick = 0;
	if (delta > 0) {
		options.position.x = Math.sin(tick * 1.5) * 20;
		options.position.y = Math.sin(tick * 1.33) * 10;
		options.position.z = Math.sin(tick * 2.83) * 5;
		for (var x = 0; x < 1500 * delta; x++) {
			// Yep, that's really it.	Spawning particles is super cheap, and once you spawn them, the rest of
			// their lifecycle is handled entirely on the GPU, driven by a time uniform updated below
			particleSystem.spawnParticle(options);
		}
	}
	particleSystem.update(entity.tick);
}

function swarm_new(scene)
{
	var particleSystem;
	particleSystem = new THREE.GPUParticleSystem({
					maxParticles: 250000
								});
	var data = {
		geometry: particleSystem,
		clock : new THREE.Clock(true),
		tick : 0
	};
	scene.add(particleSystem);
	return data;
}

