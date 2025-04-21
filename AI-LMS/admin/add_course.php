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

<!-- Removed duplicate admin information fetching block -->

<?php
require 'connection.php'; // Ensure database connection

$uploadDir = "uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Default empty values
$class = $subject = $instructor_id = $class_id = $courseTitle = $courseDesc = $coursePrice = "";
$pdfPath = $videoLecture = ""; // Default empty values
$classError = $subjectError = $instructorError = $classIdError = $courseTitleError = $courseDescError = $pdfPathError = $priceError = $coursePriceError = $videoError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isValid = true;

    // Retrieve and sanitize inputs
    $class = isset($_POST['class']) ? mysqli_real_escape_string($conn, trim($_POST['class'])) : "";
    $instructor_id = isset($_POST['instructor_id']) ? mysqli_real_escape_string($conn, trim($_POST['instructor_id'])) : "";
    $class_id = isset($_POST['class_id']) ? mysqli_real_escape_string($conn, trim($_POST['class_id'])) : "";
    $subject = isset($_POST['subject']) ? mysqli_real_escape_string($conn, trim($_POST['subject'])) : "";
    $courseTitle = isset($_POST['course_title']) ? mysqli_real_escape_string($conn, trim($_POST['course_title'])) : "";
    $courseDesc = isset($_POST['course_desc']) ? mysqli_real_escape_string($conn, trim($_POST['course_desc'])) : "";
    $coursePrice = isset($_POST['course_price']) ? mysqli_real_escape_string($conn, trim($_POST['course_price'])) : "";

    // Validate fields
    if (empty($class)) { $classError = "Class is required."; $isValid = false; }
    if (empty($instructor_id)) { $instructorError = "Instructor Id is required."; $isValid = false; }
    if (empty($class_id)) { $classIdError = "Class ID is required."; $isValid = false; }
    if (empty($subject)) { $subjectError = "Subject is required."; $isValid = false; }
    if (empty($courseTitle)) { $courseTitleError = "Course Title is required."; $isValid = false; }
    if (empty($courseDesc)) { $courseDescError = "Course Description is required."; $isValid = false; }
    if (empty($coursePrice)) { $coursePriceError = "Course Price is required."; $isValid = false; }

    // Validate PDF file
    if (!empty($_FILES["pdfFile"]["name"])) {
        $fileTmpName = $_FILES["pdfFile"]["tmp_name"];
        $fileExt = strtolower(pathinfo($_FILES["pdfFile"]["name"], PATHINFO_EXTENSION));

        if ($fileExt === "pdf") {
            $newFileName = uniqid() . "_" . basename($_FILES["pdfFile"]["name"]);
            $filePath = $uploadDir . $newFileName;
            if (move_uploaded_file($fileTmpName, $filePath)) {
                $pdfPath = $filePath;
            } else {
                $pdfPathError = "Failed to upload PDF.";
                $isValid = false;
            }
        } else {
            $pdfPathError = "Only PDF files are allowed.";
            $isValid = false;
        }
    } else {
        $pdfPathError = "PDF file is required.";
        $isValid = false;
    }

    // Validate Video file or URL
    if (!empty($_FILES["videoFile"]["name"]) && !empty($_POST["video_lecture"])) {
        $videoError = "Please provide either a video file or a video URL, not both.";
        $isValid = false;
    } elseif (!empty($_FILES["videoFile"]["name"])) {
        $videoTmpName = $_FILES["videoFile"]["tmp_name"];
        $videoExt = strtolower(pathinfo($_FILES["videoFile"]["name"], PATHINFO_EXTENSION));
        $allowedVideoExtensions = ["mp4", "avi", "mov", "mkv"];

        if (in_array($videoExt, $allowedVideoExtensions)) {
            $newVideoName = uniqid() . "_" . basename($_FILES["videoFile"]["name"]);
            $videoPath = $uploadDir . $newVideoName;
            if (move_uploaded_file($videoTmpName, $videoPath)) {
                $videoLecture = $videoPath;
            } else {
                $videoError = "Failed to upload video.";
                $isValid = false;
            }
        } else {
            $videoError = "Only video files (MP4, AVI, MOV, MKV) are allowed.";
            $isValid = false;
        }
    } elseif (!empty($_POST["video_lecture"])) {
        $videoLectureUrl = trim($_POST["video_lecture"]);
        if (filter_var($videoLectureUrl, FILTER_VALIDATE_URL)) {
            $videoLecture = $videoLectureUrl;
        } else {
            $videoError = "Invalid video URL format.";
            $isValid = false;
        }
    } else {
        $videoError = "Please provide either a video file or a video URL.";
        $isValid = false;
    }

    // Insert data if valid
    if ($isValid) {
        $insert = "INSERT INTO course_tbl (class, instructor_id, class_id, subject, course_title, course_desc, pdf1, video_lecture, price) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $insert);
        mysqli_stmt_bind_param($stmt, "siissssss", $class, $instructor_id, $class_id, $subject, $courseTitle, $courseDesc, $pdfPath, $videoLecture, $coursePrice);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Course inserted successfully!'); window.location.href='add_course.php';</script>";
            // Reset variables after successful insert
            $class = $instructor_id = $class_id = $subject = $courseTitle = $courseDesc = $coursePrice = "";
            $pdfPath = $videoLecture = "";
        } else {
            echo "Database Error: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<?php 
// Fetch class data from the database
$classQuery = "SELECT class FROM class_tbl";
$classResult = mysqli_query($conn, $classQuery);
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

<?php
// Fetch instructor data from the database
$instructorQuery = "SELECT instructor_id FROM instructor_tbl";
$instructorResult = mysqli_query($conn, $instructorQuery);
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
</div>
      <!-- End Sidebar -->

      <div class="main-panel">
        <?php include 'navbar.php';?>

        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Add Course</h3>
              <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                  <a href="index.php">
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
                  <a href="#">Add Course</a>
                </li>
              </ul>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                      <div class="card-title">Add Course Details</div>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-6 col-lg-4">
                          <!-- Class Selection -->
                          <div class="form-group">
                            <label for="class1">Class</label>
                            <select class="form-control" id="class1" name="class">
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
                            <span style="color: red;"><?php echo $classError; ?></span>
                          </div>

                          <!-- Instructor ID -->
                          <div class="form-group">
                            <label for="instructor_id1">Instructor ID</label>
                            <select class="form-control" id="instructor_id1" name="instructor_id">
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
                            <span style="color: red;"><?php echo $instructorError; ?></span>
                          </div>

                          <!-- Class ID -->
                          <div class="form-group">
                            <label for="class_id1">Class ID</label>
                            <select class="form-control" id="class_id1" name="class_id">
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
                            <span style="color: red;"><?php echo $classIdError; ?></span>                                          
                          </div>

                          <!-- Subject -->
                          <div class="form-group">
                            <label for="sub1">Subject</label>
                            <select class="form-control" id="sub1" name="subject">
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
                            <span style="color: red;"><?php echo $subjectError; ?></span>
                          </div>

                          <!-- Course Title -->
                          <div class="form-group">
                            <label for="course_title1">Course Title</label>
                            <input type="text" class="form-control" id="course_title1" name="course_title" placeholder="Enter Course Title" value="<?php echo htmlspecialchars($courseTitle); ?>" />
                            <span style="color: red;"><?php echo $courseTitleError; ?></span>
                          </div>

                          <!-- Course Description -->
                          <div class="form-group">
                            <label for="course_desc1">Course Description</label>
                            <textarea class="form-control" id="course_desc1" name="course_desc" placeholder="Enter Course Description" rows="4"><?php echo htmlspecialchars($courseDesc); ?></textarea>
                            <span style="color: red;" id="courseDescError"><?php echo $courseDescError; ?></span>
                          </div>

                          <!-- PDF Upload -->
                          <div class="form-group">
                            <label for="pdfFile">Upload PDF</label>
                            <input type="file" class="form-control" id="pdfFile" name="pdfFile" accept=".pdf" />
                            <small class="text-muted d-block">Accepted format: PDF</small>
                            <span style="color: red;"><?php echo $pdfPathError; ?></span>
                          </div>

                          <!-- Video Lecture -->
                          <div class="form-group">
                            <label for="video_lecture">Video Lecture URL</label>
                            <input type="url" class="form-control" id="video_lecture" name="video_lecture" placeholder="Enter Video Lecture URL" value="<?php echo htmlspecialchars(isset($videoLecture) ? $videoLecture : ''); ?>" />
                            <small class="text-muted">Provide a valid URL for the video lecture.</small><br>
                            <span style="color: red;"><?php echo $videoError; ?></span>
                          </div>

                          <!-- <div class="form-group">
                            <label for="videoFile">Upload Video File</label>
                            <input type="file" class="form-control" id="videoFile" name="videoFile" accept="video/*" />
                            <small class="text-muted">Accepted formats: MP4, AVI, MOV, MKV.</small><br>
                            <span style="color: red;"><?php echo $videoError; ?></span>
                          </div> -->

                          <!-- Course Price -->
                          <div class="form-group">
                            <label for="course_price1">Course Price</label>
                            <input type="number" class="form-control" id="course_price1" name="course_price" placeholder="Enter Course Price" min="1" step="any" value="<?php echo htmlspecialchars($coursePrice); ?>" />
                            <span style="color: red;"><?php echo $coursePriceError; ?></span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="card-action">
                      <button class="btn btn-success me-3" name="btn">Submit</button>
                      <button type="reset" class="btn btn-danger me-3" onclick="window.location.href = 'add_course.php';">Cancel</button>
                      <button type="button" class="btn btn-primary me-3" onclick="window.location.href = 'add_lesson.php';">Next</button>
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
    <script>
    document.getElementById("course_desc").addEventListener("input", function () {
        let errorMsg = document.getElementById("courseDescError");
        if (this.value.trim() === "") {
            errorMsg.textContent = "Course Description is required.";
        } else {
            errorMsg.textContent = "";
        }
    });
    </script>
    <!--   Core JS Files   -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      // Function to handle saving class details
      function saveClass() {
          const classId = document.getElementById("class_id").value;
          const className = document.getElementById("class1").value.trim();

          if (!className) {
              alert("Please enter a class name.");
              return;
          }

          // Send data to the server using AJAX (modify as per your backend)
          const formData = new FormData();
          formData.append("class_id", classId);
          formData.append("class", className);

          fetch("update_class.php", {
              method: "POST",
              body: formData
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  alert("Class details updated successfully!");
                  location.reload(); // Reload page to reflect changes
              } else {
                  alert("Error updating class: " + data.message);
              }
          })
          .catch(error => {
              console.error("Error:", error);
              alert("An error occurred while updating class.");
          });
      }

      // Function to populate modal with class details for editing
      function editClass(classId, className) {
          document.getElementById("class_id").value = classId;
          document.getElementById("class1").value = className;
          var modal = new bootstrap.Modal(document.getElementById("exampleModal"));
          modal.show();
      }
    </script>
    <script>
      function previewVideo() {
        let videoUrl = document.getElementById("video_url").value;
        let videoPreviewContainer = document.getElementById("videoPreviewContainer");
        let videoPreview = document.getElementById("videoPreview");

        if (videoUrl.includes("youtube.com") || videoUrl.includes("youtu.be")) {
            let videoId = videoUrl.split("v=")[1]?.split("&")[0] || videoUrl.split("youtu.be/")[1]?.split("?")[0];
            videoPreview.innerHTML = `<iframe width="100%" height="250" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allowfullscreen></iframe>`;
            videoPreviewContainer.style.display = "block";
        } else if (videoUrl.includes("vimeo.com")) {
            let videoId = videoUrl.split("vimeo.com/")[1]?.split("?")[0];
            videoPreview.innerHTML = `<iframe width="100%" height="250" src="https://player.vimeo.com/video/${videoId}" frameborder="0" allowfullscreen></iframe>`;
            videoPreviewContainer.style.display = "block";
        } else {
            videoPreview.innerHTML = "";
            videoPreviewContainer.style.display = "none";
        }
      }
    </script>
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

    <!-- Chart Circle -->
    <script src="assets/js/plugin/chart-circle/circles.min.js"></script>

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
    <script>
      $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#177dff",
        fillColor: "rgba(23, 125, 255, 0.14)",
      });

      $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#f3545d",
        fillColor: "rgba(243, 84, 93, .14)",
      });

      $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#ffa534",
        fillColor: "rgba(255, 165, 52, .14)",
      });
    </script>
     </body>
</html>
