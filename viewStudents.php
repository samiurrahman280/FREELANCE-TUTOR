<?php
session_start();
if (isset($_SESSION['email'])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Information Table</title>
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>

    <body>
        <?php
        include_once "../view/header.php";
        require_once "../model/student_model.php";
        $students = fetchAllStudents();
        // print_r($students);
        ?>
        <div class="container">
            <input type="search" name="search" id="search" placeholder="Search students...">

            <table id="studentTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Country</th>
                        <th>DOB</th>
                        <th>Class</th>
                        <th>Profile Picture</th>
                    </tr>
                </thead>

                <?php if (!empty($students)) { ?>
                    <tbody>
                        <?php foreach ($students as $student) { ?>
                            <tr>
                                <td><?= $student['name'] ?></td>
                                <td><?= $student['email'] ?></td>
                                <td><?= $student['phone'] ?></td>
                                <td><?= $student['gender'] ?></td>
                                <td><?= $student['country'] ?></td>
                                <td><?= $student['dob'] ?></td>
                                <td><?= $student['class'] ?></td>
                                <td><img src="<?php echo $student['profile_picture'] ?>" alt="Profile Picture" width="50"></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                <?php } ?>
            </table>
        </div>
        <?php include_once "../view/footer.php"; ?>
    </body>
    <script src="../assets/js/script.js"></script>
    </html>
<?php
}
// else {
//     header('location: ./');
// }
?>