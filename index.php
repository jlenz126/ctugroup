<!-- Start Header -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Demo Page</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<!-- End Header -->

<!-- Start Navbar -->
<body>
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark custom-colors">
	  <div class="container-fluid">
	  	<a class="navbar-brand" href="index.php">Home</a>
		<a class="navbar-brand" href="menu.php">Menu</a>
	    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	      <span class="navbar-toggler-icon"></span>
	    </button>
	    <div class="collapse navbar-collapse" id="navbarSupportedContent">
	      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
	        <li class="nav-item">
	          <a class="nav-link active" aria-current="page" href="reviews.php">Reviews</a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link active" aria-current="page" href="about.php">About</a>
	        </li>
			<li class="nav-item">
	          <a class="nav-link active" aria-current="page" href="contact.php">Contact Us</a>
	        </li>
	      </ul>
	      <a class="nav-item nav-link active d-flex" style="color: white" aria-current="page" href="cart.php">Cart</a>
	    </div>
	  </div>
	</nav>
	<!-- End Navbar Code -->

	<!-- Main container with logo and intro text -->
	<div class="container-fluid">
		<div class="row">
			<div class="main-view landingPadding">
				<h1>Restaurant Logo/Title</h1>
			</div>
		</div>
	</div>
	<!-- End main container -->

	<!-- Start of Service Cards -->
	<div class="row container-fluid serviceCards">
	  <div class="col-sm-12 col-md-4">
	    <div class="card h-100">
	      <div class="card-body custom-colors">
	        <h5 class="card-title">Featured Item 1</h5>
	        <p class="card-text">description of item</p>
			<a href="featured1.php" class="btn btn-light">Add to Cart</a>
	      </div>
	    </div>
	  </div>
	  <div class="col-sm-12 col-md-4">
	    <div class="card h-100">
	      <div class="card-body custom-colors">
	        <h5 class="card-title">Specials</h5>
	        <p class="card-text">Current deals and specials</p>
			<a href="specials.php" class="btn btn-light">Specials</a>
	      </div>
	    </div>
	  </div>
	  <div class="col-sm-12 col-md-4">
	    <div class="card h-100">
	      <div class="card-body custom-colors">
	        <h5 class="card-title">Featured Item 2</h5>
	        <p class="card-text">description of item</p>
			<a href="featured2.php" class="btn btn-light">Add to Cart</a>
	      </div>
	    </div>
	  </div>
	  <div class="col-sm-12 col-md-4">
	    <div class="card h-100">
	      <div class="card-body custom-colors">
	        <h5 class="card-title">Review 1</h5>
	        <p class="card-text">Randomly picked review</p>
	      </div>
	    </div>
	  </div>
	  <div class="col-sm-12 col-md-4">
	    <div class="card h-100">
	      <div class="card-body custom-colors">
	        <h5 class="card-title">Review 2</h5>
	        <p class="card-text">Randomly picked review</p>
	      </div>
	    </div>
	  </div>
	  <div class="col-sm-12 col-md-4">
	    <div class="card h-100">
	      <div class="card-body custom-colors">
	        <h5 class="card-title">Review 3</h5>
	        <p class="card-text">Randomly picked review</p>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- End of Service Cards -->

	<!-- Start of Footer -->
	<nav class="navbar fixed-bottom navbar-dark custom-colors">
	  <div class="container-fluid justify-content-center">
	    <center><h6 style="color: white">Restaurant Name &copy; 2023</h6></center>
	  </div>
	</nav>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>
	<!-- End of Footer -->