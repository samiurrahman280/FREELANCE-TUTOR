<?php 
require_once '../model/db.php';

function fetchAllStudents(){
    $conn = getConnection();
    $sql = "SELECT * FROM students";
    $result = mysqli_query($conn, $sql);

    $users = [];

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
    }
    return $users;
}

function fetchStudentByEmail($student) {
    $conn = getConnection();
    $sql = "SELECT * FROM students WHERE email = '{$student['email']}'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}

function insertStudent($student) {
    $conn = getConnection();

    $sql = "INSERT INTO students (
        name, email, phone, gender,
        country, dob, class, profile_picture, password, created_at
    ) VALUES (
        '{$student['name']}',
        '{$student['email']}',
        '{$student['phone']}',
        '{$student['gender']}',
        '{$student['country']}',
        '{$student['dob']}',
        '{$student['class']}',
        '{$student['profile_picture']}',
        '{$student['password']}',
        '{$student['created_at']}'
    )";

    $checkEmail = "SELECT * FROM students WHERE email = '{$student['email']}'";
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

function updateStudent($student) {
    $conn = getConnection();
    $sql = "UPDATE students SET
        `name` = '{$student['name']}',
        `phone` = '{$student['phone']}',
        `gender` = '{$student['gender']}',
        `country` = '{$student['country']}',
        `dob` = '{$student['dob']}',
        `class` = '{$student['class']}',
        `profile_picture` = '{$student['profile_picture']}'
     WHERE email = '{$student['email']}'";
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false;
    }
}

function deleteStudentFromDB($student) {
    $conn = getConnection();
    $sql = "DELETE FROM students WHERE email = '{$student['email']}'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "Deleted Successfully";
    } else {
        echo "Invalid";
    }
}



/*
function createStudent($student, $profilePath) {
    $conn = getConnection();
    $name = mysqli_real_escape_string($conn, $student['name']);
    $email = mysqli_real_escape_string($conn, $student['email']);
    $phone = mysqli_real_escape_string($conn, $student['phone']);
    $gender = mysqli_real_escape_string($conn, $student['gender']);
    $country = mysqli_real_escape_string($conn, $student['country']);
    $dob = mysqli_real_escape_string($conn, $student['dob']);
    $class = mysqli_real_escape_string($conn, $student['class']);
    $password = password_hash($student['password'], PASSWORD_DEFAULT);
    $profile_picture = mysqli_real_escape_string($conn, $profilePath);
    $created_at = date("Y-m-d H:i:s");

    $checkEmail = "SELECT * FROM students WHERE email = '$email'";
    $result = mysqli_query($conn, $checkEmail);

    if (mysqli_num_rows($result) == 0) {
        $sql = "INSERT INTO students 
            (name, email, phone, gender, country, dob, class, profile_picture, password, created_at)
            VALUES 
            ('$name', '$email', '$phone', '$gender', '$country', '$dob', '$class', '$profile_picture', '$password', '$created_at')";

        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            echo "Insert error: " . mysqli_error($conn);
            return false;
        }
    } else {
        return false; // email already exists
    }
}

function getStudentByEmail($email) {
    $conn = getConnection();
    $email = mysqli_real_escape_string($conn, $email);
    $sql = "SELECT * FROM students WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    }
    return false;
}

function getStudentById($id) {
    $conn = getConnection();
    $id = (int)$id;
    $sql = "SELECT * FROM students WHERE student_id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    }
    return false;
}

function updateStudent($student, $profilePath = null) {
    $conn = getConnection();
    $id = (int)$student['student_id'];
    $name = mysqli_real_escape_string($conn, $student['name']);
    $phone = mysqli_real_escape_string($conn, $student['phone']);
    $gender = mysqli_real_escape_string($conn, $student['gender']);
    $country = mysqli_real_escape_string($conn, $student['country']);
    $dob = mysqli_real_escape_string($conn, $student['dob']);
    $class = mysqli_real_escape_string($conn, $student['class']);
    $updated_at = date("Y-m-d H:i:s");

    $sql = "UPDATE students SET
        name = '$name',
        phone = '$phone',
        gender = '$gender',
        country = '$country',
        dob = '$dob',
        class = '$class',
        updated_at = '$updated_at'";

    if ($profilePath !== null) {
        $profile_picture = mysqli_real_escape_string($conn, $profilePath);
        $sql .= ", profile_picture = '$profile_picture'";
    }

    $sql .= " WHERE student_id = $id";

    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        echo "Update error: " . mysqli_error($conn);
        return false;
    }
}

function deleteStudent($id) {
    $conn = getConnection();
    $id = (int)$id;
    $sql = "DELETE FROM students WHERE student_id = $id";
    return mysqli_query($conn, $sql);
}
*/
function getAllTeachers() {
    $conn = getConnection();
    $sql = "SELECT * FROM teachers ORDER BY name";
    $result = mysqli_query($conn, $sql);

    $teachers = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $teachers[] = $row;
        }
    }
    return $teachers;
}


