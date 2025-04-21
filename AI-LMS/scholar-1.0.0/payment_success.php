    <?php
    session_start();
    include "connection.php"; 

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Fetch last payment details
    $sql = "SELECT p.payment_id, c.course_title, p.amount, p.created_at 
            FROM payments_tbl p
            INNER JOIN course_tbl c ON p.course_id = c.course_id
            WHERE p.u_id = ? 
            ORDER BY p.created_at DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $payment = $result->fetch_assoc();
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Learning Hub - AI LMS</title>
        <link rel="icon" href="/php/AI-LMS/assets/img/lear1_icon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/php/AI-LMS/assets/img/lear1_icon.ico" type="image/x-icon">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

            body {
                font-family: 'Poppins', sans-serif;
                background:  rgb(103, 90, 180);
                color: #333;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                overflow: hidden;
                position: relative;
            }

            /* Bubble Animation */
            .bubbles {
                position: absolute;
                width: 100%;
                height: 100%;
                overflow: hidden;
                z-index: -1;
            }

            .bubble {
                position: absolute;
                bottom: -100px;
                width: 40px;
                height: 40px;
                background: rgba(255, 255, 255, 0.2);
                border-radius: 50%;
                animation: rise 10s infinite ease-in-out;
            }

            @keyframes rise {
                0% { transform: translateY(0) scale(1); opacity: 0.4; }
                50% { opacity: 1; }
                100% { transform: translateY(-120vh) scale(1.2); opacity: 0; }
            }

            .bubble:nth-child(6) { left: 15%; animation-delay: 5s; width: 30px; height: 30px; }
.bubble:nth-child(7) { left: 40%; animation-delay: 3s; width: 45px; height: 45px; }
.bubble:nth-child(8) { left: 60%; animation-delay: 7s; width: 25px; height: 25px; }
.bubble:nth-child(9) { left: 80%; animation-delay: 6s; width: 35px; height: 35px; }
.bubble:nth-child(10) { left: 5%; animation-delay: 8s; width: 20px; height: 20px; }
.bubble:nth-child(11) { left: 25%; animation-delay: 10s; width: 50px; height: 50px; }
.bubble:nth-child(12) { left: 75%; animation-delay: 12s; width: 30px; height: 30px; }
.bubble:nth-child(13) { left: 90%; animation-delay: 14s; width: 40px; height: 40px; }
.bubble:nth-child(14) { left: 50%; animation-delay: 5s; width: 55px; height: 55px; }

            .payment-container {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                border-radius: 15px;
                padding: 30px;
                text-align: center;
                box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
                width: 90%;
                max-width: 450px;
                animation: slideIn 0.8s ease-in-out;
            }

            @keyframes slideIn {
                from { opacity: 0; transform: translateY(-20px); }
                to { opacity: 1; transform: translateY(0); }
            }

            h2 {
                color:  rgb(103, 90, 180);
                font-size: 28px;
                font-weight: bold;
                margin-bottom: 15px;
            }

            .icon-success {
                font-size: 60px;
                color: green;
                margin-bottom: 15px;
                animation: bounce 1s infinite;
            }

            @keyframes bounce {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-10px); }
            }

            .payment-info {
                font-size: 18px;
                color: #333;
                margin: 10px 0;
            }

            .highlight {
                color:  rgb(103, 90, 180);
                font-weight: bold;
            }

            .btn {
                display: inline-block;
                padding: 12px 20px;
                margin-top: 20px;
                text-decoration: none;
                font-weight: bold;
                border-radius: 8px;
                font-size: 16px;
                cursor: pointer;
                border: none;
                transition: all 0.3s ease-in-out;
            }

            .btn-primary {
                background:  rgb(103, 90, 180);
                color: white;
                box-shadow: 0px 4px 8px rgba(0, 123, 255, 0.3);
            }

            .btn-primary:hover {
                background:  rgb(103, 90, 180);
                transform: scale(1.05);
            }
            
        </style>
    </head>
    <body>
    <div class="bubbles">
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div> <!-- Extra bubbles -->
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
</div>
        <div class="payment-container">
            <i class="fas fa-check-circle icon-success"></i>
            <h2>Payment Successful!</h2>
            <?php if ($payment): ?>
                <p class="payment-info"><strong>Thank you for purchasing</strong> <span class="highlight"><?php echo htmlspecialchars($payment['course_title']); ?></span></p>
                <p class="payment-info"><strong>Amount Paid:</strong> <span class="highlight">₹<?php echo number_format($payment['amount'], 2); ?></span></p>
                <p class="payment-info"><strong>Transaction ID:</strong> <span class="highlight"><?php echo htmlspecialchars($payment['payment_id']); ?></span></p>
                <p class="payment-info"><strong>Date: </strong><span class="highlight"><?php echo htmlspecialchars($payment['created_at']); ?></span></p>
            <?php else: ?>
                <p class="payment-info">No recent payment found.</p>
            <?php endif; ?>
            <!-- <a href="user_dashboard.php" class="btn btn-primary">Go to Dashboard</a> -->
            <a href="send_invoice.php" class="btn btn-primary">Send Invoice to Email</a>

        </div>
    </body>
    </html>
                