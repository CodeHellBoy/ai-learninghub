<?php
// Include database connection
include 'connection.php'; 

// Fetch courses from the database
$query = "SELECT * FROM course_tbl";
$result = mysqli_query($conn, $query);
?>



<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>Learning Hub - AI LMS</title>
    <link rel="icon" href="/php/AI-LMS/assets/img/lear1_icon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/php/AI-LMS/assets/img/lear1_icon.ico" type="image/x-icon">

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-scholar.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
<!--

TemplateMo 586 Scholar

https://templatemo.com/tm-586-scholar

-->


  </head>

<body>

  <!-- ***** Preloader Start ***** -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky">
    <div class="container">
      <?php include 'navbar.php'?>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->

  <div class="main-banner" id="top">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="owl-carousel owl-banner"> 
            <div class="header-text">
                
                
            </div>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  
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
    <div class="row">
      <div class="col-lg-12 text-center">
        <div class="section-heading">
          <h6>Our AI-Powered Courses</h6>
          <h2>AI-Driven Learning Paths</h2>
        </div>
      </div>
    </div>

    <ul class="event_filter">
      <li><a class="is_active" href="#!" data-filter="*">Show All</a></li>
      <?php
      include "connection.php";

      // Fetch unique class names from the database
      $class_query = "SELECT DISTINCT cl.class FROM class_tbl cl 
                      INNER JOIN course_tbl c ON cl.class_id = c.class_id";
      $class_result = mysqli_query($conn, $class_query);

      if ($class_result) {
          while ($class_row = mysqli_fetch_assoc($class_result)) {
              $class_name = htmlspecialchars($class_row['class'], ENT_QUOTES, 'UTF-8');
              $class_slug = strtolower(str_replace(' ', '-', $class_name)); // Convert to slug format
              echo "<li><a href='#' data-filter='.$class_slug'>$class_name</a></li>";
          }
      } else {
          echo "<li>Error fetching classes</li>";
      }

      // Close DB connection (optional, if not needed later)
      mysqli_close($conn);
      ?>
    </ul>

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
</section>
  <footer>
    <div class="container">
      <?php include '../scholar-1.0.0/bootstrap-footer-20/footer.php';?>
    </div>
  </footer>

  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/js/isotope.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/counter.js"></script>
  <script src="assets/js/custom.js"></script>

  </body>
</html>


