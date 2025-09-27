<?php include 'header.php'; ?>
<h2>Teacher Signup</h2>
<form id="teacherSignupForm" method="POST" action="../controller/teacher_controller.php?action=register" enctype="multipart/form-data">
    <label>Name:</label><input type="text" name="name" id="tname" /><span id="tnameErr"></span><br/>
    <label>Email:</label><input type="email" name="email" id="temail" /><span id="temailErr"></span><br/>
    <label>Phone:</label><input type="text" name="phone" id="tphone" /><span id="tphoneErr"></span><br/>
    <label>Gender:</label>
    <select name="gender" id="tgender">
        <option value="">Select</option>
        <option>Male</option><option>Female</option><option>Other</option>
    </select><span id="tgenderErr"></span><br/>
    <label>Date of Birth:</label><input type="date" name="dob" id="tdob" /><span id="tdobErr"></span><br/>
    <label>Educational Qualification:</label><input type="text" name="educational_qualification" id="tedu" /><span id="teduErr"></span><br/>
    <label>Subject in Expert:</label><input type="text" name="subject_expert" id="tsubject" /><span id="tsubjectErr"></span><br/>
    <label>Profile Picture:</label><input type="file" name="profile_picture" id="tprofile" accept="image/*" /><span id="tprofileErr"></span><br/>
    <label>Document:</label><input type="file" name="document" id="tdocument" /><span id="tdocumentErr"></span><br/>
    <label>Bio:</label><textarea name="bio" id="tbio"></textarea><span id="tbioErr"></span><br/>
    <label>Password:</label><input type="password" name="password" id="tpassword" /><span id="tpasswordErr"></span><br/>
    <label>Confirm Password:</label><input type="password" name="confirm_password" id="tconfirmpassword" /><span id="tconfirmpasswordErr"></span><br/>
    <input type="submit" value="Register" />
    <input type="reset" value="reset"/>
</form>
<?php include 'footer.php'; ?>
