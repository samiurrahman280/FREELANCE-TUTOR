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
        require_once "../model/teacher_model.php";
        $teachers = fetchAllTeachers();
         //print_r($teachers);
        ?>
        <div class="container">
            <div class="table-responsive">
            <input type="search" name="searchteacher" id="searchteacher" placeholder="Search teachers...">

            <table id="teacherTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>DOB</th>
                        <th>Educational Qualification</th>
                        <th>Subject Expert</th>
                        <th>Profile Picture</th>
                        <th>Document</th>
                        <th>Bio</th>
                    </tr>
                </thead>

                <?php if (!empty($teachers)) { ?>
                    <tbody>
                        <?php foreach ($teachers as $teacher) { ?>
                            <tr>
                                <td><?= $teacher['name'] ?></td>
                                <td><?= $teacher['email'] ?></td>
                                <td><?= $teacher['phone'] ?></td>
                                <td><?= $teacher['gender'] ?></td>
                                <td><?= $teacher['dob'] ?></td>
                                <td><?= $teacher['educational_qualification'] ?></td>
                                <td><?= $teacher['subject_expert'] ?></td>
                                <td><img src="<?php echo $teacher['profile_picture'] ?>" alt="Profile Picture" width="50"></td>
                                <td><img src="<?php echo $teacher['document'] ?>" alt="document" width="50"></td>
                                <td><?= $teacher['bio'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                <?php } ?>
            </table>
          </div>
        </div>
        <?php include_once "../view/footer.php"; ?>
    </body>
    <script src="../assets/js/script.js"></script>
    </html>
<?php
}

?>