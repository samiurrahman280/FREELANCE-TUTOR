
<?php 
require_once '../model/db.php';
function fetchAllTeachers(){
    $conn = getConnection();
    $sql = "SELECT * FROM teachers";
    $result = mysqli_query($conn, $sql);

    $users = [];

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
    }
    return $users;
}


function fetchTeacherByEmail($teacher) {
    $conn = getConnection();
    $sql = "SELECT * FROM teachers WHERE email = '{$teacher['email']}'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    }
    else{
    return false;
    }
}

function insertTeacher($teacher) {
    $conn = getConnection();

    $sql = "INSERT INTO teachers (
        name, email, phone, gender, dob, educational_qualification, 
        subject_expert, bio, password, profile_picture, document,
        created_at, updated_at
    ) VALUES (
        '{$teacher['name']}',
        '{$teacher['email']}',
        '{$teacher['phone']}',
        '{$teacher['gender']}',
        '{$teacher['dob']}',
        '{$teacher['educational_qualification']}',
        '{$teacher['subject_expert']}',
        '{$teacher['bio']}',
        '{$teacher['password']}',
        '{$teacher['profile_picture']}',
        '{$teacher['document']}',
        '{$teacher['created_at']}',
        '{$teacher['updated_at']}'
    )";

    $checkEmail = "SELECT * FROM teachers WHERE email = '{$teacher['email']}'";
    $result = mysqli_query($conn, $checkEmail);

    if (mysqli_num_rows($result) == 0) {
        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            echo "Insert error: " . mysqli_error($conn); // Debugging line
            return false;
        }
    } else {
        return false;
    }
}

function updateTeacher($teacher) {
    $conn = getConnection();
    $sql = "UPDATE teachers SET
        `name` = '{$teacher['name']}',
        `phone` = '{$teacher['phone']}',
        `dob` = '{$teacher['dob']}',
        `gender` = '{$teacher['gender']}',
        `educational_qualification` = '{$teacher['educational_qualification']}',
        `subject_expert` = '{$teacher['subject_expert']}',
        `bio` = '{$teacher['bio']}',
        `updated_at` = '{$teacher['updated_at']}',
        `profile_picture` = '{$teacher['profile_picture']}',
        `document` = '{$teacher['document']}'
     WHERE email = '{$teacher['email']}'";
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false;
    }
}

function deleteTeacherFromDB($teacher) {
    $conn = getConnection();
    $sql = "DELETE FROM teachers WHERE email = '{$teacher['email']}'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "Deleted Successfully";
    } else {
        echo "Invalid";
    }
}

function getAllStudents() {
    $conn = getConnection();
    $sql = "SELECT student_id, name, email, phone, gender, country, dob, class, profile_picture FROM students ORDER BY name ASC";
    $result = mysqli_query($conn, $sql);

    $students = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $students[] = $row;
        }
    }
    return $students;
}

