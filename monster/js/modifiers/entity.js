
var EntityList = [];
function Entity (name,data,update,draw)
{
	this.name = name;
	this.data = data;
	this.update = update;
	this.draw = draw;
	EntityList.push(this);
}

function EntityUpdateList()
{
	var len = EntityList.length();
	var i;
	for(i = 0;i < len;i++)
	{
		if (EntityList[i].update !== undefined)
		{
			EntityList[i].update(EntityList[i]);
		}
	}
}

function EntityDrawList()
{
	var len = EntityList.length();
	var i;
	for(i = 0;i < len;i++)
	{
		if (EntityList[i].draw !== undefined)
		{
			EntityList[i].draw(EntityList[i]);
		}
	}
}


