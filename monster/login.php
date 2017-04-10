<?php include('header.php'); ?>
<link href="signin.css" rel="stylesheet">
<body>

    <div id="loginForm" class="container">

      <form class="form-signin">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputName" class="sr-only">Username</label>
        <input type="username" id="inputName" class="form-control" placeholder="Username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="button" onclick="submitLogin()">Sign in</button>
        <p><a class="btn btn-link" href="register.php" role="button">register</a></p>
      </form>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script>
function submitLogin()
{

	var uname = document.getElementById("inputName").value;
	var pword = document.getElementById("inputPassword").value;
	sendLoginRequest(uname,pword);
	return 0;
}

function HandleLoginResponse(response)
{
	var data = JSON.parse(response);
	var text = JSON.stringify(response);
	if (data.status != "success")
	{
		alert("Login Failed");
		location.reload();
	}
	else
	{
		sessionStorage.setItem("sessionId",data.sessionId);
		sessionStorage.setItem("username",data.username);
		sessionStorage.setItem("role",data.role);
		location.href = "care.php";
	}
}

function sendLoginRequest(username,password)
{
	var request = new XMLHttpRequest();
	request.open("POST","rpc/auth.php",true);
	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	request.onreadystatechange = function ()
	{
		if ((this.readyState == 4)&&(this.status == 200))
		{
			HandleLoginResponse(this.responseText);
		}
	}
	request.send("type=auth&username="+username+"&password="+password);
}

</script>
  </body>
<?php include('footer.php'); ?>
<script>
function logOut()
{
	sessionStorage.setItem("sessionId",undefined);
	sessionStorage.setItem("username",undefined);
	sessionStorage.setItem("role",undefined);
}
if (sessionStorage.sessionId !== undefined)
{
	$("#loginForm").addClass("hidden");
}
</script>
</html>

