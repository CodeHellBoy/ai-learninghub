<?php
include 'connection.php'; // Include database connection

header("Content-Type: application/json");

// Check database connection
if (!$conn) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit();
}

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON input"]);
    exit();
}

// Debugging - Log received data (optional)
file_put_contents("debug_log.txt", print_r($data, true), FILE_APPEND);

// Validate input
if (!isset($data['payment_id']) || !isset($data['u_id']) || !isset($data['course_id']) || !isset($data['amount'])) {
    echo json_encode(["status" => "error", "message" => "Missing payment details"]);
    exit();
}

$payment_id = mysqli_real_escape_string($conn, (string)$data['payment_id']); // Ensure payment_id is treated as a string
$u_id = (int)$data['u_id']; // Ensuring correct data type
$course_id = (int)$data['course_id'];
$amount = number_format((float)$data['amount'], 2, '.', ''); // Format amount correctly

// Insert payment details into database
$query = "INSERT INTO payments_tbl (u_id, course_id, amount, payment_id, status) VALUES (?, ?, ?, ?, 'success')";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "iids", $u_id, $course_id, $amount, $payment_id);
$result = mysqli_stmt_execute($stmt);

if ($result) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
}
?>
