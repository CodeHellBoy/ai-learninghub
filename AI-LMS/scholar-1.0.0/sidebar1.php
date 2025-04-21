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
              <li class="nav-item active">
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
              <li class="nav-item ">
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
                        <span class="sub-item">Add User-feedback</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>

            </ul>
          </div>
        </div>
</div>
