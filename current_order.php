<?php
//if needed will create $_SESSION['currentOrderID] based on
//if the user is logged in or a guest
//guest carts will be lost when they close there browser


function createOrder($conn){
    if(!isset($_SESSION['currentOrderID'])){
        if(isset($_SESSION['user_id'])){
            //check for active order for user else create order
            $userID = $_SESSION['user_id'];
            $sql_check_saved_order = "SELECT `id` FROM `order` WHERE fulfilled = 0 and customer_id = $userID";
            $result_saved_order = $conn->query($sql_check_saved_order);
            if($result_saved_order->num_rows > 0){
                $_SESSION['currentOrderID'] = $result_saved_order->fetch_row()[0];
            } else {
                $sql_create_new_order = "INSERT INTO `order` (`id`, `customer_id`, `fulfilled`, `created_at`, `order_total`, `session_id`) VALUES (NULL, $userID, '0', current_timestamp(), NULL, NULL);";
                if($conn->query($sql_create_new_order) === TRUE){
                    $sql_get_order_ID = "SELECT `id` FROM `order` WHERE fulfilled = 0 and customer_id = $userID";
                    $result_order_ID = $conn->query($sql_get_order_ID);
                    $_SESSION['currentOrderID'] = $result_order_ID->fetch_row()[0];
                } else {
                    $_SESSION['errorMessage']='Failed to create order';
                }
            }
        } else {
            //create session order and set $_SESSION['currentOrderID]
            $sessionID = session_id();
            $sql_create_session_order = "INSERT INTO `order` (`id`, `customer_id`, `fulfilled`, `created_at`, `order_total`, `session_id`) VALUES (NULL, NULL, '0', current_timestamp(), NULL, '$sessionID');";
            if($conn->query($sql_create_session_order) === TRUE){
                $sql_get_order_ID = "SELECT `id` FROM `order` WHERE session_id = '$sessionID'";
                $result_order_ID = $conn->query($sql_get_order_ID);
                $_SESSION['currentOrderID'] = $result_order_ID->fetch_row()[0];
            } else {
                $_SESSION['errorMessage']='Failed to create order';
            }
        }
    }
}

?>