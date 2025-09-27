<?php
//session_start();  // Make sure session is started here
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Web Project</title>
    <link rel="stylesheet" href="../assets/css/style.css" />
    <script src="../assets/js/script.js" defer></script>
</head>

<body>
    <header>
        <nav>
            
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] === 'teacher'): ?>
                    <a href="teachersDahboardInitial.php">Teacher Dashboard</a>
                <?php elseif (isset($_SESSION['role_id']) && $_SESSION['role_id'] === 'student'): ?>
                    <a href="studentDashvoardInitial.php">Student Dashboard</a>
                <?php endif; ?>
                <a href="../controller/logout.php">Logout</a>
            <?php else: ?>
                <a href="home.php">Home</a>
                <a href="login.php">Login</a>
                <a href="teacher_signup.php">Teacher Signup</a>
                <a href="student_signup.php">Student Signup</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>
