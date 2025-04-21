<?php
require('fpdf/fpdf.php'); // Include FPDF Library
require 'connection.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    die("Unauthorized Access");
}

$user_id = $_SESSION['user_id'];
$course_id = $_GET['course_id'];

// Fetch User Details
$user_query = "SELECT username FROM signup WHERE id = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();
$username = strtoupper($user['username']); // Capitalized for emphasis

// Fetch Course Details
$course_query = "SELECT course_title, instructor_id FROM course_tbl WHERE course_id = ?";
$stmt = $conn->prepare($course_query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$course_result = $stmt->get_result();
$course = $course_result->fetch_assoc();
$course_title = strtoupper($course['course_title']); // Capitalized for emphasis

// Fetch Instructor Name
$instructor_query = "SELECT instructor_name FROM instructor_tbl WHERE instructor_id = ?";
$stmt = $conn->prepare($instructor_query);
$stmt->bind_param("i", $course['instructor_id']);
$stmt->execute();
$instructor_result = $stmt->get_result();
$instructor = $instructor_result->fetch_assoc();
$instructor_name = strtoupper($instructor['instructor_name']); // Capitalized for emphasis

// Create PDF
$pdf = new FPDF('L', 'mm', 'A4'); // Landscape mode
$pdf->AddPage();

// Add Background Image (Ensure the image file exists)
// $pdf->Image('img/certificate_bg.jpg', 0, 0, 297, 210);

// Add Elegant Border
$pdf->SetLineWidth(1);
$pdf->SetDrawColor(0, 80, 180); // Blue Border
$pdf->Rect(10, 10, 277, 190, 'D');

// Certificate Title
$pdf->Ln(10);
$pdf->SetFont('Times', 'B', 30);
$pdf->Cell(0, 20, 'CERTIFICATE OF ACHIEVEMENT', 0, 1, 'C');
$pdf->Ln(2);

// Subtitle
$pdf->SetFont('Times', 'I', 18);
$pdf->Cell(0, 10, 'This certifies that', 0, 1, 'C');
$pdf->Ln(5);

// Student Name in Bold
$pdf->SetFont('Times', 'B', 32);
$pdf->SetTextColor(0, 102, 204); // Blue color
$pdf->Cell(0, 15, $username, 0, 1, 'C');
$pdf->SetTextColor(0, 0, 0); // Reset color

$pdf->SetFont('Times', '', 20);
$pdf->Cell(0, 10, 'has successfully completed the course', 0, 1, 'C');
$pdf->Ln(5);

// Course Title
$pdf->SetFont('Times', 'B', 24);
$pdf->SetTextColor(50, 50, 50); // Dark Gray
$pdf->Cell(0, 12, '"' . $course_title . '"', 0, 1, 'C');
$pdf->SetTextColor(0, 0, 0); // Reset color
$pdf->Ln(5);

$pdf->SetFont('Times', '', 18);
$pdf->Cell(0, 10, 'under the guidance of', 0, 1, 'C');

// Gold Seal Image (Ensure the image file exists)
$pdf->Image('img/gold_seal.png', 15, 35, 55);


// Instructor Name
$pdf->SetFont('Times', 'B', 22);
$pdf->Cell(0, 12, $instructor_name, 0, 1, 'C');


// Date of Completion
$pdf->SetFont('Times', '', 16);
$pdf->Cell(0, 15, 'Awarded on: ' . date('F d, Y'), 0, 1, 'C');



// Signature Section (Ensure it stays on the same page)
$pdf->SetY(160); // Set position manually to prevent overflow

$pdf->SetFont('Times', '', 16);
$pdf->Cell(120, 10, '________________________', 0, 0, 'C');
$pdf->Cell(170, 10, '________________________', 0, 1, 'C');

$pdf->SetFont('Times', 'I', 14);
$pdf->Cell(120, 10, 'Instructor Signature', 0, 0, 'C');
$pdf->Cell(170, 10, 'Director Signature', 0, 0, 'C');

// Output PDF
$pdf->Output('D', 'Certificate_' . $username . '.pdf');
?>
