<div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="admin_dashboard.php" class="logo">
                <!-- <img
                  src="assets/img/kaiadmin/logo_light.svg"
                  alt="navbar brand"
                  class="navbar-brand"
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
          <!-- Navbar Header -->
          <nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
          >
            <div class="container-fluid">
              

              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li
                  class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none"
                >
                  <a
                    class="nav-link dropdown-toggle"
                    data-bs-toggle="dropdown"
                    href="#"
                    role="button"
                    aria-expanded="false"
                    aria-haspopup="true"
                  >
                    <i class="fa fa-search"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-search animated fadeIn">
                    <form class="navbar-left navbar-form nav-search">
                      <div class="input-group">
                        <input
                          type="text"
                          placeholder="Search ..."
                          class="form-control"
                        />
                      </div>
                    </form>
                  </ul>
                </li>

                <li class="nav-item topbar-user dropdown hidden-caret">
                  <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                      <div class="avatar-sm">
                          <img src="<?php echo $profile_img; ?>" alt="Admin Profile" class="avatar-img rounded-circle" />
                      </div>
                      <span class="profile-username">
                          <span class="op-7">Hi,</span>
                          <span class="fw-bold"><?php echo htmlspecialchars($admin['username']); ?></span>
                      </span>
                  </a>
                  <ul class="dropdown-menu dropdown-user animated fadeIn">
                      <div class="dropdown-user-scroll scrollbar-outer">
                          <li>
                              <div class="user-box">
                                  <div class="avatar-lg">
                                      <img src="<?php echo $profile_img; ?>" alt="Admin Profile" class="avatar-img rounded" />
                                  </div>
                                  <div class="u-text">
                                      <h4><?php echo htmlspecialchars($admin['username']); ?></h4>
                                      <p class="text-muted"><?php echo htmlspecialchars($admin['email']); ?></p>
                                      <a href="profile.php" class="btn btn-xs btn-secondary btn-sm">View Profile</a>
                                  </div>
                              </div>
                          </li>
                          <li>
                          <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="profile.php">
                                  <i class="fa fa-user me-4"></i>My Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">
                                  <i class="fa fa-sign-out-alt me-4"></i> Logout
                                </a>
                          </li>
                      </div>
                  </ul>
                </li>

              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>