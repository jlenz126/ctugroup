<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
?>

<style>
    /* Default Styling */
    .main-view {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }
    .contact-box {
        border: 2px solid #ddd;
        padding: 20px;
        border-radius: 8px;
        position: relative;
        margin-top: 350px;
    }
    .contact-box::before {
        content: "CONTACT US";
        font-size: 40px;
        font-weight: bold;
        text-align: center;
        display: block;
        margin-bottom: 20px;
    }
    h2, h3 {
        margin-top: 20px;
    }

    /* Responsive Styling for screens 600px or smaller */
    @media screen and (max-width: 600px) {
        .main-view {
            max-width: 100%;
            padding: 5px;
        }
        .contact-box {
            margin-top: 300px;
            padding: 10px;
        }
        .contact-box::before {
            font-size: 28px;
        }
        h2, h3 {
            margin-top: 10px;
            font-size: 20px;
        }
        p, li {
            font-size: 14px;
        }
    }
</style>

<!-- Main container of page -->
<div class="container-fluid">
    <div class="row">
        <div class="main-view landingPadding">

            <!-- Contact Box -->
            <div class="contact-box">

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
<!-- End main container -->

<?php
include_once 'footer.php';
?>







