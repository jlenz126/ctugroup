<!-- Start of Footer -->
<nav class="navbar navbar-dark fixed-bottom custom-colors ">
	  <div class="container-fluid justify-content-center">
	    <!-- Text and copyright for footer -->
	  	<center><h6 style="color: white">OvenWhisperer Pizza &copy; 2023</h6></center>
	  </div>
	</nav>
	<!-- Jquery and Bootstrap javascript import -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
	<script type="text/javascript">
        let alert_list = document.querySelectorAll('.alert')
        alert_list.forEach(function(alert) {
            new bootstrap.Alert(alert);

            let alert_timeout = alert.getAttribute('data-timeout');
            setTimeout(() => {
                bootstrap.Alert.getInstance(alert).close();
            }, +alert_timeout);
        });
    </script>
</body>
</html>
<!-- End of Footer -->
