<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
?>

<style>
    /* Styling */
    .main-view {
        max-width: 800px;
        margin: 0 auto; 
        padding: 20px;
    }
    h2, h3 {
        margin-top: 20px;
    }
    html {
        overflow-y: visible;
    }
    .contact-padding {
        margin-top: 500px;
    }
</style>

<!-- Main container of page -->
<div class="container-fluid">
    <div class="row">
        <div class="main-view landingPadding">

            <!-- Contact Box -->
            <div class="contact-box contact-background">

                <!-- Address -->
                <h2>Address</h2>
                <p>123 Birch Ave, Phoenix, AZ 12345</p>

                <!-- Phone Number -->
                <h2>Phone Number</h2>
                <p>(123) 456-7890</p>

                <!-- Hours of Operation -->
                <h3>Hours of Operation</h3>
                <ul>
                    <li>Monday - Thursday: 11:00 AM - 10:00 PM</li>
                    <li>Friday - Saturday: 11:00 AM - 11:00 PM</li>
                    <li>Sunday: 12:00 PM - 9:00 PM</li>
                </ul>

            </div> <!-- End of Contact Box -->

        </div>
    </div>
</div>
<!-- adds padding so mobile devices in landscape can scroll to see all the info -->
<div class="row container-fluid contact-padding">

</div>
<!-- End main container -->

<?php
include_once 'footer.php';
?>
