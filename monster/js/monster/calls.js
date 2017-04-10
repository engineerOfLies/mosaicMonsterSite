<script>
function error(message)
{
	location.href = "error.php?msg="+message;
}
/*
	Monster Stats
*/

function handleMonsterSelectionResponse(response)
{
	var data = JSON.parse(response);
	if (data === "ok")
	{
		location.href = "care.php";
	}
}
function makeMonsterSelection(monsterName)
{
	if (sessionStorage.sessionId !== undefined)
	{
		var request = new XMLHttpRequest();
		var session = {
			id : sessionStorage.sessionId,
			name : sessionStorage.username
		};
		var sesString = JSON.stringify(session);
		request.open("POST","rpc/monsterData.php",true);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.onreadystatechange = function ()
		{
			if ((this.readyState == 4)&&(this.status == 200))
			{
				handleMonsterSelectionResponse(this.responseText);
			}
		}
		request.send("type=makeMonsterSelection&session="+sesString+"&monsterName="+monsterName);
	}
}
/*
get monster model properties
*/

function handlePlayerPartnerCheckResponse(response,callback)
{
	var data = JSON.parse(response);
	if (data.status === "ok")
	{
		if (callback !== undefined)
		{
			callback();
		}
		return;
	}
	location.href = "chooseStarter.php";
}
function playerPartnerCheck(callback)
{
	if (sessionStorage.sessionId !== undefined)
	{
		var request = new XMLHttpRequest();
		var session = {
			id : sessionStorage.sessionId,
			name : sessionStorage.username
		};
		var sesString = JSON.stringify(session);
		request.open("POST","rpc/monsterData.php",true);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.onreadystatechange = function ()
		{
			if ((this.readyState == 4)&&(this.status == 200))
			{
				handlePlayerPartnerCheckResponse(this.responseText,callback);
			}
		}
		request.send("type=playerPartnerCheck&session="+sesString);
	}
}

function handlePlayerMonsterModelResponse(response,callback)
{
	var data = JSON.parse(response);
	if ((data !== undefined)&&(data.status === "fail"))
	{
		location.href = "chooseStarter.php";
	}
	sessionStorage.monstermodel = data.model;
	sessionStorage.monstercolor = data.color;
	sessionStorage.monstereffects = data.effects;
	if (callback != undefined)
	{
		callback();
	}
}
function getPlayerMonsterModel(callback)
{
	if (sessionStorage.sessionId !== undefined)
	{
		var request = new XMLHttpRequest();
		var session = {
			id : sessionStorage.sessionId,
			name : sessionStorage.username
		};
		var sesString = JSON.stringify(session);
		request.open("POST","rpc/monsterData.php",true);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.onreadystatechange = function ()
		{
			if ((this.readyState == 4)&&(this.status == 200))
			{
				handlePlayerMonsterModelResponse(this.responseText,callback);
			}
		}
		request.send("type=getPlayerMonsterModel&session="+sesString);
	}
}

/*
	getting monster stats
*/


function handleMonsterStatsResponse(response,callback)
{
	var data = JSON.parse(response);
	if (data.status === "fail")
	{
		location.href = "chooseStarter.php";
	}
	sessionStorage.monster = response;
	if (callback != undefined)
	{
		callback();
	}
}
function getMonsterStats(callback)
{
	if (sessionStorage.sessionId !== undefined)
	{
		var request = new XMLHttpRequest();
		var session = {
			id : sessionStorage.sessionId,
			name : sessionStorage.username
		};
		var sesString = JSON.stringify(session);
		request.open("POST","rpc/monsterData.php",true);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.onreadystatechange = function ()
		{
			if ((this.readyState == 4)&&(this.status == 200))
			{
				handleMonsterStatsResponse(this.responseText,callback);
			}
		}
		request.send("type=getMonsterStats&session="+sesString);
	}
}
/*
	Player Profile
*/
function handleProfileResponse(response,callback)
{
	var data = JSON.parse(response);
	if (data.status === "fail")
	{
		sessionStorage.removeItem("sessionId");
		sessionStorage.removeItem("username");
		sessionStorage.removeItem("role");
		sessionStorage.removeItem("player");
		location.href = "login.php";
	}
	sessionStorage.profile = response;
	if (callback != undefined)
	{
		callback();
	}
}
function getPlayerProfile(callback)
{
	if (sessionStorage.sessionId !== undefined)
	{
		var request = new XMLHttpRequest();
		var session = {
			id : sessionStorage.sessionId,
			name : sessionStorage.username
		};
		var sesString = JSON.stringify(session);
		request.open("POST","rpc/playerData.php",true);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.onreadystatechange = function ()
		{
			if ((this.readyState == 4)&&(this.status == 200))
			{
				handleProfileResponse(this.responseText,callback);
			}
		}
		request.send("type=getPlayerProfile&session="+sesString);
	}
}
/* session validations */
function handleSessionResponse(response)
{	
	var data = JSON.parse(response);
	if (data !== "ok")
	{
		sessionStorage.removeItem("sessionId");
		sessionStorage.removeItem("username");
		sessionStorage.removeItem("role");
		location.href = "login.php";
	}
}
function validateSession()
{
	if (sessionStorage.sessionId !== undefined)
	{
		var request = new XMLHttpRequest();
		var session = {
			id : sessionStorage.sessionId,
			name : sessionStorage.username
		};
		var sesString = JSON.stringify(session);
		request.open("POST","rpc/auth.php",true);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.onreadystatechange = function ()
		{
			if ((this.readyState == 4)&&(this.status == 200))
			{
				handleSessionResponse(this.responseText);
			}
		}
		request.send("type=validate&session="+sesString);
	}
}
/*navbar setup*/

function navbarSetup()
{
	var monster = document.getElementById("monster");
	var player = document.getElementById("profile");
	var login = document.getElementById("loginButton");
	var notice = document.getElementById("notices");
	if (sessionStorage.sessionId !== undefined)
	{
		monster.style.display = "inherit";
		player.style.display = "inherit";
		notice.style.display = "inherit";
		login.innerHTML = "logout";
		login.classList.add("btn-danger");
		login.classList.remove("btn-default");
		login.onclick = function() {location.reload();location.href='logout.php';};
	}
}
</script>
