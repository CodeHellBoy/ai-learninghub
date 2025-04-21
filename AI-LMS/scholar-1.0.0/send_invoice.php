<?php
session_start();
require('C:\wamp64\www\php\AI-LMS\scholar-1.0.0\tcpdf\tcpdf\tcpdf.php');
require('C:\wamp64\www\php\AI-LMS\scholar-1.0.0\PHPMailer\src\PHPMailer.php');
require('C:\wamp64\www\php\AI-LMS\scholar-1.0.0\PHPMailer\src\SMTP.php');
require('C:\wamp64\www\php\AI-LMS\scholar-1.0.0\PHPMailer\src\Exception.php');
include "connection.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access!");
}

$user_id = $_SESSION['user_id'];

// Fetch user and payment details
$sql = "SELECT p.payment_id, c.course_title, p.amount, p.created_at, s.username, s.email 
        FROM payments_tbl p
        INNER JOIN course_tbl c ON p.course_id = c.course_id
        INNER JOIN signup s ON p.u_id = s.id
        WHERE p.u_id = ? 
        ORDER BY p.created_at DESC LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$payment = $result->fetch_assoc();

if (!$payment) {
    die("No recent payment found.");
}

// User Details
$invoice_id = $payment['payment_id'];
$username = $payment['username'];
$user_email = $payment['email'];
$course_title = $payment['course_title'];
$amount = number_format($payment['amount'], 2);
$date = date("d M Y", strtotime($payment['created_at']));

// PDF Generate
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Hub - AI LMS</title>
    <link rel="icon" href="/php/AI-LMS/assets/img/lear1_icon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/php/AI-LMS/assets/img/lear1_icon.ico" type="image/x-icon">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:rgb(255, 255, 255);
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        .bill-container {
            background: white;
            padding: 30px;
            width: 70%;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            text-align: left;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            border-bottom: 3px solid #6f52ed;
        }
        .header img {
            width: 110px;
            height: 110px;
        }
        .header h2 {
            color: #6f52ed;
            margin: 0 auto;
            font-size: 22px;
        }
        .order-id {
            text-align: left;
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid black;
            padding: 12px;
            text-align: center;
            font-size: 16px;
        }
        th {
            background: #6f52ed;
            color: white;
            text-transform: uppercase;
            border-bottom: none;
        }
        .total-section {
            text-align: right;
            font-size: 22px;
            font-weight: bold;
            color: #6f52ed;
            margin-top: 20px;
            padding: 10px;
            border-top: 2px solid #6f52ed;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            color: #555;
            padding: 40px;
            border-top: 2px solid #6f52ed;
        }
        .logo {
            display: block;
            margin: auto;
            width: 500px;
            height: 500px;
        }
    </style>
</head>
<body>
    <div class="bill-container">
        <div class="header">
            <img src="img/LEAR1.png" alt="AI-LMS Logo" class="logo">
            <h2>Purchase Bill</h2>
        </div>
        <div class="order-id">Order ID: #' . $invoice_id . '</div>
        <p><strong>Username:</strong> ' . $username . '</p>
        <p><strong>Email:</strong> ' . $user_email . '</p>
        <p><strong>Date:</strong> ' . $date . '</p>
        <br>
        <table>
            <tr>
                <th>Course</th>
                 <th>Qty</th>
                <th>Price</th>
            </tr>
            <tr>
                <td>' . $course_title . '</td>
                <td>1</td>
                <td>' . $amount . '</td>
            </tr>
        </table>
        <div class="total-section">
            <p>Total Paid: ' . $amount . '</p>
        </div>
        <div class="footer">
            Thank you for choosing AI-LMS!<br>
            For any queries, contact us at <strong>support@ai-lms.com</strong>
        </div>
    </div>
</body>
</html>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf_file = __DIR__ . "/invoices/invoice_$invoice_id.pdf";
$pdf->Output($pdf_file, 'F');

// Send Email with Attachment
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'tanishqchothiyawala627@gmail.com';
    $mail->Password   = 'dkqx uchd uzgk qvcj';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('tanishqchothiyawala627@gmail.com', 'AI-LMS');
    $mail->addAddress($user_email, $username);

    $mail->isHTML(true);
    $mail->Subject = "Your AI-LMS Course Purchase Invoice";
    $mail->Body    = "<p>Dear <strong>$username</strong>,</p>
                      <p>Thank you for purchasing <strong>$course_title</strong>.</p>
                      <p>We have attached your invoice for reference.</p>
                      <p>For any queries, reach out to our support team.</p>
                      <p><strong>Best Regards,<br>AI-LMS Team</strong></p>";

    $mail->addAttachment($pdf_file);

    if ($mail->send()) {
        echo "<script>alert('Invoice has been sent to your email!');</script>";
        return header("Location: user_dashboard.php");
    } else {
        echo "<script>alert('Failed to send invoice.');</script>";
    }

} catch (Exception $e) {
    echo "<script>alert('Email sending failed: {$mail->ErrorInfo}');</script>";
}

unlink($pdf_file);
?>