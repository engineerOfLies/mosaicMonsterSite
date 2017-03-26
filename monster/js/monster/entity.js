
class EntityList
{
	constructor()
	{
		this.list = [];
	}

	spawn(ename,edata,eupdate,edraw)
	{
		var ent = {
			name : ename,
			data : edata,
			update :eupdate,
			draw : edraw
		};
		this.list.push(ent);
		return ent;
	}

	drawAll()
	{
		var i,l;
		l = this.list.length;
		for (i = 0; i < l;i++)
		{
			if (this.list[i].update != undefined)
			{
				this.list[i].update(this.list[i]);
			}
		}
	}

	updateAll()
	{
		var i,l;
		l = this.list.length;
		for (i = 0; i < l;i++)
		{
			if (this.list[i].update != undefined)
			{
				this.list[i].update(this.list[i]);
			}
		}
	}
}
