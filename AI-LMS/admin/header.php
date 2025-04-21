<div class="main-panel">
        <?php include 'navbar.php';?>

        <div class="container">
          <div class="page-inner">
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div>
                <h3 class="fw-bold mb-3">Dashboard</h3>
                
              </div>
              
            </div>
            <div class="row">
              <div class="row justify-content-center">
                  <div class="col-md-14 col-lg-12 col-xl-12">
                      <div class="card">
                          <div class="profile-container d-flex align-items-center p-4 shadow-lg rounded bg-white">
                              <!-- Profile Image -->
                              <img src="assets/img/user.avif" alt="Admin Profile" class="profile-img me-4">

                              <!-- Profile Info -->
                              <div class="profile-info">
                                  <h3 class="text-teal fw-bold">Hello, <?php echo htmlspecialchars($admin['username']); ?>!</h3>
                                  <p class="text-muted">
                                      <i class="fas fa-envelope text-teal me-2"></i>Email: 
                                      <strong><?php echo htmlspecialchars($admin['email']); ?></strong>
                                  </p>                            
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              <!-- Students Card (Blue) -->
              <div class="col-sm-6 col-md-3">
                  <div class="card card-stats card-round">
                      <div class="card-body">
                          <div class="row align-items-center">
                              <div class="col-icon">
                                  <div class="icon-big text-center icon-primary bubble-shadow-small">
                                      <i class="fas fa-user-graduate"></i>
                                  </div>
                              </div>
                              <div class="col col-stats ms-3 ms-sm-0">
                                  <div class="numbers">
                                      <p class="card-category">Students</p>
                                      <h4 class="card-title"><?php echo number_format($total_students); ?></h4>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              <!-- Courses Card (Green) -->
              <div class="col-sm-6 col-md-3">
                  <div class="card card-stats card-round">
                      <div class="card-body">
                          <div class="row align-items-center">
                              <div class="col-icon">
                                  <div class="icon-big text-center icon-success bubble-shadow-small">
                                      <i class="fas fa-book-open"></i>
                                  </div>
                              </div>
                              <div class="col col-stats ms-3 ms-sm-0">
                                  <div class="numbers">
                                      <p class="card-category">Courses</p>
                                      <h4 class="card-title"><?php echo number_format($total_courses); ?></h4>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              <!-- Classes Card (Red) -->
              <div class="col-sm-6 col-md-3">
                  <div class="card card-stats card-round">
                      <div class="card-body">
                          <div class="row align-items-center">
                              <div class="col-icon">
                                  <div class="icon-big text-center icon-danger bubble-shadow-small">
                                      <i class="fas fa-chalkboard"></i> <!-- Class Icon -->
                                  </div>
                              </div>
                              <div class="col col-stats ms-3 ms-sm-0">
                                  <div class="numbers">
                                      <p class="card-category">Classes</p>
                                      <h4 class="card-title"><?php echo number_format($total_classes); ?></h4>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              <!-- Instructors Card (Orange) -->
              <div class="col-sm-6 col-md-3">
                  <div class="card card-stats card-round">
                      <div class="card-body">
                          <div class="row align-items-center">
                              <div class="col-icon">
                                  <div class="icon-big text-center icon-warning bubble-shadow-small">
                                      <i class="fas fa-chalkboard-teacher"></i> 
                                  </div>
                              </div>
                              <div class="col col-stats ms-3 ms-sm-0">
                                  <div class="numbers">
                                      <p class="card-category">Instructors</p>
                                      <h4 class="card-title"><?php echo number_format($total_instructors); ?></h4>
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