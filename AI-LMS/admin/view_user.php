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
include('connection.php');

$action = $_POST['action'] ?? '';

if ($action === 'fetch') {
    $stmt = $conn->prepare("SELECT * FROM signup WHERE id = ?");
    $stmt->bind_param("i", $_POST['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    echo json_encode($result->num_rows > 0 ? ["status" => "success", "data" => $result->fetch_assoc()] : ["status" => "error"]);
    exit();
}

if ($action === 'update') {
    $stmt = $conn->prepare("UPDATE signup SET username = ?, mob_no = ?, email = ?, class = ? WHERE id = ?");
    $stmt->bind_param("sissi", $_POST['username'], $_POST['mob_no'], $_POST['email'], $_POST['class'], $_POST['id']);
    echo $stmt->execute() ? "success" : "error";
    exit();
}
?>

<?php 
// Fetch class data from the database
$classQuery = "SELECT class FROM class_tbl";
$classResult = mysqli_query($conn, $classQuery);
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
              <li class="nav-item active">
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

      <!-- End Sidebar -->

      <div class="main-panel">
        <?php include 'navbar.php';?>

        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Register Users</h3>
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
                  <a href="#">Reg Users</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">View Users</a>
                </li>
              </ul>
            </div>
            <div class="row">
              
            <?php
include('connection.php'); // Ensure database connection

// Handle delete request
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    // 1. Delete from feedback_tbl
    mysqli_query($conn, "DELETE FROM feedback_tbl WHERE user_id = '$id'");

    // 2. Delete from instructor_tbl
    mysqli_query($conn, "DELETE FROM instructor_tbl WHERE user_id = '$id'");

    // 3. Delete from lesson_tbl
    mysqli_query($conn, "DELETE FROM lesson_tbl WHERE user_id = '$id'");

    // Add more deletions if other tables reference signup.id (like enrollments, quiz_attempts, etc.)

    // 4. Finally, delete from signup
    $delete_user = "DELETE FROM signup WHERE id = '$id'";
    if (mysqli_query($conn, $delete_user)) {
        echo "<script>alert('User and all related data deleted successfully!'); window.location.href='view_user.php';</script>";
    } else {
        echo "<script>alert('Error deleting user: " . mysqli_error($conn) . "');</script>";
    }
}
?>



            <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="d-flex align-items-center">
                      <h4 class="card-title">View Register Users Details</h4>                    
                    </div>
                  </div>
                  <div class="card-body">
                    <!-- Modal -->
                    <table class="table table-hover table-striped table-bordered text-center" id="basic-datatables">
                      <thead>
                        
                        <tr>
                          <th>ID</th>
                          <th>USERNAME</th>
                          <th>MOBILE NO</th>
                          <th>EMAIL ID</th>
                          <th>CLASS</th>
                          
                          <th>ACTION</th>                           
                        </tr>
                        
                      </thead>
                      <tbody>
                            <?php
                            
                            include('connection.php');
                            
                            $query = "select * from `signup`";
                            $result = mysqli_query($conn, $query);
                            
                            if(!$result) {
                                die("Query Failed : ".mysqli_error($conn));
                              }
                              else {
                                while($row = mysqli_fetch_assoc($result)) {
                                  echo "<tr>
                                  
                                  <td>{$row['id']}</td>
                                  <td>{$row['username']}</td>
                                  <td>{$row['mob_no']}</td>
                                  <td>{$row['email']}</td>
                                  <td>{$row['class']}</td>                                                              
                                    
                                  <td>
                                  <button type='button' class='btn btn-link btn-primary btn-md' 
                                  data-bs-toggle='modal' data-bs-target='#editUserModal'
                                  title='Edit' onclick='editUser({$row['id']})'>
                                  <i class='fa fa-edit'></i>
                                  </button>
                                  <button type='button' class='btn btn-link btn-warning btn-md' data-bs-toggle='modal' title='Delete'>
                                  <a href='view_user.php?delete_id={$row['id']}' class='btn btn-link btn-danger btn-md' 
                                      onclick='return confirm(\"Are you sure you want to delete this Register Users Details?\");'>
                                      <i class='fas fa-trash-alt'></i>
                                  </a>
                                  </button>
                                    </td>
                                    
                                  
                                    </tr>";
                                  }
                              }
                              
                            ?>
                      </tbody>
                    </table>
                          <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Class Details</h1>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <form id="editUserForm">
                                    <input type="hidden" id="id" name="id">
                                    
                                    <div class="mb-3">
                                      <label for="username1" class="form-label">Username</label>
                                      <input type="text" class="form-control" id="username1" name="username">
                                    </div>

                                    <div class="mb-3">
                                      <label for="mob_no1" class="form-label">Mobile No</label>
                                      <input type="number" class="form-control" id="mob_no1" name="mob_no" pattern="\d{10}">
                                    </div>

                                    <div class="mb-3">
                                      <label for="email1" class="form-label">Email</label>
                                      <input type="email" class="form-control" id="email1" name="email">
                                    </div>

                                    <div class="mb-3">
                                      <label for="class1">Class</label>
                                      <select class="form-control" id="class1" name="class">
                                        <option value="" disabled selected>Select Class</option>
                                        <?php
                                          while ($row = mysqli_fetch_assoc($classResult)) {
                                            echo "<option value='{$row['class']}'>{$row['class']}</option>";
                                        }
                                        ?>
                                      </select>
                                    </div>
                                    
                                  </form>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                  <button type="button" class="btn btn-primary" onclick="saveUser()">Edit Details</button>
                                </div>
                              </div>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    function editUser(userId) {
        $.ajax({
            url: 'view_user.php',
            type: 'POST',
            data: { action: 'fetch', id: userId },
            dataType: 'json',
            success: function(response) {
                if (response.status === "success") {
                    $("#id").val(response.data.id);
                    $("#username1").val(response.data.username);
                    $("#mob_no1").val(response.data.mob_no);
                    $("#email1").val(response.data.email);
                    $("#class1").val(response.data.class);
                    
                    $("#editUserModal").modal('show');  // Open modal
                } else {
                    alert("User details not found.");
                }
            },
            error: function() {
                alert("Error fetching user details.");
            }
        });
    }

    function saveUser() {
        $.ajax({
            url: 'view_user.php',
            type: 'POST',
            data: {
                action: 'update',
                id: $("#id").val(),
                username: $("#username1").val(),
                mob_no: $("#mob_no1").val(),
                email: $("#email1").val(),
                class: $("#class1").val(),
               
            },
            success: function(response) {
                if (response.trim() === "success") {
                    alert("User updated successfully!");
                    location.reload();  // Refresh page
                } else {
                    alert("Error updating user.");
                }
            }
        });
    }
    </script>

    <!--   Core JS Files   -->
    <script src="../assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <!-- Datatables -->
    <script src="../assets/js/plugin/datatables/datatables.min.js"></script>
    <!-- Kaiadmin JS -->
    <script src="../assets/js/kaiadmin.min.js"></script>
    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="../assets/js/setting-demo2.js"></script>
    <script>
      $(document).ready(function () {
        $("#basic-datatables").DataTable({});

        $("#multi-filter-select").DataTable({
          pageLength: 5,
          initComplete: function () {
            this.api()
              .columns()
              .every(function () {
                var column = this;
                var select = $(
                  '<select class="form-select"><option value=""></option></select>'
                )
                  .appendTo($(column.footer()).empty())
                  .on("change", function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column
                      .search(val ? "^" + val + "$" : "", true, false)
                      .draw();
                  });

                column
                  .data()
                  .unique()
                  .sort()
                  .each(function (d, j) {
                    select.append(
                      '<option value="' + d + '">' + d + "</option>"
                    );
                  });
              });
          },
        });

        // Add Row
        $("#add-row").DataTable({
          pageLength: 5,
        });

        var action =
          '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

        $("#addRowButton").click(function () {
          $("#add-row")
            .dataTable()
            .fnAddData([
              $("#addName").val(),
              $("#addPosition").val(),
              $("#addOffice").val(),
              action,
            ]);
          $("#addRowModal").modal("hide");
        });
      });
    </script>
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
