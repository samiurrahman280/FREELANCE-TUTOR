<?php include 'header.php'; ?>
<h2>Login</h2>
<form id="loginForm" method="POST" action="../controller/login_controller.php">
    <label>Email:</label><input type="email" name="email" id="semail" /><span id="semailErr"></span><br/>
    <label>Password:</label><input type="password" name="password" id="spassword" /><span id="spasswordErr"></span><br/>
    
    <label>Login as:</label><br/>
    <input type="radio" id="teacher" name="role" value="teacher" checked>
    <label for="teacher">Teacher</label><br/>
    <input type="radio" id="student" name="role" value="student">
    <label for="student">Student</label><br/>
    
    <input type="submit" value="Login" />
    <input type="reset" value="reset"/>
</form>
<?php include 'footer.php'; ?>
