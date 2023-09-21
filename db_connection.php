<?php
function OpenCon()
{
$dbhost = "localhost";
$dbuser = "test_user";
$dbpass = "1234";
$dbname = "test";
$conn = new mysqli($dbhost, $dbuser, $dbpass,$dbname) or die("Connect failed: %s\n". $conn -> error);
return $conn;
}
function CloseCon($conn)
{
$conn -> close();
}
?>