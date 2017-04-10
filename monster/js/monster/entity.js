
class Entity
{
	constructor(name,data,update,draw)
	{
		this.name = name;
		this.data = data;
		this.update = update;
		this.draw = draw;
		this.dirty = 1;
		this.highlit = 0;
		this.reflectivity = 1.0;
		this.color = new THREE.Color(1,1,1);
		this.specular = new THREE.Color(1,1,1);
		this.scale = new THREE.Vector3(1,1,1);
		this.position = new THREE.Vector3()
		this.old_position = new THREE.Vector3()
		this.velocity = new THREE.Vector3();
		this.acceleration = new THREE.Vector3();
		this.rotation = new THREE.Vector3();
		this.old_rotation = new THREE.Vector3();
		this.rotvector = new THREE.Vector3();
		if (data.initialPosition != undefined)
		{
			this.position.copy(data.initialPosition);
		}
	}

	highlight(high)
	{
		this.highlit = high;
		this.colordirty = 1;
	}

	postUpdate()
	{
		this.old_position.copy(this.position);
		this.old_rotation.copy(this.rotation);
		this.position.add(this.velocity);
		this.velocity.add(this.acceleration);
		this.rotation.add(this.rotvector);
		if ((!this.old_position.equals(this.position)) || (!this.old_rotation.equals(this.rotation)))
		{
			this.dirty = 1;
		}
	}

	preDraw()
	{
		if (this.data.geometry === undefined)return;
		this.data.geometry.userData = this;
		if (this.colordirty == 1)
		{	
			if (this.data.material !== undefined)
			{
				this.colordirty = 0;
				this.data.material.color.copy(this.color);
				if (this.highlit == 1)
				{
					this.data.material.color.offsetHSL(0,0.2,0.2);
				}
				this.data.material.reflectivity = this.reflectivity;
				this.data.material.update();
			}
		}
		if (this.dirty == 1)
		{
			this.dirty = 0;
			this.data.geometry.position.copy(this.position);
			this.data.geometry.rotateX(this.rotvector.x);
			this.data.geometry.rotateY(this.rotvector.y);
			this.data.geometry.rotateZ(this.rotvector.z);
			this.data.geometry.scale.copy(this.scale);
			this.data.geometry.updateMatrix();
		}
	}

	setEffects(effectList)
	{
		var effects = effectList.split("|");
		for (var i = 0;i < effects.length;i++)
		{
			this.setEffect(effects[i]);
		}
	}

	setEffect(effect)
	{
		switch(effect)
		{
			case "EF_ROTATE":
				this.setRotVector(0,0.015,0);	
			break;
			case "EF_RADIANT":
				
			break;
		}
	}

	setColorHex(hex)
	{
		this.color.setHex(hex);
		this.colordirty = 1;
	}

	setColor(r,g,b)
	{
		this.color.r = r;
		this.color.g = g;
		this.color.b = b;
		this.colordirty = 1;
	}

	setReflectivity(r)
	{
		this.reflectivity = r;
		this.colordirty = 1;
	}

	setSpecular(r,g,b)
	{
		this.specular.r = r;
		this.specular.g = g;
		this.specular.b = b;
		this.colordirty = 1;
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
			this.list[i].preDraw();
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
			this.list[i].postUpdate();
		}
	}
}
