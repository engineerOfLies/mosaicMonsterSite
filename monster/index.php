<?php include('header.php'); ?>
  <body>
    <link href="carousel.css" rel="stylesheet">
<div class="container">
        <h1>Monsters of the Mosaic World</h1>
        <p class="lead">A web based monster training role playing game.</p>
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
        <div class="carousel-item active">
          <img class="first-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="First slide">
          <div class="container">
            <div class="carousel-caption d-none d-md-block text-left">
              <h1>Sign up for free and choose your starting form.</h1>
              <p>Train and it watch your monster mutate into stranger, more powerful forms</p>
              <p><a class="btn btn-lg btn-primary" href="login.php" role="button">Sign up today</a></p>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <img class="second-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Second slide">
          <div class="container">
            <div class="carousel-caption d-none d-md-block">
              <h1>Explore the world of the strange mosaic and discover its secrets.</h1>
			  <p>Find new locations that each offer chances to train, explore dungeons and combat wild monsters.</p>
              <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <img class="third-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Third slide">
          <div class="container">
            <div class="carousel-caption d-none d-md-block text-right">
              <h1>Battle Online against friends or non player monsters.</h1>
			  <p>You can match against your friends, fight against other players and wild monsters with the deep asynchronous combat system</p>
              <p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>
            </div>
          </div>
        </div>
      </div>
      <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>

    </div>
  </body>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

<?php include('footer.php'); ?>
<script>
</script>
</html>

