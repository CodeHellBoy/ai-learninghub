<div class="main-header">
          <div class="main-header-logo">
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
          <!-- Navbar Header -->
          <nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
          >
            <div class="container-fluid">
              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                  <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" aria-haspopup="true">
                    <i class="fa fa-search"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-search animated fadeIn">
                    <form class="navbar-left navbar-form nav-search">
                      <div class="input-group">
                        <input type="text" placeholder="Search ..." class="form-control" />
                      </div>
                    </form>
                  </ul>
                </li>

                <!-- Compiler Icon -->
                <li class="nav-item topbar-icon">
                  <a class="nav-link" href="#" onclick="toggleCompilerPopup()">
                  <i class="fa fa-code"></i>
                  </a>
                </li>

                <!-- Compiler Popup -->
                <div id="compiler-popup" class="compiler-popup" style="
                  position: fixed; 
                  top: 0; 
                  left: 0; 
                  width: 100%; 
                  height: 100%; 
                  background: rgba(0, 0, 0, 0.8); 
                  display: flex; 
                  align-items: center; 
                  justify-content: center; 
                  visibility: hidden; 
                  opacity: 0; 
                  transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
                  z-index: 9998; /* Ensure it is below the sidebar */
                ">
                  <div style="
                  width: 60%; 
                  height: 90%; 
                  background: #ffffff; 
                  border-radius: 12px; 
                  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); 
                  overflow: hidden;">
                  <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px; background: #1e293b; color: white;">
                    <h4 style="margin: 0;">AI LMS Online Compiler</h4>
                  <button onclick="toggleCompilerPopup()" style="background: none; border: none; color: white; font-size: 18px; cursor: pointer;">&times;</button>
                  </div>
                  <iframe
                  frameBorder="0"
                  height="100%"
                  src="https://onecompiler.com/embed/"
                  width="100%"
                  style="border: none;">
                  </iframe>
                  </div>
                </div>

                <script>
                  function toggleCompilerPopup() {
                  var compilerPopup = document.getElementById("compiler-popup");

                  if (compilerPopup.style.visibility === "hidden" || compilerPopup.style.visibility === "") {
                  compilerPopup.style.visibility = "visible";
                  compilerPopup.style.opacity = "1";
                  } else {
                  compilerPopup.style.opacity = "0";
                  setTimeout(() => {
                  compilerPopup.style.visibility = "hidden";
                  }, 300); // Matches transition time
                  }
                  }
                </script>
                <!-- End Compiler Icon -->
                
                <!-- Chatbot Icon -->
                <li class="nav-item topbar-icon">
                  <a class="nav-link" href="#" onclick="toggleChatbotPopup()">
                    <i class="fa fa-robot"></i>
                  </a>
                </li>
                <!-- End Chatbot Icon -->
                
                  <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                        <div class="avatar-sm">
                            <img src="<?php echo $profile_img; ?>" alt="User Profile" class="avatar-img rounded-circle" />
                        </div>
                        <span class="profile-username">
                            <span class="op-7">Hi,</span>
                            <span class="fw-bold"><?php echo htmlspecialchars($user['username']); ?></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    <div class="avatar-lg">
                                        <img src="<?php echo $profile_img; ?>" alt="User Profile" class="avatar-img rounded" />
                                    </div>
                                    <div class="u-text">
                                        <h4><?php echo htmlspecialchars($user['username']); ?></h4>
                                        <p class="text-muted"><?php echo htmlspecialchars($user['email']); ?></p>
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
        
        <!-- Chatbot Icon (Floating Button) -->
<!-- Chatbot Icon -->
<div id="chatbot-icon" onclick="toggleChatbotPopup()" style="
        position: fixed; 
        bottom: 20px; 
        right: 20px; 
        width: 60px; 
        height: 60px; 
        background: #10b981; 
        border-radius: 50%; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); 
        cursor: pointer; 
        transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        z-index: 9999;">
        <span style="color: white; font-size: 24px;">💬</span>
    </div>

<!-- Chatbot Popup -->
<div id="chatbot-popup" class="chatbot-popup" style="
    position: fixed; 
    bottom: 80px; 
    right: 20px; 
    width: 350px; 
    height: 550px; /* Fixed height to prevent scrolling */
    background: #1e293b; 
    padding: 15px; 
    border-radius: 12px; 
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); 
    transform: translateY(20px) scale(0.8); 
    opacity: 0; 
    visibility: hidden;
    transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
    overflow: hidden; /* Prevent scrolling */">
    
    <!-- Chatbot Header -->
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h4 style="color: white; margin: 0;">AI LMS Chatbot</h4>
        <div>
            <button onclick="toggleChatbotPopup()" style="background: none; border: none; color: white; font-size: 18px; cursor: pointer;">&times;</button>
        </div>
    </div>

    <!-- Chatbot Frame -->
    <iframe id="chatbot-frame" src="chatbot.php" width="100%" height="500px" style="border: none;"></iframe>
</div>

<script>
    function toggleChatbotPopup() {
        var chatbotPopup = document.getElementById("chatbot-popup");
        var chatbotIcon = document.getElementById("chatbot-icon");

        if (chatbotPopup.style.visibility === "hidden" || chatbotPopup.style.visibility === "") {
            chatbotPopup.style.visibility = "visible";
            chatbotPopup.style.opacity = "1";
            chatbotPopup.style.transform = "translateY(0) scale(1)";
            chatbotIcon.style.opacity = "0"; // Hide button smoothly
        } else {
            chatbotPopup.style.opacity = "0";
            chatbotPopup.style.transform = "translateY(20px) scale(0.8)";
            setTimeout(() => {
                chatbotPopup.style.visibility = "hidden";
                chatbotIcon.style.opacity = "1"; // Restore button after closing
            }, 300); // Matches transition time
        }
    }

    function clearChat() {
        var chatbotFrame = document.getElementById("chatbot-frame");
        chatbotFrame.src = "chatbot.php"; // Reloads chatbot to clear chat history
    }
</script>
