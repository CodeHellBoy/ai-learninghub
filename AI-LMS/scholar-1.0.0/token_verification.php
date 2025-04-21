<?php
session_start();
include "connection.php";

$passwordError = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $token = $_POST['reset_token'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Password validation
    if (strlen($new_password) < 6) {
        $passwordError = "Password must be at least 6 characters long.";
    } elseif ($new_password !== $confirm_password) {
        $passwordError = "Passwords do not match.";
    } else {
        // Verify the reset token
        $query = "SELECT * FROM signup WHERE email = ? AND reset_token = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $email, $token);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $update_query = "UPDATE signup SET password = ?, reset_token = NULL WHERE email = ?";
            $stmt = mysqli_prepare($conn, $update_query);
            mysqli_stmt_bind_param($stmt, "ss", $new_password, $email);
            if (mysqli_stmt_execute($stmt)) {
            $successMessage = "Password reset successfully.";
            echo "<script>alert('Password reset successfully.'); window.location.href='index.php';</script>";
            } else {
            $passwordError = "Failed to reset the password.";
            }
        } else {
            $passwordError = "Invalid token or email.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Hub - AI LMS</title>
    <link rel="icon" href="/php/AI-LMS/assets/img/lear1_icon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/php/AI-LMS/assets/img/lear1_icon.ico" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,800" rel="stylesheet">
    <style>
        * {
            
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: rgb(245, 241, 241);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .reset-container {
            max-width: 400px;
            background: white;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        }
        .reset-container h1 {
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
        input-group-text {
            border: 1px solid rgb(103, 90, 180);
        }
        .form-control:focus {
            background-color: #fff;
            box-shadow: 0px 0px 5px rgb(103, 90, 180);
        }
        .btn-reset {
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
        }
        .btn-reset:hover {
            background: rgb(85, 70, 160);
        }
        .error {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
        .success {
            color: green;
            font-size: 14px;
            margin-top: 10px;
        }
        .back-to-login {
            text-decoration: none;
            color: rgb(103, 90, 180);
            font-size: 14px;
            margin-top: 15px;
            display: inline-block;
        }

        h1 {
            color: rgb(103, 90, 180);
            font-family: poppins;
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <h1>Reset Password</h1>
        <p>Enter your reset token and new password to reset it.</p>
        <form method="POST">
            <input type="hidden" name="email" value="<?= isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">

            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
                <input type="text" class="form-control" name="reset_token" placeholder="Reset Token" required>
            </div>

            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" class="form-control" name="new_password" placeholder="New Password" required>
            </div>

            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required>
            </div>

            <span class="error text-danger"><?php echo $passwordError; ?></span>
            <span class="success text-success"><?php echo $successMessage; ?></span>

            <button type="submit" class="btn btn-reset w-100">Reset Password</button>
        </form>

        <div class="text-center mt-3">
            <a class="back-to-login" href="index.php"><i class="fas fa-arrow-left"></i> Back to Sign In</a>
        </div>
    </div>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</body>
</html>