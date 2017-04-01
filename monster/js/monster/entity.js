
class Entity
{
	constructor(name,data,update,draw)
	{
		this.name = name;
		this.data = data;
		this.update = update;
		this.draw = draw;
		this.dirty = 1;
		this.scale = new THREE.Vector3(1,1,1);
		this.position = new THREE.Vector3()
		this.old_position = new THREE.Vector3()
		this.velocity = new THREE.Vector3();
		this.acceleration = new THREE.Vector3();
		this.rotation = new THREE.Vector3();
		this.old_rotation = new THREE.Vector3();
		this.rotvector = new THREE.Vector3();
	}

	postUpdate()
	{
		this.old_position = this.position;
		this.old_rotation = this.rotation;
		this.position.add(this.velocity);
		this.velocity.add(this.acceleration);
		this.rotation.add(this.rotvector);
		if ((this.old_position != this.position) || (this.old_rotation != this.rotation))
		{
			this.dirty = 1;
		}
	}

	setPosition(x,y,z)
	{
		this.position.x = x;
		this.position.y = y;
		this.position.z = z;
		this.dirty = 1;
	}

	setVelocity(x,y,z)
	{
		this.velocity.x = x;
		this.velocity.y = y;
		this.velocity.z = z;
	}

	setAcceleration(x,y,z)
	{
		this.acceleration.x = x;
		this.acceleration.y = y;
		this.acceleration.z = z;
	}

	setRotation(x,y,z)
	{
		this.rotation.x = x;
		this.rotation.y = y;
		this.rotation.z = z;
		this.dirty = 1;
	}

	setRotVector(x,y,z)
	{
		this.rotvector.x = x;
		this.rotvector.y = y;
		this.rotvector.z = z;
	}
	
	setScale(x,y,z)
	{
		this.scale.x = x;
		this.scale.y = y;
		this.scale.z = z;
		this.dirty = 1;
	}

	setAction(action,style,step)
	{
		this.action.name = action;
		this.action.style = style;
		this.action.step = step;
	}
}

class EntityList
{
	constructor()
	{
		this.list = [];
	}

	spawn(ename,edata,eupdate,edraw)
	{
		var ent = new Entity(ename,edata,eupdate,edraw);
		this.list.push(ent);
		return ent;
	}

	drawAll()
	{
		var i,l;
		l = this.list.length;
		for (i = 0; i < l;i++)
		{
			if (this.list[i].draw != undefined)
			{
				this.list[i].draw(this.list[i]);
			}
			if (this.list[i].data.draw != undefined)
			{
				this.list[i].data.draw(this.list[i]);
			}
		}
	}

	updateAll()
	{
		var i,l;
		l = this.list.length;
		for (i = 0; i < l;i++)
		{
			if (this.list[i].data.update != undefined)
			{
				this.list[i].data.update(this.list[i]);
			}
			if (this.list[i].update != undefined)
			{
				this.list[i].update(this.list[i]);
			}
			this.list[i].postUpdate(this.list[i]);
		}
	}
}
