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
include 'connection.php'; // Include database connection

$quizTitle = $course = $subject = $class = "";
$quizTitleError = $courseError = $subjectError = $classError = "";
$questionError = $optionAError = $optionBError = $optionCError = $optionDError = $correctAnswerError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate quiz details
    if (empty($_POST["quiz_title"])) {
        $quizTitleError = "Quiz title is required";
    } else {
        $quizTitle = htmlspecialchars($_POST["quiz_title"]);
    }

    if (empty($_POST["course"])) {
        $courseError = "Course is required";
    } else {
        $course = htmlspecialchars($_POST["course"]);
    }

    if (empty($_POST["subject"])) {
        $subjectError = "Subject is required";
    } else {
        $subject = htmlspecialchars($_POST["subject"]);
    }

    if (empty($_POST["class"])) {
        $classError = "Class is required";
    } else {
        $class = htmlspecialchars($_POST["class"]);
    }

    // Validate questions and options
    $questions = [];
    for ($i = 0; $i < 15; $i++) {
        $qKey = "question_" . $i;
        $aKey = "option_a_" . $i;
        $bKey = "option_b_" . $i;
        $cKey = "option_c_" . $i;
        $dKey = "option_d_" . $i;
        $correctKey = "correct_answer_" . $i;

        if (isset($_POST[$qKey], $_POST[$aKey], $_POST[$bKey], $_POST[$cKey], $_POST[$dKey], $_POST[$correctKey])) {
            $questions[] = [
                "question" => htmlspecialchars($_POST[$qKey]),
                "option_a" => htmlspecialchars($_POST[$aKey]),
                "option_b" => htmlspecialchars($_POST[$bKey]),
                "option_c" => htmlspecialchars($_POST[$cKey]),
                "option_d" => htmlspecialchars($_POST[$dKey]),
                "correct_answer" => htmlspecialchars($_POST[$correctKey])
            ];
        } else {
            $questionError = "All 15 questions must be filled.";
            break;
        }
    }

    // If no errors in quiz details and questions
    if (empty($quizTitleError) && empty($courseError) && empty($subjectError) && empty($classError) && empty($questionError)) {
        $questionsJson = json_encode($questions); // Convert questions to JSON format

        $stmt = $conn->prepare("INSERT INTO quizzes (quiz_title, class, course, subject, questions) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $quizTitle, $class, $course, $subject, $questionsJson);

        if ($stmt->execute()) {
            echo "<script>alert('Quiz added successfully with 15 questions!');</script>";
        } else {
            echo "<script>alert('Error adding quiz: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    }
}
?>

<?php 
// Fetch class data from the database
$classQuery = "SELECT class FROM class_tbl";
$classResult = mysqli_query($conn, $classQuery);
?>

<?php 
// Fetch class data from the database
$subQuery = "SELECT subject FROM subject_tbl";
$subResult = mysqli_query($conn, $subQuery);
?>

<?php 
// Fetch class data from the database
$courseQuery = "SELECT course_title FROM course_tbl";
$courseResult = mysqli_query($conn, $courseQuery);
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
              <li class="nav-item active">
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
              </li>
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

        <form method="POST" action="">
          <div class="container">
            <div class="page-inner">
              <div class="page-header">
                <h3 class="fw-bold mb-3">Add Quiz</h3>
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
                    <a href="#">Quiz</a>
                  </li>
                  <li class="separator">
                    <i class="icon-arrow-right"></i>
                  </li>
                  <li class="nav-item">
                    <a href="#">Add Quiz</a>
                  </li>
                </ul>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                      <div class="card-title">Add Quiz Details</div>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-6 col-lg-4">
                          <div class="form-group">
                            <label for="quiz_title">Quiz Title</label>
                            <input type="text" class="form-control" id="quiz_title" name="quiz_title" value="<?php echo htmlspecialchars($quizTitle); ?>" placeholder="Enter Quiz Title" required>
                            <span style="color: red;"><?php echo $quizTitleError; ?></span>
                          </div>

                          <!-- Class Selection -->
                          <div class="form-group">
                            <label for="class1">Class</label>
                            <select class="form-control" id="class1" name="class" required>
                              <option value="" disabled selected>Select Class</option>
                              <?php
                                if ($classResult) {
                                  while ($row = mysqli_fetch_assoc($classResult)) {
                                    echo "<option value='{$row['class']}'>{$row['class']}</option>";
                                  }
                                } else {
                                  echo "<option value=''>No classes available</option>";
                                }
                              ?>
                            </select>
                            <span style="color: red;"><?php echo isset($classError) ? $classError : ''; ?></span>
                          </div>

                          <!-- Course Selection -->
                          <div class="form-group">
                            <label for="course1">Course</label>
                            <select class="form-control" id="course1" name="course" required>
                              <option value="" disabled selected>Select Course</option>
                              <?php
                                if ($courseResult) {
                                  while ($row = mysqli_fetch_assoc($courseResult)) {
                                    echo "<option value='{$row['course_title']}'>{$row['course_title']}</option>";
                                  }
                                } else {
                                  echo "<option value=''>No Courses available</option>";
                                }
                              ?>
                            </select>
                            <span style="color: red;"><?php echo isset($courseError) ? $courseError : ''; ?></span>
                          </div>

                          <!-- Subject Selection -->
                          <div class="form-group">
                            <label for="sub1">Subject</label>
                            <select class="form-control" id="sub1" name="subject" required>
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
                            <span style="color: red;"><?php echo isset($subjectError) ? $subjectError : ''; ?></span>
                          </div>

                          <!-- Question Input -->
                          <div class="form-group">
                            <label for="question">Question</label>
                            <textarea class="form-control" id="question" name="question" placeholder="Enter Question" required></textarea>
                            <span style="color: red;"><?php echo isset($questionError) ? $questionError : ''; ?></span>
                          </div>

                          <!-- Options A, B, C, D -->
                          <?php
                          $options = ['A', 'B', 'C', 'D'];
                          foreach ($options as $option) {
                            echo "<div class='form-group'>
                                    <label for='option_$option'>Option $option</label>
                                    <input type='text' class='form-control' id='option_$option' name='option_$option' placeholder='Enter Option $option' required>
                                    <span style='color: red;'>".(isset(${"option".$option."Error"}) ? ${"option".$option."Error"} : "")."</span>
                                  </div>";
                          }
                          ?>

                          <!-- Correct Answer Selection -->
                          <div class="form-group">
                            <label for="correct_answer">Correct Answer</label>
                            <select class="form-control" id="correct_answer" name="correct_answer" required>
                              <option value="" disabled selected>Select Correct Answer</option>
                              <option value="A">Option A</option>
                              <option value="B">Option B</option>
                              <option value="C">Option C</option>
                              <option value="D">Option D</option>
                            </select>
                            <span style="color: red;"><?php echo isset($correctAnswerError) ? $correctAnswerError : ''; ?></span>
                          </div>
                        </div>    
                      </div>
                    </div>
                    <div class="card-action">
                      <button type="submit" class="btn btn-success me-3" name="btn">Submit</button>
                      <button type="reset" class="btn btn-danger" onclick="window.location.href = 'add_quiz.php';">Cancel</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>

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
