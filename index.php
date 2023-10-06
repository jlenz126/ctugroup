<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
?>

	<!-- Main container with logo and intro text -->
	<div class="container-fluid">
		<div class="row">
			<div class="main-view landingPadding">
				<!-- Add logo and restaurant here <h1> is just a place holder -->
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

<?php
include_once 'footer.php';
?>