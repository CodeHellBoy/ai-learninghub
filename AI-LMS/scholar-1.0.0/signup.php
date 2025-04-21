<?php
session_start();
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $mob_no = trim($_POST['mob_no']);
    $email = trim($_POST['email']);
    $class = trim($_POST['class']);
    $password = trim($_POST['password']); // Store as plain text (not recommended)

    // Check if username already exists
    $checkStmt = $conn->prepare("SELECT username FROM signup WHERE username = ?");
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo "<script>alert('Username already exists. Please choose a different username.'); window.history.back();</script>";
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO signup (username, mob_no, email, class, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $mob_no, $email, $class, $password);

        if ($stmt->execute()) {
            echo "<script>alert('Registration Successful!'); 
            window.location='index.php?email=" . urlencode($email) . "';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    }
    
    $checkStmt->close();
    $conn->close();
}
?>

<?php 
$classQuery = "SELECT class FROM class_tbl";
$classResult = mysqli_query($conn, $classQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Learning Hub - AI LMS</title>
    <link rel="icon" href="/php/AI-LMS/assets/img/lear1_icon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/php/AI-LMS/assets/img/lear1_icon.ico" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,800" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background:rgb(245, 241, 241);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .signup-container {
            max-width: 500px;
            background: white;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2); /* Added Box Shadow */
        }

        .signup-container h1 {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .form-control {
            background-color: #f7f7f7;
            border: none;
            padding: 12px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid rgb(103, 90, 180);
        }

        .form-control:focus {
            background-color: #fff;
            box-shadow: 0px 0px 5px rgb(103, 90, 180);
        }

        .btn-signup {
            background-color: rgb(103, 90, 180);
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            padding: 15px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            width: 60%;
        }

        .btn-signup:hover {
            background: rgb(85, 70, 160);
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        h1 {
            color: rgb(103, 90, 180);
            font-family: poppins;
        }
    </style>
</head>
<body>

    <div class="signup-container">
        <h1>Create Account</h1>
        <p>Join our AI-based Learning Management System</p>

        <form id="registerForm" method="POST">
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
            <span class="error" id="usernameError"></span>

            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                <input type="number" class="form-control" name="mob_no" placeholder="Mobile Number" required pattern="\d{10}">
            </div>
            <span class="error" id="mobNoError"></span>

            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                <input type="email" class="form-control" name="email" placeholder="Email Address" required>
            </div>
            <span class="error" id="emailError"></span>

            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                <select class="form-control" name="class" required>
                    <option value="" disabled selected>Select Class</option>
                    <?php
                    if ($classResult) {
                        while ($row = mysqli_fetch_assoc($classResult)) {
                            echo "<option value='{$row['class']}'>{$row['class']}</option>";
                        }
                    } else {
                        echo "<option value=''>No classes available</option>";
                    }
                    ?>
                </select>
            </div>
            <span class="error" id="classError"></span>

            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <span class="error" id="passwordError"></span>

            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" class="form-control" name="confirm_pass" placeholder="Confirm Password" required>
            </div>
            <span class="error" id="confirmPassError"></span>

            <button type="submit" class="btn btn-signup w-100">Sign Up</button>
        </form>
    </div>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("registerForm").addEventListener("submit", function(event) {
                let isValid = true;
                const form = event.target;
                
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                const mobileRegex = /^[6-9]\d{9}$/;
                const usernameRegex = /^[a-zA-Z0-9]{3,}$/;
                const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/;

                if (!form.username.value.match(usernameRegex)) {
                    alert("Invalid username format.");
                    isValid = false;
                }
                if (!form.mob_no.value.match(mobileRegex)) {
                    alert("Invalid mobile number format.");
                    isValid = false;
                }
                if (!form.email.value.match(emailRegex)) {
                    alert("Invalid email format.");
                    isValid = false;
                }
                
                if (form.password.value !== form.confirm_pass.value) {
                    alert("Passwords do not match.");
                    isValid = false;
                }

                if (!isValid) {
                    event.preventDefault();
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
