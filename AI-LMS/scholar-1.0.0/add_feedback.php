    <?php
    session_start();
    require_once 'connection.php'; // Ensure database connection

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
    ?>
    <?php
    // Removed duplicate inclusion of connection.php

    $user_id = $_SESSION['user_id'];

    // Fetch user information from the signup table
    $user_query = "SELECT username, email, mob_no, class FROM signup WHERE id = ?";
    $stmt = mysqli_prepare($conn, $user_query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $user_result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($user_result);
    ?>

    <?php
    // Removed duplicate inclusion of connection.php

    // Initialize variables and error messages
    $feedback = "";
    $feedbackError = "";

    // Form submission check
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $isValid = true; // Flag to track validation status

        // Validate Feedback
        if (!isset($_POST['feedback']) || empty(trim($_POST['feedback']))) {
            $feedbackError = "Feedback cannot be empty.";
            $isValid = false;
        } elseif (strlen($_POST['feedback']) < 5) { // Minimum length validation
            $feedbackError = "Feedback must be at least 5 characters long.";
            $isValid = false;
        } else {
            $feedback = mysqli_real_escape_string($conn, trim($_POST['feedback']));
        }

        // Proceed with database insertion only if the form is valid
        if ($isValid) {
          // Check if the user has already submitted the same feedback
          $checkQuery = "SELECT * FROM feedback_tbl WHERE user_id = ? AND feed_txt = ?";
          $stmt = mysqli_prepare($conn, $checkQuery);
          mysqli_stmt_bind_param($stmt, "is", $user_id, $feedback);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);

          if (mysqli_num_rows($result) > 0) {
              echo "<script>alert('You have already submitted this feedback!');</script>";
          } else {
              // Insert the feedback
              $insertQuery = "INSERT INTO feedback_tbl (user_id, feed_txt) VALUES (?, ?)";
              $stmt = mysqli_prepare($conn, $insertQuery);
              mysqli_stmt_bind_param($stmt, "is", $user_id, $feedback);
              
              if (mysqli_stmt_execute($stmt)) {
                  echo "<script>alert('Feedback submitted successfully!');</script>";
                  echo "<script>window.location.href='add_feedback.php';</script>"; // Reload page
              } else {
                  echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
              }
          }
      }
    }
    ?>

    <?php
    // Removed duplicate inclusion of connection.php
    // Fetch user IDs from the signup table
    $userQuery = "SELECT id FROM signup"; // Adjust the table and columns
    $userResult = mysqli_query($conn, $userQuery);
    ?>

    <!DOCTYPE html>
    <html lang="en">
      <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        
        <title>Learning Hub - AI LMS</title>
    <link rel="icon" href="/php/AI-LMS/assets/img/lear1_icon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/php/AI-LMS/assets/img/lear1_icon.ico" type="image/x-icon">
        <link
          rel="icon"
          href="img/kaiadmin/favicon.ico"
          type="image/x-icon" 
        />

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
            <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
              <!-- Logo Header -->
              <div class="logo-header" data-background-color="dark">
                <a href="index1.php" class="logo">
                  <!-- <img
                    src="img/kaiadmin/logo_light.svg"
                    alt="navbar brand"
                    class="navbar-brand"
                    height="20"
                  /> -->
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
                  <li class="nav-item ">
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
                  <li class="nav-item active">
                    <a data-bs-toggle="collapse" href="#user-feedback">
                    <i class="fas fa-comments"></i>
                      <p>User-feedback</p>
                      <span class="caret"></span>
                      <span class="badge badge-success"></span>
                    </a>
                    <div class="collapse" id="user-feedback" data-bs-parent="#accordionSidebar">
                      <ul class="nav nav-collapse">
                        <li>
                          <a href="add_feedback.php">
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
            <?php include 'navbar1.php'; ?>

            <div class="container">
              <div class="page-inner">
                <div class="page-header">
                  <h3 class="fw-bold mb-3">Add Users FeedBack</h3>
                  <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                      <a href="user_dashboard.php">
                        <i class="icon-home"></i>
                      </a>
                    </li>
                    <li class="separator">
                      <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                      <a href="#">FeedBack</a>
                    </li>
                    <li class="separator">
                      <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                      <a href="#">Add FeedBack </a>
                    </li>
                  </ul>
                </div>
                <form action="#" method="POST">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-header">
                          <div class="card-title">Add FeedBack Details</div>
                        </div>
                            <div class="card-body">
                              <div class="row">
                                  <div class="col-md-6 col-lg-4">                                
                                    <div class="form-group">
                                        <label for="feedback">Feedback</label>
                                        <textarea class="form-control" id="feedback" name="feedback" rows="4" placeholder="Enter your feedback here"></textarea>
                                        <span style="color: red;"><?php echo $feedbackError ?? ''; ?></span>
                                    </div>
                                  </div>    
                              </div>
                            </div>

                        <div class="card-action">
                          <button class="btn btn-success" name="btn">Submit</button>
                          <button type="reset" class="btn btn-danger" onclick="window.location.href = 'add_feedback.php';">Cancel</button>
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
