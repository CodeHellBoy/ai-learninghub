<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

session_start();
include "connection.php";

$emailError = "";

// Handle POST request (Email validation before sending token)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    if (empty($email)) {
        $emailError = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Invalid email format.";
    } else {
        // Check if email exists
        $stmt = $conn->prepare("SELECT * FROM signup WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Store email in session and redirect to token verification
            $_SESSION['reset_email'] = $email;
            header("Location: forgot_password.php?email=" . urlencode($email));
            exit();
        } else {
            $emailError = "No account found with this email.";
        }
        
        $stmt->close();
    }
}

// Handle GET request (Generate reset token and send email)
if (isset($_GET['email'])) {
    $email = $_GET['email'];
    $reset_token = rand(100000, 999999); // Plaintext reset token

    // Update reset token in the database
    $update_query = "UPDATE signup SET reset_token = ? WHERE email = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ss", $reset_token, $email);
    $update_result = $stmt->execute();

    if ($update_result) {
        // Send Reset Token via Email
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'tanishqchothiyawala627@gmail.com';
            $mail->Password   = 'dkqx uchd uzgk qvcj';   // Use App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Recipients
            $mail->setFrom('noreply@learninghub.com', 'LEARNING HUB Support');
            $mail->addAddress($email);

            // Email Content
            $mail->isHTML(true);
            $mail->Subject = 'AI-LMS Password Reset Request';
            $mail->Body    = "<p>Dear User,</p>
                              <p>We received a request to reset your password for your AI-LMS account. Please use the following token to reset your password:</p>
                              <h2>$reset_token</h2>
                              <p>If you did not request a password reset, please ignore this email.</p>
                              <p>Thank you,<br>AI-LMS Support Team</p>";

            $mail->send();
            echo "<script>alert('Email sent successfully! Check your inbox for the reset token.');</script>";
            header("Location: token_verification.php?email=$email");
            exit();
            
        } catch (Exception $e) {
            echo "<script>alert('Failed to send email. Error: {$mail->ErrorInfo}');</script>";
        }
    } else {
        echo "<script>alert('Failed to update the reset token in the database.');</script>";
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

  <style>
    * {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        box-sizing: border-box;
    }

    body {
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
        color: #333;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        flex-direction: column;
       
        background-size: cover;
        background-position: center;
        z-index: -1;
    }

    .container {
        background-color: #fff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
        width: 400px;
        text-align: center;
    }

    h1 {
        margin: 0 0 20px;
        font-family: poppins;
        color: rgb(103, 90, 180);
    }

    input[type="email"] {
        width: 100%;
        padding: 15px;
        margin: 10px 0;
        border: 1px solid rgb(103, 90, 180);
        border-radius: 5px;
        font-size: 16px;
        background-color: #f9f9f9;
        color: #333;
        transition: all 0.3s ease-in-out;
    }

    input[type="email"]:focus {
        border-color: rgb(103, 90, 180);
        background-color: #fff;
        outline: none;
        box-shadow: 0 0 10px rgb(103, 90, 180, 0.5);
    }

    input[type="submit"] {
        background-color: rgb(103, 90, 180);
        color: #fff;
        font-weight: bold;
        cursor: pointer;
        padding: 15px;
        margin: 10px 0;
        border: none;
        width: 100%;
        border-radius: 5px;
        font-size: 16px;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    input[type="submit"]:hover {
        background-color: rgb(103, 90, 180);
    }

    .form-footer {
        margin-top: 10px;
        text-align: center;
    }

    .form-footer a {
        color: rgb(103, 90, 180);
        text-decoration: none;
        font-weight: bold;
    }

    .form-footer a:hover {
        text-decoration: underline;
    }

    @media screen and (max-width: 768px) {
        .container {
            width: 100%;
            padding: 15px;
        }
    }
  </style>
</head>
<body>
    <div class="container">
        <h1>Forgot Password</h1>
        <p>Enter your registered email to reset your password</p>
        <form action="" method="POST">
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                <input type="email" class="form-control" name="email" placeholder="Enter your registered email" required>
            </div>
            <span class="error" style="color: red;"><?php echo $emailError; ?></span><br>

            <input type="submit" class="btn btn-primary w-100 mt-2" value="Get Reset Token in Email">
        </form>

        <div class="form-footer text-center mt-4">
            <a href="index.php"><i class="fas fa-arrow-left"></i> Back to Login</a>
        </div>
    </div>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</body>
</html>
