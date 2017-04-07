<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="mosaic monsters, all rights reserved Donald Kehoe 2017">
    <meta name="author" content="Donald Kehoe">
    <link rel="icon" href="favicon.ico">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="navbar-top.css" rel="stylesheet">
	<body class="bg">
	<nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse mb-0 gradiated">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="./">Mosaic Monsters</a>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a id="monster" class="nav-link" style="display:none;" href="monster.php">MONSTER <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a id="profile" class="nav-link" style="display:none;" href="profile.php">PLAYER <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a id="notices" class="nav-link disabled" style="display:none;" href="#">NOTICE <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a id = "about" class="nav-link disabled" href="#">ABOUT <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a id="contact" class="nav-link disabled" href="#">CONTACT <span class="sr-only">(current)</span></a>
          </li>
        </ul>
		<form class="form-inline mt-2 mt-md-0">
          <button id="loginButton" class="btn my-2 my-sm-0" type="button" onclick = "location.reload();location.href='login.php'">login</button>
        </form>
      </div>
    </nav>
  <title>Mosaic Monsters</title>
  </head>

