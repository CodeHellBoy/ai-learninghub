<?php
session_start();
require 'connection.php'; // Ensure database connection

// Check if user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

// Fetch user information
$admin_query = "SELECT username, email FROM admin_tbl WHERE admin_id = ?";
$stmt = mysqli_prepare($conn, $admin_query);
mysqli_stmt_bind_param($stmt, "i", $admin_id);
mysqli_stmt_execute($stmt);
$admin_result = mysqli_stmt_get_result($stmt);
$admin = mysqli_fetch_assoc($admin_result);

// Default profile image (replace this if user profile images are stored in the database)
$profile_img = "assets/img/user.avif"; 
?>

<?php
require 'connection.php'; // Ensure you have a database connection file

$admin_id = $_SESSION['admin_id'];

// Fetch admin information from the admin_tbl table
$admin_query = "SELECT username, email FROM admin_tbl WHERE admin_id = ?";
$stmt = mysqli_prepare($conn, $admin_query);
mysqli_stmt_bind_param($stmt, "i", $admin_id);
mysqli_stmt_execute($stmt);
$admin_result = mysqli_stmt_get_result($stmt);
$admin = mysqli_fetch_assoc($admin_result);
?>

<?php
include('connection.php');

// Handle AJAX requests for fetching and updating courses
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'fetch') {
    $course_id = $_POST['course_id'];
    $query = "SELECT * FROM course_tbl WHERE course_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode(["status" => "success", "data" => $data]);
    } else {
        echo json_encode(["status" => "error"]);
    }
    exit();
  }


  if ($_POST['action'] == 'update') {
    $course_id = $_POST['course_id'];
    $class = $_POST['class'];
    $instructor_id = $_POST['instructor_id'];
    $class_id = $_POST['class_id'];
    $subject = $_POST['subject'];
    $course_title = $_POST['course_title'];
    $course_desc = $_POST['course_desc'];
    
    // Check if a file was uploaded
    if (!empty($_FILES['pdfFile']['name'])) {
        $pdfFileName = basename($_FILES['pdfFile']['name']);
        $pdfFilePath = "uploads/" . $pdfFileName; // Ensure the "uploads" directory exists
        $pdfFileSize = $_FILES['pdfFile']['size']; // Get file size in bytes

    // Check if file size exceeds 5 MB (5 * 1024 * 1024 bytes)
    if ($pdfFileSize > 5 * 1024 * 1024) {
        echo "error: File size exceeds 5 MB.";
        exit();
    }
        // Check if file type is PDF  
        $fileType = strtolower(pathinfo($pdfFileName, PATHINFO_EXTENSION));
        if ($fileType != "pdf") {
            echo "error: Only PDF files are allowed.";
            exit();
        }

        // Move uploaded file to server
        if (move_uploaded_file($_FILES['pdfFile']['tmp_name'], $pdfFilePath)) {
            // Update query with new PDF file
            $query = "UPDATE course_tbl SET class = ?, instructor_id = ?, class_id = ?, subject = ?, course_title = ?, course_desc = ?, pdf1 = ? WHERE course_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("siissssi", $class, $instructor_id, $class_id, $subject, $course_title, $course_desc, $pdfFileName, $course_id);
        } else {
            echo "error: Failed to upload file.";
            exit();
        }
    } else {
        // Update query without changing the PDF file
        $query = "UPDATE course_tbl SET class = ?, instructor_id = ?, class_id = ?, subject = ?, course_title = ?, course_desc = ? WHERE course_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("siisssi", $class, $instructor_id, $class_id, $subject, $course_title, $course_desc, $course_id);
    }

    echo $stmt->execute() ? "success" : "error";
    exit();
  }

}
?>

<?php 
// Fetch class data from the database
$classQuery = "SELECT class FROM class_tbl";
$classResult = mysqli_query($conn, $classQuery);

// Fetch instructor data from the database
$instructorQuery = "SELECT instructor_id FROM instructor_tbl";
$instructorResult = mysqli_query($conn, $instructorQuery);
?>

<?php 
// Fetch class_id data from the database
$classIdQuery = "SELECT class_id FROM class_tbl";
$classIdResult = mysqli_query($conn, $classIdQuery);
?>

<?php 
// Fetch subject data from the database
$subQuery = "SELECT subject FROM subject_tbl";
$subResult = mysqli_query($conn, $subQuery);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Learning Hub - AI LMS</title>
    <link rel="icon" href="/php/AI-LMS/assets/img/lear1_icon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/php/AI-LMS/assets/img/lear1_icon.ico" type="image/x-icon">
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
  <?php include 'all-css.php';?>

  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="admin_dashboard.php" class="logo">
                <img
                src="assets/img/LEAR.png"
                alt="navbar brand"
                class="navbar-brand"
                height="140"
                width="160"
                style="margin-left: 14px; margin-top: 10px;"
                />
              </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="admin_dashboard.php" class="logo">
                <img
                src="assets/img/LEAR.png"
                alt="navbar brand"
                class="navbar-brand"
                height="140"
                width="160"
                style="margin-left: 14px; margin-top: 10px;"
                />
              </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary" id="accordionSidebar">
              <li class="nav-item">
                <a href="admin_dashboard.php" aria-expanded="false">
                <i class="fas fa-tachometer-alt"></i>
                  <p>Dashboard</p>
                </a>
               
              </li>
             
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#forms">
                <i class="fas fa-chalkboard-teacher"></i> 
                  <p>Class</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="forms" data-bs-parent="#accordionSidebar">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="add_class.php">
                        <span class="sub-item">Add Class</span>
                      </a>
                    </li>
                    <li>
                      <a href="view_class.php">
                        <span class="sub-item">View Class</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              
              
              <li class="nav-item">
              <a data-bs-toggle="collapse" href="#course">
              <i class="fas fa-book"></i>
                  <p>Subject</p>
                  <span class="caret"></span>
                  <span class="badge badge-success"></span>
                </a>
                <div class="collapse" id="course" data-bs-parent="#accordionSidebar">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="add_sub.php">
                        <span class="sub-item">Add Subject</span>
                      </a>
                    </li>
                    <li>
                      <a href="view_sub.php">
                        <span class="sub-item">View Subject</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item active">
                <a data-bs-toggle="collapse" href="#tables">
                <i class="fas fa-book-open"></i>
                  <p>Course</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="tables" data-bs-parent="#accordionSidebar">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="add_course.php">
                        <span class="sub-item">Add Course</span>
                      </a>
                    </li>
                    <li>
                      <a href="view_course.php">
                        <span class="sub-item">View Course</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
              <a data-bs-toggle="collapse" href="#reg-users">
              <i class="fas fa-users"></i>
                  <p>Reg Users</p>
                  <span class="caret"></span>
                  <span class="badge badge-success"></span>
                </a>
                <div class="collapse" id="reg-users" data-bs-parent="#accordionSidebar">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="view_user.php">
                        <span class="sub-item">View Users</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#lesson">
                <i class="fas fa-graduation-cap"></i>
                  <p>Lesson</p>
                  <span class="caret"></span>
                  <span class="badge badge-success"></span>
                </a>
                <div class="collapse" id="lesson" data-bs-parent="#accordionSidebar">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="add_lesson.php">
                        <span class="sub-item">Add Lesson</span>
                      </a>
                    </li>
                    <li>
                      <a href="view_lesson.php">
                        <span class="sub-item">View Lesson</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#instructor">
                <i class="fas fa-chalkboard"></i> 
                  <p>Instructor</p>
                  <span class="caret"></span>
                  <span class="badge badge-success"></span>
                </a>
                <div class="collapse" id="instructor" data-bs-parent="#accordionSidebar">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="add_instruct.php">
                        <span class="sub-item">Add Instructors</span>
                      </a>
                    </li>
                    <li>
                      <a href="view_instruct.php">
                        <span class="sub-item">View Instructors</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <!-- <li class="nav-item">
                <a data-bs-toggle="collapse" href="#quiz">
                <i class="fas fa-question-circle"></i>
                  <p>Quiz</p>
                  <span class="caret"></span>
                  <span class="badge badge-success"></span>
                </a>
                <div class="collapse" id="quiz" data-bs-parent="#accordionSidebar">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="add_quiz.php">
                        <span class="sub-item">Add Quiz</span>
                      </a>
                    </li>
                    <li>
                      <a href="view_quiz.php">
                        <span class="sub-item">View Quiz</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li> -->
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#pay">
                <i class="fas fa-credit-card"></i>
                  <p>Payment</p>
                  <span class="caret"></span>
                  
                </a>
                <div class="collapse" id="pay" data-bs-parent="#accordionSidebar">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="view_payment_detail.php">
                        <span class="sub-item">View Payment Details</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#user-feedback">
                <i class="fas fa-comments"></i>
                  <p>User-feedback</p>
                  <span class="caret"></span>
                  <span class="badge badge-success"></span>
                </a>
                <div class="collapse" id="user-feedback" data-bs-parent="#accordionSidebar">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="view_feedback.php">
                        <span class="sub-item">View User-feedback</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              
            </ul>
          </div>
        </div>
  </div>
</div>

      <!-- End Sidebar -->

      <div class="main-panel">
        <?php include 'navbar.php';?>

        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">View Course</h3>
              <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                  <a href="admin_dashboard.php">
                    <i class="icon-home"></i>
                  </a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Course</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">View Course</a>
                </li>
              </ul>
            </div>
            <div class="row">
              
            <?php
              include('connection.php'); // Ensure database connection

              // Handle delete request
              if (isset($_GET['delete_id'])) {
                  $course_id = $_GET['delete_id'];

                  // Delete query
                  $query = "DELETE FROM `course_tbl` WHERE `course_id`='$course_id'";
                  $result = mysqli_query($conn, $query);

                  if ($result) {
                      echo "<script>alert('Course Details deleted successfully!'); window.location.href='view_course.php';</script>";
                  } else {
                      echo "<script>alert('Error deleting course details: " . mysqli_error($conn) . "');</script>";
                  }
              }
            ?>


            <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                        <div class="d-flex align-items-center">
                          <h4 class="card-title">View Course Details</h4>
                          <a href="add_course.php" class="btn btn-primary btn-round ms-auto">
                              <i class="fa fa-plus"></i> Add Course
                          </a>
                        </div>
                  </div>
                  <div class="card-body">
                    <!-- Modal -->
                    <table class="table table-hover table-striped table-bordered text-center" id="basic-datatables">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>CLASS</th>
                          <th>SUBJECT</th>
                          <th>COURSE TITLE</th>
                          <th>COURSE DESCRIPTION</th>
                          <th>FILE 1</th>
                          
                          <th>ACTION</th>                           
                        </tr>
                      </thead>
                          <tbody>
                            <?php
                            
                            include('connection.php');
                            
                            $query = "select * from `course_tbl`";
                            $result = mysqli_query($conn, $query);
                            
                            if(!$result) {
                                die("Query Failed : ".mysqli_error($conn));
                              }
                              else {
                                while($row = mysqli_fetch_assoc($result)) {
                                  echo "<tr>
                                  
                                  <td>{$row['course_id']}</td>
                                  <td>{$row['class']}</td>
                                  <td>{$row['subject']}</td>
                                  <td>{$row['course_title']}</td>
                                  <td>{$row['course_desc']}</td>
                                  <td>{$row['pdf1']}</td>
                                  
                                    
                                  <td>
                                    <button type='button' class='btn btn-link btn-primary btn-md'
                                    data-bs-toggle='modal' data-bs-target='#editCourseModal' 
                                    title='Edit' onclick='editCourse({$row['course_id']})'>
                                    <i class='fa fa-edit'></i>
                                    </button>
                                    <button type='button' class='btn btn-link btn-warning btn-md' data-bs-toggle='modal' title='Delete'>
                                    <a href='view_course.php?delete_id={$row['course_id']}' class='btn btn-link btn-danger btn-md' 
                                        onclick='return confirm(\"Are you sure you want to delete this Course Details?\");'>
                                        <i class='fas fa-trash-alt'></i>
                                    </a>
                                    </button>                                  
                                  </td>
                                    
                                  
                                    </tr>";
                                }
                              }
                              
                            ?>
                        </tbody>
                    </table>
                        <div class="modal fade" id="editCourseLabel" tabindex="-1" aria-labelledby="editCourseLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h1 class="modal-title fs-5" id="editCourseLabel">Edit Course Details</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <form id="editCourseForm" enctype="multipart/form-data">
                                  <input type="hidden" id="course_id" name="course_id">
                                  <div class="mb-3">
                                    <label for="class1">Class</label>
                                    <select class="form-control" id="class1" name="class">
                                      <option value="" disabled selected>Select Class</option>
                                      <?php
                                        while ($row = mysqli_fetch_assoc($classResult)) {
                                          echo "<option value='{$row['class']}'>{$row['class']}</option>";
                                      }
                                      ?>
                                    </select>
                                  </div>
                                  <div class="mb-3">
                                    <label for="instructor_id1">Instructor ID</label>
                                    <select class="form-control" id="instructor_id1" name="instructor_id" value="<?php echo isset($instructor_id) ? htmlspecialchars($instructor_id) : ''; ?>">
                                      <option value="" disabled selected>Select Instructor Id</option>
                                      <?php
                                      if ($instructorResult) {
                                        while ($row = mysqli_fetch_assoc($instructorResult)) {
                                        echo "<option value='{$row['instructor_id']}'>{$row['instructor_id']}</option>";
                                        }
                                      } else {
                                        echo "<option value=''>No Instructor Id available</option>";
                                      }
                                      ?>
                                    </select>
                                  </div>
                                  <div class="mb-3">
                                    <label for="class_id1">Class ID</label>
                                    <select class="form-control" id="class_id1" name="class_id" value="<?php echo isset($class_id) ? htmlspecialchars($class_id) : ''; ?>">
                                      <option value="" disabled selected>Select Class ID</option>
                                      <?php
                                      if ($classIdResult) {
                                      while ($row = mysqli_fetch_assoc($classIdResult)) {
                                      echo "<option value='{$row['class_id']}'>{$row['class_id']}</option>";
                                      }
                                      } else {
                                      echo "<option value=''>No Class ID available</option>";
                                      }
                                      ?>
                                    </select>
                                  </div>
                                  <div class="mb-3">
                                    <label for="sub1">Subject</label>
                                    <select class="form-control" id="sub1" name="subject" value="<?php echo isset($subject) ? htmlspecialchars($subject) : ''; ?>">
                                      <option value="" disabled selected>Select Subject</option>
                                      <?php
                                        if ($subResult) {
                                          while ($row = mysqli_fetch_assoc($subResult)) {
                                            echo "<option value='{$row['subject']}'>{$row['subject']}</option>";
                                          }
                                        } else {
                                          echo "<option value=''>No subjects available</option>";
                                        }
                                      ?>
                                    </select>
                                  </div>
                                  <div class="mb-3">
                                    <label for="course_title1" class="form-label">Course Title</label>
                                    <input type="text" class="form-control" id="course_title1" name="course_title" placeholder="Enter Course Title">
                                  </div>
                                  <div class="mb-3">
                                    <label for="course_desc1" class="form-label">Course Description</label>
                                    <textarea class="form-control" id="course_desc1" name="course_desc" placeholder="Enter Course Description"></textarea>
                                  </div>
                                  <div class="mb-3">
                                    <label for="pdfFile">Upload New PDF File:</label>
                                    <input type="file" class="form-control-file" id="pdfFile" name="pdfFile" accept="application/pdf">
                                  </div>

                                  <!-- Display Existing PDF -->
                                  <div class="mb-3" id="existingPdfContainer">
                                    <label>Current PDF File:</label>
                                    <a id="existingPdfLink" href="#" target="_blank">View Current PDF</a>
                                  </div>

                                </form>
                              
                              <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="saveCourse()">Edit Details</button>
                              </div>
                            </div>
                          </div>
                        </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <footer class="footer bg-light text-center py-3">
          <div class="container">
            <div class="row">
              <!-- Branding and Links -->
              <div class="col-md-6 text-md-start">
                <p class="mb-0">
                  <strong>Learning Hub</strong> © 2025 | Empowered by AI for smarter learning.
                </p>
              </div>

              <!-- Useful Links -->
              <div class="col-md-6 text-md-end">
                <a href="#" class="text-decoration-none me-3">Help</a>
                <a href="#" class="text-decoration-none me-3">Privacy Policy</a>
                <a href="#" class="text-decoration-none">Contact Us</a>
              </div>
            </div>
          </div>
        </footer>
      </div>

      <!-- Custom template | don't include it in your project! -->
      <?php include 'settings.php';?>
      <!-- End Custom template -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Function to fetch course details and open edit modal
            function editCourse(courseId) {
              $.ajax({
                  url: 'view_course.php',
                  type: 'POST',
                  data: { action: 'fetch', course_id: courseId },
                  dataType: 'json',
                  success: function (response) {
                      if (response.status === "success") {
                          $("#course_id").val(response.data.course_id);
                          $("#class1").val(response.data.class);
                          $("#instructor_id1").val(response.data.instructor_id);
                          $("#class_id1").val(response.data.class_id);
                          $("#sub1").val(response.data.subject);
                          $("#course_title1").val(response.data.course_title);
                          $("#course_desc1").val(response.data.course_desc);

                          // Show existing PDF if available
                          if (response.data.pdf1) {
                              $("#existingPdfContainer").show();
                              $("#existingPdfLink").attr("href", "uploads/" + response.data.pdf1).text(response.data.pdf1);
                          } else {
                              $("#existingPdfContainer").hide();
                          }

                          $("#editCourseLabel").modal('show');
                      } else {
                          alert("Course details not found.");
                      }
                  },
                  error: function () {
                      alert("Error fetching course details.");
                  }
              });
            }


            // Function to save edited course details
            function saveCourse() {
              let formData = new FormData($("#editCourseForm")[0]); // Get form data, including file

              formData.append("action", "update");
              formData.append("course_id", $("#course_id").val());

              $.ajax({
                  url: 'view_course.php',
                  type: 'POST',
                  data: formData,
                  contentType: false, // Required for file upload
                  processData: false, // Required for file upload
                  success: function (response) {
                      if (response.trim() === "success") {
                          alert("Course updated successfully!");
                          location.reload();
                      } else {
                          alert("Error updating course.");
                      }
                  },
                  error: function () {
                      alert("An error occurred while updating the course.");
                  }
              });
            }


            // Expose functions to the global scope
            window.editCourse = editCourse;
            window.saveCourse = saveCourse;
        });
    </script>


    <!--   Core JS Files   -->
    <script src="../assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <!-- Datatables -->
    <script src="../assets/js/plugin/datatables/datatables.min.js"></script>
    <!-- Kaiadmin JS -->
    <script src="../assets/js/kaiadmin.min.js"></script>
    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="../assets/js/setting-demo2.js"></script>
    <script>
      function populateEditModal(course) {
        document.getElementById("course_id").value = course.id;
        document.getElementById("class1").value = course.class;
        document.getElementById("instructor_id1").value = course.instructor_id;
        document.getElementById("class_id1").value = course.class_id;
        document.getElementById("sub1").value = course.subject;
        document.getElementById("course_title1").value = course.course_title;
        document.getElementById("course_desc1").value = course.course_desc;

        for (let i = 1; i <= 3; i++) {
          let pdfUrl = course['pdf' + i]; 
          let pdfLink = document.getElementById("existingPdf" + i);
          
          if (pdfUrl) {
            pdfLink.href = pdfUrl;
            pdfLink.style.display = "inline";
          } else {
            pdfLink.style.display = "none";
          }
        }
      }
    </script>
    <script>
      $(document).ready(function () {
        $("#basic-datatables").DataTable({});

        $("#multi-filter-select").DataTable({
          pageLength: 5,
          initComplete: function () {
            this.api()
              .columns()
              .every(function () {
                var column = this;
                var select = $(
                  '<select class="form-select"><option value=""></option></select>'
                )
                  .appendTo($(column.footer()).empty())
                  .on("change", function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column
                      .search(val ? "^" + val + "$" : "", true, false)
                      .draw();
                  });

                column
                  .data()
                  .unique()
                  .sort()
                  .each(function (d, j) {
                    select.append(
                      '<option value="' + d + '">' + d + "</option>"
                    );
                  });
              });
          },
        });

        // Add Row
        $("#add-row").DataTable({
          pageLength: 5,
        });

        var action =
          '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

        $("#addRowButton").click(function () {
          $("#add-row")
            .dataTable()
            .fnAddData([
              $("#addName").val(),
              $("#addPosition").val(),
              $("#addOffice").val(),
              action,
            ]);
          $("#addRowModal").modal("hide");
        });
      });
    </script>
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

   
    <!-- Datatables -->
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <!-- <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script> -->

    <!-- jQuery Vector Maps -->
    <script src="assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="assets/js/plugin/jsvectormap/world.js"></script>

    
    <!-- Kaiadmin JS -->
    <script src="assets/js/kaiadmin.min.js"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="assets/js/setting-demo.js"></script>
    <script src="assets/js/demo.js"></script>
    
  </body>
</html>
