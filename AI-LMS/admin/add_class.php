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
require 'connection.php'; // Database connection

$admin_id = $_SESSION['admin_id'];

// Fetch admin information from the admin_tbl table
$admin_query = "SELECT username, email FROM admin_tbl WHERE admin_id = ?";
$stmt = mysqli_prepare($conn, $admin_query);
mysqli_stmt_bind_param($stmt, "i", $admin_id);
mysqli_stmt_execute($stmt);
$admin_result = mysqli_stmt_get_result($stmt);
$admin = mysqli_fetch_assoc($admin_result);

$classError = "";
$class = "";
$imagePath = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isValid = true;

    // Retrieve class field from form
    $class = isset($_POST['class']) ? trim($_POST['class']) : "";

    // Validate class field
    if (empty($class)) {
        $classError = "Class is required.";
        $isValid = false;
    } else {
        $class = mysqli_real_escape_string($conn, $class);
    }

    // Handle Image Upload
    if (!empty($_FILES["classImage"]["name"])) {
        $target_dir = "uploads/"; // Upload directory
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true); // Create directory if not exists
        }

        $file_name = basename($_FILES["classImage"]["name"]);
        $imageFileType = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $new_file_name = time() . "_" . uniqid() . "." . $imageFileType; // Unique file name
        $target_file = $target_dir . $new_file_name;

        // ✅ Check if file is an actual image
        $check = getimagesize($_FILES["classImage"]["tmp_name"]);
        if ($check === false) {
            echo "<script>'File is not an image.';</script>";
            $isValid = false;
        }

        // ✅ Check file size (Limit: 2MB)
        if ($_FILES["classImage"]["size"] > 2 * 1024 * 1024) {
            echo "<script>'File size exceeds 2MB limit.';</script>";
            $isValid = false;
        }

        // ✅ Allow only specific file formats
        $allowed_types = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowed_types)) {
            echo "<script>'Only JPG, JPEG, PNG & GIF files are allowed.';</script>";
            $isValid = false;
        }

        // ✅ Move file to the target directory if valid
        if ($isValid && move_uploaded_file($_FILES["classImage"]["tmp_name"], $target_file)) {
            $imagePath = $target_file;
        } else {
            echo "<script>'Error uploading image.';</script>";
            $isValid = false;
        }
    } else {
        echo "<script>'Please upload an image for the class.';</script>";
        $isValid = false;
    }

    // If everything is valid, insert into database
    if ($isValid) {
        // Check if class already exists
        $checkQuery = "SELECT * FROM class_tbl WHERE class = '$class'";
        $result = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('This class already exists!');</script>";
        } else {
            // Insert into database
            $insert = "INSERT INTO class_tbl (class, image) VALUES ('$class', '$imagePath')";

            if (mysqli_query($conn, $insert)) {
                echo "<script>alert('Class added successfully!');</script>";
                echo "<script>window.location.href='add_class.php';</script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Learning Hub - AI LMS</title>
    <link rel="icon" href="/php/AI-LMS/assets/img/lear1_icon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/php/AI-LMS/assets/img/lear1_icon.ico" type="image/x-icon">
    

    <!-- CSS Files -->
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
              <li class="nav-item ">
                <a href="admin_dashboard.php" aria-expanded="false">
                <i class="fas fa-tachometer-alt"></i>
                  <p>Dashboard</p>
                </a>
               
              </li>
             
              <li class="nav-item active">
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
              
              <li class="nav-item">
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
</div>
      <!-- End Sidebar -->

      <div class="main-panel">
        <?php include 'navbar.php';?>

        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Add Class</h3>
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
                  <a href="#">Class</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Add Class </a>
                </li>
              </ul>
            </div>
            <form action="#" method="POST" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                      <div class="card-title">Add Class Details</div>
                    </div>
                    <div class="card-body">
                          <div class="row">
                              <div class="col-md-6 col-lg-4">
                                  
                                    <div class="form-group">
                                      <label for="class1">Class</label>
                                      <input
                                      type="text"
                                      class="form-control"
                                      id="class1"
                                      name="class"
                                      placeholder="Enter Class"
                                      value="<?php echo htmlspecialchars($class); ?>"
                                      />
                                      <span style="color: red;"><?php echo $classError; ?></span>
                                    </div>

                                    <div class="form-group">
                                      <label for="classImage">Class Image</label>
                                      <input
                                      type="file"
                                      class="form-control"
                                      id="classImage"
                                      name="classImage"
                                      />
                                      <span style="color: red;">
                                      <?php 
                                        if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($_FILES["classImage"]["name"])) {
                                          echo "Class image is required.";
                                        }
                                      ?>
                                      </span>
                                    </div>
                              </div>    
                          </div>
                    </div>
                    <div class="card-action">
                      <button class="btn btn-success me-3" name="btn">Submit</button>
                      <button type="reset" class="btn btn-danger me-3" onclick="window.location.href = 'add_class.php';">Cancel</button>
                      <button type="button" class="btn btn-primary me-3" onclick="window.location.href = 'add_sub.php';">Next</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
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

    <!--   Core JS Files   -->
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
