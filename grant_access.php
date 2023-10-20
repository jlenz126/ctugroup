grant_access.php

<?php
// Assuming the manager is already logged in and the manager's username is stored in the $manager variable

// Array to store the associates with access granted by the manager
$associates_with_access = [];

// Function to grant access to an associate
function grantAccess($associate_username)
{
    global $associates_with_access;
    if (!in_array($associate_username, $associates_with_access)) {
        $associates_with_access[] = $associate_username;
    }
}

// Example usage
grantAccess('associate1');
grantAccess('associate2');

// Displaying the associates with access
echo "Associates with access: <br>";
foreach ($associates_with_access as $associate) {
    echo $associate . "<br>";
}
?>
