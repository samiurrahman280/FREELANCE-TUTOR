<?php
// STUDENT CONTROLLER
error_reporting(E_ALL);
session_start();
require_once "../model/student_model.php";


function validateName() {
    $name = trim($_POST['name']);
    if ($name === "") {
        echo "Name is required<br>";
        return false;
    }
    return true;
}

function validateEmail() {
    $email = trim($_POST['email']);
    $atPosition = strpos($email, '@');
    $dotPosition = strrpos($email, '.');
    if ($email === "") {
        echo "Email is required<br>";
        return false;
    } else if (strpos($email, '@') === false || strpos($email, '.') === false) {
        echo "Email must contain @ and .<br>";
        return false;
    } else if ($atPosition < 1 || $dotPosition < $atPosition + 2 || $dotPosition + 1 >= strlen($email)) {
        echo "Invalid email format<br>";
        return false;
    }
    return true;
}

function validatePhone() {
    $phone = trim($_POST['phone']);
    if ($phone === "") {
        echo "Phone number is required<br>";
        return false;
    } else if (!preg_match('/^\d{10,15}$/', $phone)) {
        echo "Phone number must be 10 to 15 digits<br>";
        return false;
    }
    return true;
}

function validateDateOfBirth() {
    $dob = trim($_POST['dob']);
    if ($dob === "") {
        echo "Date of Birth is required<br>";
        return false;
    }
    return true;
}

function validateGender() {
    if (!isset($_POST['gender']) || trim($_POST['gender']) == "") {
        echo "Gender is required<br>";
        return false;
    }
    return true;
}

function validateCountry() {
    $country = trim($_POST['country']);
    if ($country === "") {
        echo "Country is required<br>";
        return false;
    }
    return true;
}

function validateClass() {
    $class = trim($_POST['class']);
    if ($class === "") {
        echo "Class is required<br>";
        return false;
    }
    return true;
}

function validatePassword() {
    $password = trim($_POST['password']);
    if ($password === "") {
        echo "Password is required<br>";
        return false;
    } else if (strlen($password) < 6) {
        echo "Password must be at least 6 characters<br>";
        return false;
    }
    return true;
}

function validateConfirmPassword() {
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);
    if (empty($confirmPassword)) {
        echo "Confirm password is required<br>";
        return false;
    } else if ($password !== $confirmPassword) {
        echo "Password and confirm password do not match<br>";
        return false;
    }
    return true;
}

function validateUploadPhoto() {
    if (!isset($_FILES["profile_picture"]) || $_FILES["profile_picture"]["error"] === UPLOAD_ERR_NO_FILE) {
        echo "Profile Picture is required.<br>";
        return false;
    }
    $file = $_FILES["profile_picture"];
    $allowedTypes = ["image/jpg", "image/jpeg", "image/png"];
    $maxSize = 5 * 1024 * 1024; // 5MB

    if ($file["error"] !== UPLOAD_ERR_OK) {
        echo "Error uploading profile picture.<br>";
        return false;
    }

    if (!in_array($file["type"], $allowedTypes)) {
        echo "Only JPG, JPEG, or PNG formats are allowed for Profile Picture.<br>";
        return false;
    }

    if ($file["size"] > $maxSize) {
        echo "Profile picture size must be less than 5MB.<br>";
        return false;
    }
    $tmp = explode('.', $file['name']);
    $newFileName = round(microtime(true)) . '.' . end($tmp);

    $uploadDir = "../assets/uploads/students/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $uploadPath = $uploadDir . $newFileName;

    if (move_uploaded_file($file["tmp_name"], $uploadPath)) {
        return true;
    } else {
        echo "Error saving uploaded photo.<br>";
        return false;
    }

    //return true;
}

function validateStudentForm() {
    return (
        validateName() &&
        validateEmail() &&
        validatePhone() &&
        validateDateOfBirth() &&
        validateGender() &&
        validateCountry() &&
        validateClass() &&
        validatePassword() &&
        validateConfirmPassword() &&
        validateUploadPhoto()
    );
}


function pushStudent(){
    $conn = getConnection();
    $file = $_FILES["profile_picture"];
    $tmp = explode('.', $file['name']);
    $newFileName = round(microtime(true)) . '.' . end($tmp);
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $dob = mysqli_real_escape_string($conn, trim($_POST['dob']));
    $gender = mysqli_real_escape_string($conn, trim($_POST['gender']));
    $country = mysqli_real_escape_string($conn, trim($_POST['country']));
    $class = mysqli_real_escape_string($conn, trim($_POST['class']));
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $profile_picture = mysqli_real_escape_string($conn, "../assets/uploads/students/" . $newFileName);
    $created_at = date("Y-m-d H:i:s");

    $student = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'dob' => $dob,
        'gender' => $gender,
        'country' => $country,
        'class' => $class,
        'password' => $password,
        'profile_picture' => $profile_picture,
        'created_at' => $created_at
    ];
    $status = insertStudent($student);
    if($status){
        return true;
    }else{
        return false;
    }
}



function updateStudentfunc() {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $gender = trim($_POST['gender']);
    $country = trim($_POST['country']);
    $dob = trim($_POST['dob']);
    $class = trim($_POST['class']);
    $email = trim($_SESSION['email'] ?? '');

    $oldProfilePicture = $_POST['old_profile_picture'] ?? '';

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] !== UPLOAD_ERR_NO_FILE) {
        $profileFile = $_FILES['profile_picture'];
        $tmpProfile = explode('.', $profileFile['name']);
        $profileFileName = round(microtime(true)*1000) . '.' . end($tmpProfile);
        $uploadDir = "../assets/uploads/students/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $uploadPath = $uploadDir . $profileFileName;
        move_uploaded_file($profileFile['tmp_name'], $uploadPath);
        $profile_picture = $uploadPath;
    } else {
        $profile_picture = $oldProfilePicture;
    }


    $student = [
        'name' => $name,
        'phone' => $phone,
        'gender' => $gender,
        'country' => $country,
        'dob' => $dob,
        'class' => $class,
        'profile_picture' => $profile_picture,
        'email' => $email
    ];

    $result = updateStudent($student);

    if ($result) {
        return $student;  // Return updated data for session update
    } else {
        return false;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_GET['action'] ?? '';

    if ($action === "register") {
        if (validateStudentForm() && pushStudent()) {
            header('Location: ../view/login.php');
            exit();
        } else {
            echo "The email has already been used or there was an error.";
        }
    } elseif ($action === "update") {
    $updatedStudent = updateStudentfunc();
    if ($updatedStudent) {
        $_SESSION['name'] = $updatedStudent['name'];
        $_SESSION['phone'] = $updatedStudent['phone'];
        $_SESSION['gender'] = $updatedStudent['gender'];
        $_SESSION['country'] = $updatedStudent['country'];
        $_SESSION['dob'] = $updatedStudent['dob'];
        $_SESSION['class'] = $updatedStudent['class'];
        $_SESSION['profile_picture'] = $updatedStudent['profile_picture'];

        header('Location: ../view/viewStudentsProfile.php');
        exit();
    } else {
        echo "Failed to update user information<br>";
    }
}
elseif ($action === "delete") {
        $emailToDelete = trim($_POST['email'] ?? '');
        if ($emailToDelete !== '') {
            $student = ['email' => $emailToDelete];
            deleteStudentFromDB($student);
            session_destroy();
            header('Location: ../view/login.php');
            exit();
        } else {
            echo "Email is required to delete the teacher.";
        }
    } else {
        echo "Invalid action.";
    }
} else {
    echo "Invalid request method.";
}






/*

// Handling POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
     if (validateStudentForm() && pushStudent()) {
     header("Location: ../view/login.php");
     exit();
     } else {
     echo "The email have already used";
     }
    
}
?>

*/