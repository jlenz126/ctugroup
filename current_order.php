<?php
//needs to be included below session.php and db_connection
//if needed will create $_SESSION['currentOrderID] based on
//if the user is logged in or a guest
//guest carts will be lost when they close there browser

if(!isset($_SESSION['currentOrderID'])){
    if(isset($_SESSION['user_id'])){
        //check for active order for user else create order
    } else {
        //create order using session id
    }
}

?>