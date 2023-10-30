<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <h2>Leave a Review</h2>

                <form action="review_processor.php" method="POST" class="mt-3">
                    <fieldset>              
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating (1-5):</label>
                            <input type="number" name="rating" class="form-control" min="1" max="5" required>
                        </div>
                        <div class="mb-3">
                            <label for="review" class="form-label">Review:</label>
                            <input type="text" name="review" rows="4" class="form-control" required>
                        </div>
                    </fieldset>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-light">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
    body {
        background-image: none;	
        padding-top: 75px; /* Adjusted based on navbar's height */
        padding-bottom: 75px;
        background-image: none;
    }
    .main-view {
        max-width: 600px;
        margin: 0 auto; /* Vertically centered and horizontally centered */
        padding: 5px;  /* Some padding for better spacing */
    }		
    
</style>
<?php
include_once 'footer.php';
?>