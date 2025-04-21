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

<?php
include 'connection.php';
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
    
    
    
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />
    
    <link rel="stylesheet" href="assets/css/templatemo-scholar.css" />
    
    <style>
      .page-header{
        color: #2a2f5b;
      }

      .courses {
        margin-top: 0px;
      }

      .section {
        padding-top: 30px;   
           
      }
    </style>


  <!-- Include Razorpay Checkout Library -->
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

  <script>
      document.addEventListener("DOMContentLoaded", function () {
          document.body.addEventListener('click', function (event) {
              if (event.target.classList.contains('buy-now-btn')) {
                  let courseId = event.target.getAttribute('data-course-id');
                  let courseTitle = event.target.getAttribute('data-course-title');
                  let coursePrice = parseFloat(event.target.getAttribute('data-course-price'));
  
                  let userId = "<?php echo $_SESSION['user_id'] ?? ''; ?>";
  
                  if (!userId) {
                      alert("Please log in to purchase this course.");
                      window.location.href = "index.php";
                      return;
                  }
  
                  let options = {
                      "key": "rzp_test_XVZdhQRu2QeeqY",
                      "amount": coursePrice * 100,
                      "currency": "INR",
                      "name": "AI LMS",
                        "description": courseTitle,
                        "image": "img/LEAR1.png",
                        "image_size": "200x200",
                        "theme": { "color": "#ff5722" },
                      "handler": function (response) {
                          fetch('payment_process.php', {
                              method: 'POST',
                              headers: { 'Content-Type': 'application/json' },
                              body: JSON.stringify({
                                  payment_id: response.razorpay_payment_id,
                                  u_id: userId,
                                  course_id: courseId,
                                  amount: coursePrice.toFixed(2)
                              })
                          }).then(res => res.json())
                          .then(data => {
                              if (data.status === 'success') {
                                  alert("Payment Successful!");
                                  window.location.href = "payment_success.php";
                              } else {
                                  alert("Payment Failed: " + data.message);
                              }
                          }).catch(error => {
                              alert("Error processing payment: " + error);
                          });
                      },
                      "theme": { "color": "#673ab7" }
                  };
  
                  let rzp = new Razorpay(options);
                  rzp.open();
                  event.preventDefault(); // Prevent default behavior
              }
          });
      });
  </script>
  
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
             
              <li class="nav-item active">
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
              <h3 class="fw-bold mb-3">Buy Course</h3>
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
                  <a href="#">Buy Course</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Select & Buy Course</a>
                </li>
              </ul>
            </div>
            <form action="#" method="POST">
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                      <div class="card-title">Our AI-Powered Courses</div>
                      
                    </div>
                    <div class="card-body">
                    <?php
            // Include database connection
            include 'connection.php'; 

            // Ensure instructor_id exists in course_tbl
            $check_column = mysqli_query($conn, "SHOW COLUMNS FROM course_tbl LIKE 'instructor_id'");
            if (mysqli_num_rows($check_column) == 0) {
                die("Error: 'instructor_id' column is missing in course_tbl.");
            }
            // Fetch courses along with instructor names and class images
            $query = "
            SELECT 
                c.course_id, 
                c.course_title,  
                c.price, 
                c.course_desc,  
                cl.image AS class,  
                c.subject AS subject_name,
                i.instructor_name
            FROM course_tbl AS c
            JOIN instructor_tbl AS i ON c.instructor_id = i.instructor_id
            JOIN class_tbl AS cl ON c.class_id = cl.class_id
            ";

            $result = mysqli_query($conn, $query);
            if (!$result) {
                die("Query failed: " . mysqli_error($conn));
            }
            ?>

            <section class="section courses" id="courses">
            <div class="container">           
                <?php
                include "connection.php";

                // Fetch courses with class-wise images
                $query = "SELECT c.*, cl.image AS class_image
                            FROM course_tbl c
                            INNER JOIN class_tbl cl ON c.class_id = cl.class_id"; // Ensure class_id is a common field
                $result = mysqli_query($conn, $query);

                // Check if the query was successful
                if (!$result) {
                    echo "<p>Error fetching data: " . mysqli_error($conn) . "</p>";
                    exit();
                }
                ?>
                <div class="row event_box">
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <?php
                    // Generate image path based on class image
                    $imagePath = !empty($row['class_image']) ? "/php/AI-LMS/scholar-1.0.0/" . htmlspecialchars($row['class_image'], ENT_QUOTES, 'UTF-8') : "/php/AI-LMS/scholar-1.0.0/uploads/course-01.jpg";
                    
                    // Generate class name dynamically
                    $categoryClass = strtolower(str_replace(' ', '-', $row['class']));
                    ?>
                    
                    <div class="col-lg-4 col-md-6 align-self-center mb-30 event_outer <?php echo htmlspecialchars($categoryClass, ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="events_item" style="height: 100%;">
                            <div class="thumb">
                                <img src="<?php echo $imagePath; ?>" class="img-fluid" alt="Course Image">
                                <span class="category"><?php echo htmlspecialchars($row['class'], ENT_QUOTES, 'UTF-8'); ?></span>
                                <span class="price">
                                    <h6 style="font-size: 20px;"><em>₹</em><?php echo number_format($row['price']); ?></h6>
                                </span>
                            </div>

                            <div class="down-content">
                                <h4><?php echo htmlspecialchars($row['course_title'], ENT_QUOTES, 'UTF-8'); ?></h4>
                                <p><?php echo htmlspecialchars($row['course_desc'], ENT_QUOTES, 'UTF-8'); ?></p><br>
                                <div class="text-center">
                                <button class="btn buy-now-btn" 
                                        data-course-id="<?php echo $row['course_id']; ?>"
                                        data-course-title="<?php echo htmlspecialchars($row['course_title'], ENT_QUOTES, 'UTF-8'); ?>"
                                        data-course-price="<?php echo htmlspecialchars($row['price'], ENT_QUOTES, 'UTF-8'); ?>"
                                        style="background-color: rgb(103, 90, 180); border-color: rgb(103, 90, 180); color: white; width: 50%;">
                                    Buy Now
                                </button>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                </div>
                <?php
                // Close the database connection
                mysqli_close($conn);
                ?>

                </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>                      
          </div> 
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
