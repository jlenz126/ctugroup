<?php
(isset($_SESSION['user_id'])) ? $login = 'logout' :  $login = 'login';
(isset($_SESSION['employee'])) ? $employee = 'management_dashboard' :  $employee = 'contact';

?>

<!-- Start Navbar -->
<body>
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark custom-colors">
	  <div class="container-fluid">
		<!-- change home link to mini logo image -->
		<!-- mini logo added replaced home link -->
	  	<a class="navbar-brand" href="index.php"><img src="images/pizza-logo.png" class="img-responsive" alt="logo"></a>
		<a class="navbar-brand" href="menu.php">Menu</a>
	    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	      <span class="navbar-toggler-icon"></span>
	    </button>
	    <div class="collapse navbar-collapse" id="navbarSupportedContent">
	      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
		  	<li class="nav-item">
			<?php
	          echo '<a class="nav-link active" aria-current="page" href="'. $login .'.php">'. ucfirst($login) .'</a>';
			?>
	        </li>
			<li class="nav-item">
	          <a class="nav-link active" aria-current="page" href="reviews.php">Reviews</a>
	        </li>
			<li class="nav-item">
			<?php
			switch($employee){
				case 'management_dashboard':
					echo '<a class="nav-link active" aria-current="page" href="'. $employee .'.php">Management Dashboard</a>';
					break;
				case 'contact':
					echo '<a class="nav-link active" aria-current="page" href="'. $employee .'.php">Contact Us</a>';
					break;
				default:
					// error
			}

			?>
	        </li>
	      </ul>
	      <a class="nav-item nav-link active d-flex" style="color: white" aria-current="page" href="cart.php">Cart</a>
	    </div>
	  </div>
	</nav>
	<!-- End Navbar Code -->
