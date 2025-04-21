<?php
session_start();
require 'connection.php'; // Ensure database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user information
$user_query = "SELECT username, email FROM signup WHERE id = ?";
$stmt = mysqli_prepare($conn, $user_query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$user_result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($user_result);

// Default profile image (replace this if user profile images are stored in the database)
$profile_img = "img/user.avif"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $new_username = $_POST['new_username'];
  $new_mobno = $_POST['new_mobno'];
  $new_email = $_POST['new_email'];
  $new_password = $_POST['new_password'];

  if (!empty($new_username)) {
    $update_username_query = "UPDATE signup SET username = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $update_username_query);
    mysqli_stmt_bind_param($stmt, "si", $new_username, $user_id);
    mysqli_stmt_execute($stmt);
  }

  if (!empty($new_mobno)) {
    $update_mobno_query = "UPDATE signup SET mob_no = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $update_mobno_query);
    mysqli_stmt_bind_param($stmt, "si", $new_mobno, $user_id);
    mysqli_stmt_execute($stmt);
  }

  // if condition removed or add a valid condition here

  if (!empty($new_email)) {
    $update_email_query = "UPDATE signup SET email = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $update_email_query);
    mysqli_stmt_bind_param($stmt, "si", $new_email, $user_id);
    mysqli_stmt_execute($stmt);
  }

  if (!empty($new_password)) {
    $update_password_query = "UPDATE signup SET password = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $update_password_query);
    mysqli_stmt_bind_param($stmt, "si", $new_password, $user_id);
    mysqli_stmt_execute($stmt);
  }

  // Redirect to the same page to see the changes
  header("Location: profile.php");
  exit();
}
?>
<?php
require 'connection.php'; // Ensure you have a database connection file

$user_id = $_SESSION['user_id'];

// Fetch user information from the signup table
$user_query = "SELECT username, email, mob_no, class FROM signup WHERE id = ?";
$stmt = mysqli_prepare($conn, $user_query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$user_result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($user_result);
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
              <a href="user_dashboard.php" class="logo">
                <img
                src="img/LEAR.png"
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
                <a href="user_dashboard.php" aria-expanded="false">
                  <i class="fas fa-tachometer-alt"></i>
                  <p>Dashboard</p>
                </a>
               
              </li> 
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#buy-course">
                <i class="fas fa-shopping-cart"></i>
                  <p>Buy Course</p>
                  <span class="caret"></span>
                  
                </a>
                <div class="collapse" id="buy-course" data-bs-parent="#accordionSidebar">
                  <ul class="nav nav-collapse">
                  <li>
                    <a href="buy_course.php">
                    <span class="sub-item">Select & Buy Course</span>
                    </a>
                  </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#course-material">
                <i class="fas fa-book"></i>
                  <p>Course Material</p>
                  <span class="caret"></span>                  
                </a>
                <div class="collapse" id="course-material" data-bs-parent="#accordionSidebar">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="course_material.php">
                        <span class="sub-item">View Course Material</span>
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
                </a>
                <div class="collapse" id="user-feedback" data-bs-parent="#accordionSidebar">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="add_feedback.php">
                        <span class="sub-item">Add User-feedback</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              
            </ul>
          </div>
        </div>
    </div>
      <!-- End Sidebar -->

      <div class="main-panel">
       <?php include 'navbar1.php'; ?>

        <div class="container">
          <div class="page-inner">
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              

              
            </div>
            <div class="row">
              <div class="row justify-content-center">
                <div class="col-md-14 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">User Profile</h4>
                        </div>
                        <div class="profile-container d-flex align-items-center p-4 shadow-lg rounded bg-white">
                            <!-- Profile Image -->
                            <img src="img/user.avif" alt="User Profile" class="profile-img me-4">
                            <!-- Profile Info -->
                            <div class="profile-info">
                                <h3 class="text-teal fw-bold">Hello, <?php echo htmlspecialchars($user['username']); ?>!</h3>
                                <p class="text-muted">Welcome to your profile.</p>
                                <p class="text-muted"><i class="fas fa-envelope text-teal me-2"></i>Email: <strong><?php echo htmlspecialchars($user['email']); ?></strong></p>
                                <p class="text-muted"><i class="fas fa-phone text-teal me-2"></i>Phone: <strong><?php echo htmlspecialchars($user['mob_no']); ?></strong></p>
                                <p class="text-muted"><i class="fas fa-graduation-cap text-teal me-2"></i>Class: <strong><?php echo htmlspecialchars($user['class']); ?></strong></p>
                            </div>
                        </div>
                        
                        <!-- Recent Lessons Section -->
                        <div class="mt-4">
                            <div class="card p-4 shadow-sm rounded-4 border-0">
                                <h4 class="mb-3 text-primary">
                                    <i class="fas fa-book-open me-2"></i> Recent Lessons
                                </h4>
                                <ul class="list-group">
                                    <?php
                                    $lesson_query = "SELECT lesson_name, created_at FROM lesson_tbl WHERE user_id = ? ORDER BY created_at DESC LIMIT 5";
                                    $stmt = mysqli_prepare($conn, $lesson_query);
                                    mysqli_stmt_bind_param($stmt, "i", $user_id);
                                    mysqli_stmt_execute($stmt);
                                    $lesson_result = mysqli_stmt_get_result($stmt);

                                    while ($lesson = mysqli_fetch_assoc($lesson_result)) {
                                        echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                                        echo htmlspecialchars($lesson['lesson_name']);
                                        echo '<span class="text-muted small">' . date('M d, Y', strtotime($lesson['created_at'])) . '</span>';
                                        echo '</li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>

                        <!-- Progress Overview -->
                        <div class="mt-4">
                            <div class="card p-4 shadow-sm rounded-4 border-0" style="background-color: #f3f4f6;">
                                <h4 class="mb-3 text-primary">
                                    <i class="fas fa-chart-line me-2"></i> Progress Overview
                                </h4>
                                <?php
                                $total_lessons_query = "SELECT COUNT(*) as total FROM lesson_tbl WHERE user_id = ?";
                                $stmt = mysqli_prepare($conn, $total_lessons_query);
                                mysqli_stmt_bind_param($stmt, "i", $user_id);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                $total_lessons = mysqli_fetch_assoc($result)['total'];

                                $completed_lessons = rand(2, $total_lessons); // Placeholder: Replace with actual completion tracking
                                $progress = ($total_lessons > 0) ? ($completed_lessons / $total_lessons) * 100 : 0;
                                ?>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $progress; ?>%;" 
                                        aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100">
                                        <?php echo round($progress); ?>%
                                    </div>
                                </div>
                                <p class="text-muted mt-2">
                                    <?php echo $completed_lessons; ?> out of <?php echo $total_lessons; ?> lessons completed.
                                </p>
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
                              <label class="form-label">New Username:</label>
                              <input type="text" name="new_username" class="form-control" placeholder="Enter new username">
                              </div>
                                <div class="mb-3">
                                <label class="form-label">New Mobile No:</label>
                                <input type="tel" name="new_mobno" class="form-control" placeholder="Enter new mobile no" pattern="[0-9]{10}" title="Please enter a valid 10-digit mobile number">
                                </div>
                                <div class="mb-3">
                                <label class="form-label">New Email:</label>
                                <input type="email" name="new_email" class="form-control" placeholder="Enter new email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter a valid email address">
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
      <?php include 'settings.php'; ?>
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
    <!-- <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>  -->

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
