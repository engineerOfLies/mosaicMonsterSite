	<footer>
	<?php require_once("footstrap.php") ?>
	<script>
/*	document.onload = function()*/
	if (typeof sessionStorage.sessionId !== 'undefined')
{
	$("#profile").removeClass('disabled');
	$("#monster").removeClass('disabled');
	$("#notices").removeClass('disabled');
	$("#profile").prop('disabled', true);
	$("#loginButton").text('logout');
	$("#loginButton").removeClass('btn-default');
	$("#loginButton").addClass('btn-danger');
	document.getElementById("loginButton").onclick = function() {location.reload();location.href='logout.php';};
}
else
{
	$("#profile").addClass('disabled');
	$("#loginButton").text('login');
	$("#loginButton").addClass('btn-default');
	$("#loginButton").removeClass('btn-danger');
	document.getElementById("loginButton").onclick = function() {location.reload();location.href='login.php';};
}
// send session validation
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
	</script>
	<div id="output">
	</div>
	</footer>

