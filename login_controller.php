<?php
session_start();
require_once "../model/teacher_model.php";
require_once "../model/student_model.php";


//$_SESSION['errors'] = [];
//$errors = &$_SESSION['errors'];
// VALIDATE EMAIL
function validateEmail() {
    $email = trim($_POST['email']);
    $atPosition = strpos($email, '@');
    $dotPosition = strrpos($email, '.');
    if ($email === "") {
        echo "Email is required<br>";
        //$errors['email'] = "Email is required";
        return false;
    } else if ($atPosition === false || $dotPosition === false) {
        echo "Email must contain @ and .<br>";
       //$errors['email'] = "Email must contain @ and .";
        return false;
    } else if ($atPosition < 1 || $dotPosition < $atPosition + 2 || $dotPosition + 1 >= strlen($email)) {
        echo "Invalid email format<br>";
       // $errors['email'] = "Invalid email format";
        return false;
    }
    return true;
}

// VALIDATE PASSWORD
function validatePassword() {
    $password = trim($_POST['password']);
    if ($password == "") {
       // $errors['password'] = "Password is required";
        echo "Password is required<br>";
        return false;
    } else if (strlen($password) < 6) {
        echo "Password must be at least 6 characters<br>";
       // $errors['password'] = "Password must be at least 6 characters";
        return false;
    }
    return true;
}

function validateRole() {
    if (!isset($_POST['role']) || ($_POST['role'] !== 'teacher' && $_POST['role'] !== 'student')) {
        echo "Please select a valid role<br>";
       // $errors['role'] = "Please select a valid role";
        return false;
    }
    return true;
}

// LOGIN FUNCTION
function loginUserController(){
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];
    $user = [
        'email' => $email,
        'password' => $password
    ];

    

    if ($role=='teacher')
    {
       $teacher = fetchTeacherByEmail($user);

       if ($teacher) {
        session_unset();
        $_SESSION['user_id'] = $teacher['teacher_id'];
        $_SESSION['name'] = $teacher['name'];
        $_SESSION['email'] = $teacher['email'];
        $_SESSION['phone'] = $teacher['phone'];
        $_SESSION['gender'] = $teacher['gender'];
        $_SESSION['country'] = $teacher['country'];
        $_SESSION['dob'] = $teacher['dob'];
        $_SESSION['educational_qualification'] = $teacher['educational_qualification'];
        $_SESSION['subject_expert'] = $teacher['subject_expert'];
        $_SESSION['bio'] = $teacher['bio'];
        $_SESSION['profile_picture'] = $teacher['profile_picture'];
        $_SESSION['document'] = $teacher['document'];
        $_SESSION['role_id'] = 'teacher';
        $_SESSION['logged_in'] = true;

        header("Location: ../view/teachersDahboardInitial.php");
        exit();

        } else {
            echo "Invalid teacher credentials";
           //$errors['general'] = "Invalid teacher credentials";
        }

    }
    else if ($role === 'student')
    {
        $student = fetchStudentByEmail($user);

        if ($student) {
        session_unset();
        $_SESSION['user_id'] = $student['student_id'];
        $_SESSION['name'] = $student['name'];
        $_SESSION['email'] = $student['email'];
        $_SESSION['phone'] = $student['phone'];
        $_SESSION['gender'] = $student['gender'];
        $_SESSION['country'] = $student['country'];
        $_SESSION['dob'] = $student['dob'];
        $_SESSION['class'] = $student['class'];
        $_SESSION['profile_picture'] = $student['profile_picture'];
        $_SESSION['role_id'] = 'student';
        $_SESSION['logged_in'] = true;

        header("Location: ../view/studentDashvoardInitial.php");
        exit();

    } else {
        echo "Invalid student credentials";
        //$errors['general'] = "Invalid student credentials";
    }
    } else{
        echo "Invalid role selected";
       //$errors['general'] = "Invalid role selected";
    }
     
}

// VALIDATE AND PROCESS LOGIN
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (validateEmail() && validatePassword() && validateRole()) {
        loginUserController();
    } else {
        echo "Invalid input<br>";
    }
}
