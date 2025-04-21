<div class="main-panel">
       <?php include 'navbar1.php'; ?>

        <div class="container">
          <div class="page-inner">
          <div class="d-flex flex-column flex-md-row align-items-md-center pt-2 pb-4"></div>

            <div class="row justify-content-center">
                <div class="col-md-14 col-lg-12 col-xl-12">
                    <div class="card border-0 shadow-sm p-4 rounded-4">
                        
                        <!-- Profile Section -->
                        <div class="profile-container d-flex align-items-center p-4 shadow-sm rounded-3 bg-white">
                            <img src="img/user.avif" alt="User Profile" class="profile-img me-4 rounded-circle border border-2 border-primary" style="width: 80px; height: 80px;">
                            <div class="profile-info">
                                <h3 class="text-primary fw-bold mb-1">Hello, <?php echo htmlspecialchars($user['username']); ?>!</h3>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-envelope text-primary me-2"></i> 
                                    Email: <strong><?php echo htmlspecialchars($user['email']); ?></strong>
                                </p>                            
                            </div>
                        </div>

                        <!-- Instructions Section -->
                        <div class="mt-4">
                            <div class="card p-4 shadow-sm rounded-4 border-0" style="background-color: #e3f2fd;">
                                <h4 class="mb-3 text-primary d-flex align-items-center">
                                    <i class="fas fa-info-circle me-2"></i> How to Use This Page
                                </h4>
                                
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <i class="fas fa-user-graduate text-primary me-2"></i> 
                                        View your <strong>profile information</strong> at the top.
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-book-open text-primary me-2"></i> 
                                        Check your <strong>most recent lessons</strong> below.
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-play-circle text-primary me-2"></i> 
                                        Click on a lesson to <strong>review content</strong>.
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-comment-dots text-primary me-2"></i> 
                                        Interact with the <strong>AI chatbot</strong> for help.
                                    </li>
                                    <li>
                                        <i class="fas fa-question-circle text-primary me-2"></i> 
                                        Need help? Click on the <strong>Help</strong> link in the footer.
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            </div>
              <?php


              // Ensure user is logged in
              if (!isset($_SESSION['user_id'])) {
                  header("Location: index.php");
                  exit();
              }

              $user_id = $_SESSION['user_id']; // Get logged-in user ID

              // Fetch lessons specific to the logged-in user
              $query = "SELECT lesson_id, lesson_name, content, created_at 
                        FROM lesson_tbl 
                        WHERE user_id = ? 
                        ORDER BY created_at DESC LIMIT 5";

              $stmt = mysqli_prepare($conn, $query);
              mysqli_stmt_bind_param($stmt, "i", $user_id);
              mysqli_stmt_execute($stmt);
              $result = mysqli_stmt_get_result($stmt);
              ?>

              <!-- Recent Lessons -->
              <div class="row mt-4">
                  <div class="col-md-14 col-lg-12 col-xl-12">
                      <div class="card p-4 shadow-sm rounded-4 border-0" style="background-color: #f9f9f9;">
                          <h4 class="mb-3 text-primary d-flex align-items-center">
                              <i class="fas fa-book me-2"></i> Recent Lessons
                          </h4>
                          
                          <div class="row g-3">
                              <?php
                              if (mysqli_num_rows($result) > 0) {
                                  while ($row = mysqli_fetch_assoc($result)) {
                                      ?>
                                      <div class="col-md-6 col-lg-4">
                                          <div class="card p-3 shadow-sm rounded-3 border-0 bg-white h-100">
                                              <h5 class="text-dark fw-bold"><?php echo htmlspecialchars($row['lesson_name']); ?></h5>
                                              <p class="text-muted small"><?php echo substr($row['content'], 0, 80); ?>...</p>
                                              <div class="d-flex justify-content-between align-items-center text-secondary small">
                                                  <span><i class="far fa-calendar-alt"></i> <?php echo date("F j, Y", strtotime($row['created_at'])); ?></span>
                                                  
                                              </div>
                                          </div>
                                      </div>
                                      <?php
                                  }
                              } else {
                                  echo "<div class='col-12 text-center text-muted py-3'>
                                          <i class='fas fa-exclamation-circle'></i> No lessons available
                                        </div>";
                              }
                              ?>
                          </div>
                      </div>
                  </div>
              </div>

              <!-- FontAwesome Icons -->
              <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">



            
          </div>
        </div>

        <footer class="footer bg-light text-center py-3">
          <div class="container">
            <div class="row">
              <div class="col-md-6 text-md-start">
                <p class="mb-0">
                  <strong>Learning Hub</strong> © 2025 | Empowered by AI for smarter learning.
                </p>
              </div>
              <div class="col-md-6 text-md-end">
                <a href="#" class="text-decoration-none me-3">Help</a>
                <a href="#" class="text-decoration-none me-3">Privacy Policy</a>
                <a href="#" class="text-decoration-none">Contact Us</a>
              </div>
            </div>
          </div>
        </footer>

      </div>
