<?php
session_start();
require 'connection.php'; // Ensure database connection

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

// Fetch admin information from `admin_tbl`
$admin_query = "SELECT username, email, mob_no FROM admin_tbl WHERE admin_id = ?";
$stmt = mysqli_prepare($conn, $admin_query);
mysqli_stmt_bind_param($stmt, "i", $admin_id);
mysqli_stmt_execute($stmt);
$admin_result = mysqli_stmt_get_result($stmt);
$admin = mysqli_fetch_assoc($admin_result);

// Default profile image (Replace this if profile images are stored in the database)
$profile_img = "assets/img/user.avif"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $new_email = $_POST['new_email'];
  $new_password = $_POST['new_password'];

  if (!empty($new_email)) {
    $update_email_query = "UPDATE admin_tbl SET email = ? WHERE admin_id = ?";
    $stmt = mysqli_prepare($conn, $update_email_query);
    mysqli_stmt_bind_param($stmt, "si", $new_email, $admin_id);
    mysqli_stmt_execute($stmt);
  }

  if (!empty($new_password)) {
    $update_password_query = "UPDATE admin_tbl SET password = ? WHERE admin_id = ?";
    $stmt = mysqli_prepare($conn, $update_password_query);
    mysqli_stmt_bind_param($stmt, "si", $new_password, $admin_id);
    mysqli_stmt_execute($stmt);
  }

  // Redirect to the same page to see the changes
  header("Location: profile.php");
  exit();
}
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
    <link
      rel="icon"
      href="img/kaiadmin/favicon.ico"
      type="image/x-icon" 
    />

    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/plugins.min.css" />
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="assets/css/demo.css" />

    <?php include 'all-css.php';?>
    <style>
      .profile-container {
        display: flex;
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
      }

      .profile-img {
        width: 100px; /* Adjust for your preferred size */
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #008080;
      }

      .text-teal {
        color: #008080;
      }

    </style>
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
                src="assets/img/kaiadmin/logo_light.svg"
                alt="navbar brand"
                class="navbar-brand"
                height="20"
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
                src="assets/img/kaiadmin/logo_light.svg"
                alt="navbar brand"
                class="navbar-brand"
                height="20"
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
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">

            </div>
            <div class="row">
              <div class="row justify-content-center">
                <div class="col-md-14 col-lg-12 col-xl-12">
                  <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Admin Profile</h4>
                        </div>
                        <div class="profile-container d-flex align-items-center p-4 shadow-lg rounded bg-white">
                            <!-- Profile Image -->
                            <img src="<?php echo $profile_img; ?>" alt="Admin Profile" class="profile-img me-4">

                            <!-- Profile Info -->
                            <div class="profile-info">
                                <h3 class="text-teal fw-bold">Hello, <?php echo htmlspecialchars($admin['username']); ?>!</h3>
                                <p class="text-muted">Welcome to your profile.</p>
                                <p class="text-muted"><i class="fas fa-envelope text-teal me-2"></i>Email: <strong><?php echo htmlspecialchars($admin['email']); ?></strong></p>
                                <p class="text-muted"><i class="fas fa-phone text-teal me-2"></i>Phone: <strong><?php echo htmlspecialchars($admin['mob_no']); ?></strong></p>
                            </div>                            
                        </div>
                        <!-- Account Settings -->
                        <div class="mt-4">
                          <div class="card p-4 shadow-sm rounded-4 border-0">
                            <h4 class="mb-3 text-primary">
                              <i class="fas fa-cog me-2"></i> Account Settings
                            </h4>
                            <form action="" method="POST">
                              <div class="mb-3">
                                <label class="form-label">New Email:</label>
                                <input type="email" name="new_email" class="form-control" placeholder="Enter new email">
                              </div>
                              <div class="mb-3">
                                <label class="form-label">New Password:</label>
                                <input type="password" name="new_password" class="form-control" placeholder="Enter new password">
                              </div>
                              <button type="submit" class="btn btn-primary">Update</button>
                            </form>
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
