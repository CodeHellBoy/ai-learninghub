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
require_once 'connection.php'; // Ensure you have a database connection file

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
include_once 'connection.php';
// Fetch user IDs from the signup table
$userQuery = "SELECT id FROM signup"; // Adjust the table and columns
$userResult = mysqli_query($conn, $userQuery);
?>

<?php
    // Fetch purchased courses for the logged-in user
    $query = "
    SELECT DISTINCT c.course_id, c.class, c.subject, c.course_title, c.course_desc, c.pdf1, c.video_lecture, c.created_at 
    FROM payments_tbl p 
    JOIN course_tbl c ON p.course_id = c.course_id 
    WHERE p.u_id = ?
    ORDER BY p.created_at DESC";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $hasCourses = mysqli_num_rows($result) > 0;
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
    <style>
    /* Container Styling */
.course-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); /* Ensures 2 columns per row */
    gap: 20px;
    padding: 20px;
    justify-content: center;
}

/* Course Card */
.course-card {
    background: linear-gradient(to right, #f8f9fa, #e9ecef); /* Light gradient */
    color: #333;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #ddd;
    width: 100%;
    max-width: 450px;
}

.course-card:hover {
    transform: translateY(-6px);
    box-shadow: 0px 6px 14px rgba(0, 0, 0, 0.15);
}

/* Course Title */
.course-card h3 {
    font-size: 18px;
    margin-bottom: 10px;
    color: #007bff;
}

/* Course Details */
.course-card p {
    margin: 5px 0;
    font-size: 14px;
    color: #555;
}

/* Description */
.description {
    font-size: 14px;
    color: #666;
    margin-top: 10px;
}

/* Video Styling */
.video-container iframe {
    width: 100%;
    aspect-ratio: 16/9;
    border-radius: 8px;
    border: 1px solid #ddd;
}

/* Button Styling */
.btn-primary {
    display: inline-block;
    padding: 12px 18px;
    background: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: bold;
    transition: background 0.3s ease, transform 0.2s ease;
    text-align: center;
}

.btn-primary:hover {
    background: #0056b3;
    transform: scale(1.05);
}

/* Badge Styling */
.badge {
    font-size: 0.85rem;
    font-weight: bold;
}

/* Icon Styling */
.icon-box {
    width: 50px;
    height: 50px;
    background-color: #007bff;
    color: white;
    font-size: 1.5rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Responsive Design */
@media (max-width: 900px) {
    .course-container {
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); /* 1 course per row on smaller screens */
    }
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
              <li class="nav-item active">
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
              <h3 class="fw-bold mb-3">Course Material</h3>
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
                  <a href="#">Course Material</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">View Course Material</a>
                </li>
              </ul>
            </div>
            <form action="#" method="POST">
              <div class="row">
                  <div class="col-md-12">
                      <div class="card">
                          <div class="card-header">
                              <div class="card-title">Courses</div>
                          </div>
                          <div class="card-body">
                              <?php if ($hasCourses): ?>
                                  <div class="course-container">
                                      <?php while ($row = $result->fetch_assoc()): ?>
                                          <?php 
                                              // Calculate expiry date (1 year from purchase)
                                              $purchase_date = $row['created_at'];
                                              $expiry_date = date("F j, Y", strtotime($purchase_date . ' +1 year'));
                                              $is_expired = (strtotime($expiry_date) < time());

                                              // Dynamic badge based on subject
                                              $badges = [
                                                  'ai' => '🔥 AI Mastery',
                                                  'python' => '🐍 Python Pro',
                                                  'web development' => '🌍 Web Guru'
                                              ];
                                              $badge = $badges[strtolower($row['subject'])] ?? '🏆 Certified Learner';
                                          ?>

                                          <div class="course-card position-relative p-3 border rounded shadow-sm mb-4">
                                              <!-- Badge -->
                                              <span class="badge position-absolute top-0 end-0 <?= $is_expired ? 'bg-danger' : 'bg-warning' ?> text-dark px-3 py-2 rounded-pill mt-2 me-2">
                                                  <?= htmlspecialchars($badge) ?>
                                              </span>

                                              <div class="d-flex align-items-center mb-3">
                                                  <h3 class="text-primary fw-bold ms-3 mb-0"><?= htmlspecialchars($row['course_title']) ?></h3>
                                              </div>

                                              <p class="mb-1"><strong class="text-secondary">🎓 Class:</strong> <?= htmlspecialchars($row['class']) ?></p>
                                              <p class="mb-1"><strong class="text-secondary">📖 Subject:</strong> <?= htmlspecialchars($row['subject']) ?></p>
                                              <p class="description text-muted"><?= nl2br(htmlspecialchars($row['course_desc'])) ?></p>

                                              <!-- Expiry Date -->
                                              <p class="<?= $is_expired ? 'text-danger fw-bold' : 'text-success fw-bold' ?>">
                                                  ⏳ Expiry Date: <?= htmlspecialchars($expiry_date) ?>
                                              </p>

                                              <div class="mt-3 d-flex gap-2">
                                                  <?php if (!empty($row['pdf1']) && !$is_expired): ?>
                                                      <a href="<?= '/php/AI-LMS/' . trim(htmlspecialchars($row['pdf1'])) ?>" target="_blank" class="btn btn-outline-primary btn-sm d-flex align-items-center">
                                                          📄 Download PDF
                                                      </a>                                                
                                                  <?php endif; ?>

                                                  <?php if (!empty($row['video_lecture']) && !$is_expired): ?>
                                                      <a href="<?= htmlspecialchars($row['video_lecture']) ?>" target="_blank" class="btn btn-outline-danger btn-sm d-flex align-items-center">
                                                          🎥 Watch Video
                                                      </a>
                                                  <?php endif; ?>

                                                  <?php 
                                                      // Certificate becomes available 2 months after purchase
                                                      $certificate_date = date("F j, Y", strtotime($purchase_date . ' +2 months'));
                                                      $can_download_certificate = (strtotime($certificate_date) <= time());
                                                  ?>

                                                  <?php if (!$is_expired && $can_download_certificate): ?>
                                                      <a href="certificate.php?course_id=<?= $row['course_id'] ?>" class="btn btn-outline-success btn-sm d-flex align-items-center">
                                                          🎖 Download Certificate
                                                      </a>
                                                  <?php elseif (!$is_expired): ?>
                                                      <button class="btn btn-outline-secondary btn-sm d-flex align-items-center" disabled title="Certificate available after 2 months">
                                                          ⏳ Available on <?= htmlspecialchars($certificate_date) ?>
                                                      </button>
                                                  <?php endif; ?>
                                              </div>

                                              <?php if (!empty($row['video_lecture']) && !$is_expired): ?>
                                                  <?php 
                                                      $video_url = filter_var($row['video_lecture'], FILTER_VALIDATE_URL) ? htmlspecialchars($row['video_lecture']) : '';

                                                      // Convert YouTube watch URL to embed URL
                                                      if (strpos($video_url, 'youtube.com/watch') !== false) {
                                                          parse_str(parse_url($video_url, PHP_URL_QUERY), $query_params);
                                                          $video_id = $query_params['v'] ?? '';
                                                          $video_url = "https://www.youtube.com/embed/" . $video_id;
                                                      } elseif (strpos($video_url, 'youtu.be/') !== false) {
                                                          $video_id = basename(parse_url($video_url, PHP_URL_PATH));
                                                          $video_url = "https://www.youtube.com/embed/" . $video_id;
                                                      }
                                                  ?>
                                                  <?php if ($video_url): ?>
                                                      <div class="video-container mt-4 rounded-4 overflow-hidden shadow-sm">
                                                          <div class="ratio ratio-16x9">
                                                              <iframe src="<?= $video_url ?>" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                          </div>
                                                      </div>
                                                  <?php else: ?>
                                                      <p class="text-danger">⚠️ Invalid video URL.</p>
                                                  <?php endif; ?>
                                              <?php elseif ($is_expired): ?>
                                                  <p class="text-danger fw-bold mt-3">⚠️ Course Expired! 
                                                      <a href="buy_course.php?course_id=<?= $row['course_id'] ?>" class="text-primary">Renew Now</a>
                                                  </p>
                                              <?php endif; ?>
                                          </div>
                                      <?php endwhile; ?>
                                  </div>
                              <?php else: ?>
                                  <div class="text-center p-5 bg-light rounded-4 shadow-sm">
                                      <p class="no-courses text-danger fs-4 fw-bold">🚀 You haven't purchased any courses yet.</p>
                                      <a href="buy_course.php" class="btn btn-success btn-lg px-5 fw-bold">Explore Courses →</a>
                                  </div>
                              <?php endif; ?>                            
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
