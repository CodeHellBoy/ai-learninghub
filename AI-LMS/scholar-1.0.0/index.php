<?php 
// Include the database connection
include "connection.php";

session_start(); // Start the session

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    // Securely checking credentials
    $sql = "SELECT id, email, password FROM signup WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            header("Location: user_dashboard.php");
            exit();
 
    } else {
        $error_message = "Invalid email or password!";
    }
}

$conn->close();
?>

<!-- Retrieve email from URL if it exists, otherwise set it to an empty string -->
<?php
$email = isset($_GET['email']) ? $_GET['email'] : '';
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

    .login-container {
        max-width: 400px;
        background: white;
        border-radius: 10px;
        padding: 30px;
        text-align: center;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Added box shadow */
    }


    .login-container h1 {
        font-weight: bold;
        margin-bottom: 20px;
    }

    .form-control {
        background-color: #f7f7f7;
        border: 1px solid rgb(103, 90, 180);
        padding: 12px;
        font-size: 16px;
        border-radius: 5px;
    }

    .form-control:focus {
        background-color: #fff;
        box-shadow: 0px 0px 5px rgb(103, 90, 180);
    }

    .btn-login {
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
        width: 100%;
    }

    .btn-login:hover {
        background: rgb(85, 70, 160);
    }

    .error {
        color: red;
        font-size: 14px;
        margin-top: 10px;
    }

    .forgot-password {
        text-decoration: none;
        color: rgb(103, 90, 180);
        font-size: 14px;
        display: inline-block;
        text-align: right;
        width: 100%;
        margin-bottom: 10px;
    }

    .forgot-password:hover {
        text-decoration: none;
    }

    h1 {
        color: rgb(103, 90, 180);
        font-family: poppins;
        box-sizing: border-box;
    }

    a {
        text-decoration: none;
    }

    /* Updated font size for paragraph */
    p {
        font-size: 14px;
    }
</style>

</head>
<body>

    <div class="login-container">
        <h1>Sign In</h1>
        <p>Access your personalized learning dashboard</p>

        <form method="post">
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                <input type="text" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="Email" required>
            </div>
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>

            <!-- Forgot Password Aligned to Right -->
            <div class="mb-2 text-end">
                <a class="forgot-password" href="forgot_password.php">Forgot your password?</a>
            </div>

            <?php if (isset($error_message)): ?>
                <p class="error"><?= $error_message; ?></p>
            <?php endif; ?>

            <button type="submit" name="submit" class="btn btn-login">LOG IN</button>

            <p class="mt-3">Don't have an account? <a href="signup.php">Register</a></p>
        </form>
    </div>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
