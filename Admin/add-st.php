<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="style1.css">
</head>

<body>
    <div class="container">
        <h2>Student Registration Form</h2>
        <form id="registrationForm" action="register.php" method="POST">
            <input type="text" name="txtfullname" placeholder="Full Name" required>
            <input type="text" name="txtmatric_no" placeholder="Matric No" required>
            <input type="password" name="txtpassword" placeholder="Password" required>
            <input type="text" name="txtsession" placeholder="Session" required>
            <input type="text" name="txtfaculty" placeholder="Faculty" required>
            <input type="text" name="txtdept" placeholder="Department" required>
            <input type="tel" name="txtphone" placeholder="Phone" required>
            <input type="submit" value="Register">
        </form>
    </div>

    <script src="script.js"></script>
</body>

</html>