<?php
function getConnection(){
    $host = "localhost";
$user = "root";  // adjust if needed
$pass = "";      // adjust if needed
$dbname = "freelance tutor_db";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else{
    //echo "Hello OO";
}
return $conn;
}

?>
