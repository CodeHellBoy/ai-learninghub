<?php
session_start();
require_once 'connection.php'; // Ensure database connection

$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = mysqli_real_escape_string($conn, trim($_POST['first_name']));
    $last_name = mysqli_real_escape_string($conn, trim($_POST['last_name']));
    $course = mysqli_real_escape_string($conn, trim($_POST['course']));
    $city = mysqli_real_escape_string($conn, trim($_POST['city']));
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));

    if (!preg_match("/^[a-zA-Z ]+$/", $first_name) || !preg_match("/^[a-zA-Z ]+$/", $last_name)) {
        $error = "First and Last name must contain only letters.";
    } elseif (!preg_match("/^[0-9]{10,15}$/", $phone)) {
        $error = "Phone number must be 10-15 digits.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $stmt = $conn->prepare("INSERT INTO user_tbl (first_name, last_name, course, city, mob_no, email) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $first_name, $last_name, $course, $city, $phone, $email);

        if ($stmt->execute()) {
            $success = "Your details have been submitted successfully!";
        } else {
            $error = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
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

    <script>
        function validateForm() {
            let firstName = document.getElementById("first_name").value.trim();
            let lastName = document.getElementById("last_name").value.trim();
            let phone = document.getElementById("phone").value.trim();
            let email = document.getElementById("email").value.trim();
            let namePattern = /^[a-zA-Z ]+$/;
            let phonePattern = /^[0-9]{10,15}$/;
            let emailPattern = /^[^@]+@[^@]+\.[a-zA-Z]{2,}$/;

            if (!namePattern.test(firstName)) {
                alert("First name should contain only letters.");
                return false;
            }
            if (!namePattern.test(lastName)) {
                alert("Last name should contain only letters.");
                return false;
            }
            if (!phonePattern.test(phone)) {
                alert("Phone number should be 10-15 digits.");
                return false;
            }
            if (!emailPattern.test(email)) {
                alert("Enter a valid email address.");
                return false;
            }
            return true;
        }
    </script>

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

  <div class="contact-us section" id="contact">
  <div class="container">
      <div class="row">
        <div class="col-lg-6  align-self-center">
          <div class="section-heading">
            <h6>Contact Us</h6>
            <h2>We’re Here to Help You on Your AI Learning Journey</h2>
            <p>Thank you for exploring our AI-powered learning platform. We are dedicated to providing the best learning experience, tailored to your unique needs. Whether you have questions about courses, AI tools, or need support, feel free to reach out. We’re here to assist you.</p>
            <?php
            $offer_percentage = 30;
            $offer_validity = "31 December 2025";
            $offer_description = "Exclusive Offer $offer_percentage% OFF on AI courses!";
            ?>

            <!-- <div class="special-offer">
              <span class="offer">off<br><em><?php echo $offer_percentage; ?>%</em></span>
              <h6>Valid: <em><?php echo $offer_validity; ?></em></h6>
              <h4><?php echo $offer_description; ?></h4>
              <a href="#"><i class="fa fa-angle-right"></i></a>
            </div> -->
          </div>
        </div>
        <div class="col-lg-6">
          <div class="contact-us-content">
            <?php if (!empty($success)): ?>
              <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
              <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <form id="contact-form" action="" method="post" onsubmit="return validateForm();">
              <div class="row">
                  <div class="col-lg-12">
                      <fieldset>
                          <input type="text" name="first_name" id="first_name" placeholder="Your First Name..." required />
                      </fieldset>
                  </div>
                  <div class="col-lg-12">
                      <fieldset>
                          <input type="text" name="last_name" id="last_name" placeholder="Your Last Name..." required />
                      </fieldset>
                  </div>
                  <div class="col-lg-12">
                      <fieldset>
                          <input type="text" name="course" id="course" placeholder="Your Course..." required />
                      </fieldset>
                  </div>
                  <div class="col-lg-12">
                      <fieldset>
                          <input type="text" name="city" id="city" placeholder="Your City..." required />
                      </fieldset>
                  </div>
                  <div class="col-lg-12">
                      <fieldset>
                          <input type="text" name="phone" id="phone" pattern="[0-9]{10,15}" placeholder="Your Phone Number..." required />
                      </fieldset>
                  </div>
                  <div class="col-lg-12">
                      <fieldset>
                          <input type="email" name="email" id="email" placeholder="Your E-mail..." required />
                      </fieldset>
                  </div>
                  <div class="col-lg-12">
                      <fieldset>
                          <button type="submit" class="orange-button">Send Message Now</button>
                      </fieldset>
                  </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  

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

