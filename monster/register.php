<?php include('header.php'); ?>
<link href="signin.css" rel="stylesheet">
<body>

    <div id="registerForm" class="container">

      <form class="form-signin">
        <h2 class="form-signin-heading">Register</h2>
        <label for="inputName" class="sr-only">Username</label>
        <input type="username" id="inputName" class="form-control" placeholder="Username" required autofocus>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <label for="inputPasswordV" class="sr-only">Verify Password</label>
        <input type="password" id="inputPasswordV" class="form-control" placeholder="Verify Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="button" onclick="submitRegister()">Register </button>
        <p>already registered?<a class="btn btn-link" href="login.php" role="button">login</a></p>
      </form>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script>
function submitRegister()
{

	var uname = document.getElementById("inputName").value;
	var email = document.getElementById("inputEmail").value;
	var pword = document.getElementById("inputPassword").value;
	var vpword = document.getElementById("inputPasswordV").value;
	if (pword != vpword)
	{
		alert("Passwords do not match!");
		location.reload();
		return 0;
	}
	sendRegisterRequest(uname,pword,email);
	return 0;
}

function HandleRegisterResponse(response)
{
	var data = JSON.parse(response);
	var text = JSON.stringify(response);
	if (data.status != "success")
	{
		alert("Registration Failed: "+data.status);
		location.reload();
	}
	else
	{
		alert("Registration Successful");
		location.href = "login.php";
	}
}

function sendRegisterRequest(username,password,email)
{
	var request = new XMLHttpRequest();
	request.open("POST","rpc/auth.php",true);
	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	request.onreadystatechange = function ()
	{
		if ((this.readyState == 4)&&(this.status == 200))
		{
			HandleRegisterResponse(this.responseText);
		}
	}
	request.send("type=register&username="+username+"&password="+password+"&email="+email);
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


