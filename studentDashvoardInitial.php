<?php
 session_start();
 if (isset($_SESSION['email'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
</head>
<body>
    <?php
    include_once "./header.php";
    
    ?>
    <div class="dashboard-links">
        <a href="./viewStudentsProfile.php" class="dashboard-link green">My Account</a>
        <a href="./viewTeachers.php" class="dashboard-link blue">View teachers</a>
    </div>
    <?php include_once "./footer.php"; ?>
</body>
</html>
<?php
} 

 ?>