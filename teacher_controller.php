
<?php
session_start();
error_reporting(E_ALL);
require_once "../model/teacher_model.php";

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
    if ($email === "") {
        echo "Email is required<br>";
        return false;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
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
    }
    if (!preg_match('/^\d{10,15}$/', $phone)) {
        echo "Phone number must be 10 to 15 digits<br>";
        return false;
    }
    return true;
}

function validateGender() {
    if (!isset($_POST['gender']) || trim($_POST['gender']) === "") {
        echo "Gender is required<br>";
        return false;
    }
    $validGenders = ['Male', 'Female', 'Other'];
    if (!in_array($_POST['gender'], $validGenders)) {
        echo "Invalid gender selected<br>";
        return false;
    }
    return true;
}

function validateDOB() {
    $dob = trim($_POST['dob']);
    if ($dob === "") {
        echo "Date of Birth is required<br>";
        return false;
    }
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob)) {
        echo "Invalid date format for DOB<br>";
        return false;
    }
    return true;
}

function validateEducationalQualification() {
    $educational_qualification = trim($_POST['educational_qualification']);
    if ($educational_qualification === "") {
        echo "Educational qualification is required<br>";
        return false;
    }
    return true;
}

function validateSubjectExpert() {
    $subject_expert = trim($_POST['subject_expert']);
    if ($subject_expert === "") {
        echo "Subject expertise is required<br>";
        return false;
    }
    return true;
}

function validateBio() {
    $bio = trim($_POST['bio']);
    if ($bio === "") {
        echo "Bio is required<br>";
        return false;
    }
    return true;
}

function validatePassword() {
    $password = trim($_POST['password']);
    if ($password === "") {
        echo "Password is required<br>";
        return false;
    }
    if (strlen($password) < 6) {
        echo "Password must be at least 6 characters<br>";
        return false;
    }
    return true;
}

function validateConfirmPassword() {
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);
    if ($confirmPassword === "") {
        echo "Confirm password is required<br>";
        return false;
    }
    if ($password !== $confirmPassword) {
        echo "Password and Confirm password do not match<br>";
        return false;
    }
    return true;
}

function validateProfilePicture() {
    global $profileFileName;
    if (!isset($_FILES['profile_picture']) || $_FILES['profile_picture']['error'] === UPLOAD_ERR_NO_FILE) {
        echo "Profile picture is required<br>";
        return false;
    }

    $profileFile = $_FILES["profile_picture"];
    $allowedTypes = ["image/jpg", "image/jpeg", "image/png"];
    $maxSize = 5 * 1024 * 1024;

    if ($profileFile["error"] !== UPLOAD_ERR_OK) {
        echo "Error uploading file.<br>";
        return false;
    }

    if (!in_array($profileFile["type"], $allowedTypes)) {
        echo "Only JPG, JPEG, or PNG formats are allowed.<br>";
        return false;
    }

    if ($profileFile["size"] > $maxSize) {
        echo "File size must be less than 5MB.<br>";
        return false;
    }

    $tmpProfile = explode('.', $profileFile['name']);
    $profileFileName = round(microtime(true)*1000) . '.' . end($tmpProfile);

    $uploadDir = "../assets/uploads/teachers/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $uploadPath = $uploadDir . $profileFileName;

    if (move_uploaded_file($profileFile["tmp_name"], $uploadPath)) {
        return true;
    } else {
        echo "Error saving uploaded photo.<br>";
        return false;
    }

}

function validateDocument() {
    global $documentFileName;
    if (!isset($_FILES['document']) || $_FILES['document']['error'] === UPLOAD_ERR_NO_FILE) {
        echo "Document is required<br>";
        return false;
    }
    $documentFile = $_FILES["document"];
    $allowedTypes = ["image/jpg", "image/jpeg", "image/png"];
    $maxSize = 5 * 1024 * 1024;

    if ($documentFile["error"] !== UPLOAD_ERR_OK) {
        echo "Error uploading file.<br>";
        return false;
    }

    if (!in_array($documentFile["type"], $allowedTypes)) {
        echo "Only JPG, JPEG, or PNG formats are allowed.<br>";
        return false;
    }

    if ($documentFile["size"] > $maxSize) {
        echo "File size must be less than 5MB.<br>";
        return false;
    }

    $tmpDoc = explode('.', $documentFile['name']);
    $documentFileName = round(microtime(true) * 1000 + 1) . '.' . end($tmpDoc);  // <<< 

    $uploadDir = "../assets/uploads/teachers/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $uploadPath = $uploadDir . $documentFileName;

    if (move_uploaded_file($documentFile["tmp_name"], $uploadPath)) {
        return true;
    } else {
        echo "Error saving uploaded photo.<br>";
        return false;
    }
}


function validateTeacherRegistration() {
    return (
        validateName() &&
        validateEmail() &&
        validatePhone() &&
        validateGender() &&
        validateDOB() &&
        validateEducationalQualification() &&
        validateSubjectExpert() &&
        validateBio() &&
        validatePassword() &&
        validateConfirmPassword() &&
        validateProfilePicture() &&
        validateDocument()
    );
}


function pushTeacher(){
    global $profileFileName, $documentFileName; 
    $conn = getConnection();
    $profileFile = $_FILES["profile_picture"];
    $profileTmp = explode('.', $profileFile['name']);
    $newFileName = round(microtime(true)) . '.' . end($profileTmp);
    $documentFile = $_FILES["document"];
    $tmpDoc = explode('.', $documentFile['name']);
    $newFileNamedoc = round(microtime(true)) . '.' . end($tmpDoc);
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $dob = mysqli_real_escape_string($conn, trim($_POST['dob']));
    $gender = mysqli_real_escape_string($conn, trim($_POST['gender']));
    $educational_qualification = mysqli_real_escape_string($conn, trim($_POST['educational_qualification']));
    $subject_expert = mysqli_real_escape_string($conn, trim($_POST['subject_expert']));
    $bio = mysqli_real_escape_string($conn, trim($_POST['bio']));
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $profile_picture = mysqli_real_escape_string($conn, "../assets/uploads/teachers/" . $profileFileName);
    $document = mysqli_real_escape_string($conn, "../assets/uploads/teachers/" . $documentFileName);
    $created_at = date("Y-m-d H:i:s");
    $updated_at = date("Y-m-d H:i:s");


    $teacher = [

        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'dob' => $dob,
        'gender' => $gender,
        'educational_qualification' => $educational_qualification,
        'subject_expert' => $subject_expert,
        'bio' => $bio,
        'password' => $password,
        'profile_picture' => $profile_picture,
        'document' => $document,
        'created_at' => $created_at,
        'updated_at' => $updated_at
    ];
    $status = insertTeacher($teacher);
    if($status){
        return true;
    }else{
        return false;
    }
}





function updateTeacherfunc() {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $dob = trim($_POST['dob']);
    $gender = trim($_POST['gender']);
    $educational_qualification = trim($_POST['educational_qualification']);
    $subject_expert = trim($_POST['subject_expert']);
    $bio = trim($_POST['bio']);
    $updated_at = date("Y-m-d H:i:s");
    $email = trim($_SESSION['email'] ?? '');

    $oldProfilePicture = $_POST['old_profile_picture'] ?? '';
    $oldDocument = $_POST['old_document'] ?? '';

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] !== UPLOAD_ERR_NO_FILE) {
        $profileFile = $_FILES['profile_picture'];
        $tmpProfile = explode('.', $profileFile['name']);
        $profileFileName = round(microtime(true)*1000) . '.' . end($tmpProfile);
        $uploadDir = "../assets/uploads/teachers/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $uploadPath = $uploadDir . $profileFileName;
        move_uploaded_file($profileFile['tmp_name'], $uploadPath);
        $profile_picture = $uploadPath;
    } else {
        $profile_picture = $oldProfilePicture;
    }

    if (isset($_FILES['document']) && $_FILES['document']['error'] !== UPLOAD_ERR_NO_FILE) {
        $documentFile = $_FILES['document'];
        $tmpDoc = explode('.', $documentFile['name']);
        $documentFileName = round(microtime(true)*1000 + 1) . '.' . end($tmpDoc);
        $uploadDir = "../assets/uploads/teachers/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $uploadPathDoc = $uploadDir . $documentFileName;
        move_uploaded_file($documentFile['tmp_name'], $uploadPathDoc);
        $document = $uploadPathDoc;
    } else {
        $document = $oldDocument;
    }

    $teacher = [
        'name' => $name,
        'phone' => $phone,
        'dob' => $dob,
        'gender' => $gender,
        'educational_qualification' => $educational_qualification,
        'subject_expert' => $subject_expert,
        'bio' => $bio,
        'updated_at' => $updated_at,
        'profile_picture' => $profile_picture,
        'document' => $document,
        'email' => $email
    ];

    $result = updateTeacher($teacher);

    if ($result) {
        return $teacher;  // Return updated data for session update
    } else {
        return false;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_GET['action'] ?? '';

    if ($action === "register") {
        if (validateTeacherRegistration() && pushTeacher()) {
            header('Location: ../view/login.php');
            exit();
        } else {
            echo "The email has already been used or there was an error.";
        }
    } elseif ($action === "update") {
    $updatedTeacher = updateTeacherfunc();
    if ($updatedTeacher) {
        $_SESSION['name'] = $updatedTeacher['name'];
        $_SESSION['phone'] = $updatedTeacher['phone'];
        $_SESSION['dob'] = $updatedTeacher['dob'];
        $_SESSION['gender'] = $updatedTeacher['gender'];
        $_SESSION['educational_qualification'] = $updatedTeacher['educational_qualification'];
        $_SESSION['subject_expert'] = $updatedTeacher['subject_expert'];
        $_SESSION['bio'] = $updatedTeacher['bio'];
        $_SESSION['profile_picture'] = $updatedTeacher['profile_picture'];
        $_SESSION['document'] = $updatedTeacher['document'];

        header('Location: ../view/viewTeachersProfile.php');
        exit();
    } else {
        echo "Failed to update user information<br>";
    }
}
elseif ($action === "delete") {
        $emailToDelete = trim($_POST['email'] ?? '');
        if ($emailToDelete !== '') {
            $teacher = ['email' => $emailToDelete];
            deleteTeacherFromDB($teacher);
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


function updateTeacherfunc() {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $dob = trim($_POST['dob']);
    $gender = trim($_POST['gender']);
    $educational_qualification = trim($_POST['educational_qualification']);
    $subject_expert = trim($_POST['subject_expert']);
    $bio = trim($_POST['bio']);
    $updated_at = date("Y-m-d H:i:s");
    $profile_picture = trim($_POST['profile_picture']);
    $document = trim($_POST['document']);
    
 
    $teacher = [
        'name' => $name,
        'phone' => $phone,
        'dob' => $dob,
        'gender' => $gender,
        'educational_qualification' => $educational_qualification,
        'subject_expert' => $subject_expert,
        'bio' => $bio,
        'updated_at' => $updated_at,
        'profile_picture' => $profile_picture,
        'document' => $document
    ];
 
    $status = updateTeacher($teacher);
    if($status) {
        return true;
    } else {
        echo "Failed to update user information<br>";
        return false;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (validateTeacherRegistration() && pushTeacher()) {
        header('Location: ../view/login.php');
        exit();
    } else{
        echo "The email have already used";
    }
}
*/