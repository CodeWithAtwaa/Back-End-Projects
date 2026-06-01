<?php
$user = current_user();
$role = user_role();
$userName = $user['user_name'] ?? 'Guest';
$isStaff = is_staff();
$header = $role === 'Professor' ? 'Professor Dashboard' : 'Dashboard';
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$isAuthenticated = isset($_SESSION['user']);
$dashboardPages = [
  '/dashboard',
  '/show-student',
  '/edit-student',
  '/deactivate-student',
  '/delete-student',
  '/show-professor',
  '/edit-professor',
  '/delete-professor',
  '/show-course',
  '/edit-course',
  '/delete-course',
  '/show-assignment',
  '/edit-assignment',
  '/delete-assignment',
];

if ($isStaff && in_array($request, $dashboardPages, true)) {
?>
  <!-- Enhanced Dashboard Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark hogwarts-dashboard-navbar">
    <div class="container-fluid">
      <!-- Dashboard Brand -->
      <a class="navbar-brand dashboard-brand" href="/dashboard">
        <i class="fa-solid fa-chart-bar me-2"></i>
        <span class="brand-text"><?php echo $header; ?></span>
        <span class="brand-subtitle">Management Portal</span>
      </a>

      <!-- Mobile Toggle -->
      <button class="navbar-toggler magical-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        <span class="toggler-magic"></span>
      </button>

      <!-- Welcome Message -->
      <div class="welcome-message d-none d-lg-block">
        <i class="fa-solid fa-wand-magic-sparkles me-2"></i>
        <span>Welcome to the Hogwarts Management Portal</span>
      </div>

      <!-- Navigation Menu -->
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav mx-auto">
          <!-- Home Link -->
          <a class="nav-link magical-link" href="/">
            <i class="fa-solid fa-house-chimney me-1"></i>
            <span>Home</span>
          </a>

          <a class="nav-link magical-link" href="/classrooms">
            <i class="fa-solid fa-chalkboard me-1"></i>
            <span>Classrooms</span>
          </a>
        </div>

        <!-- User Section -->
        <div class="navbar-nav ms-auto">
          <div class="user-info">
            <!-- User Avatar Placeholder -->
            <div class="user-avatar">
              <i class="fa-solid <?php echo $role === 'Professor' ? 'fa-chalkboard-user' : 'fa-user-tie'; ?>"></i>
            </div>
            <div class="user-details d-none d-lg-block">
              <span class="user-name"><?php echo htmlspecialchars($userName); ?></span>
              <span class="user-role"><?php echo $role === 'Professor' ? 'Professor' : 'Headmaster'; ?></span>
            </div>
          </div>

          <!-- Logout Button -->
          <a class="nav-link btn-auth logout-btn ms-3" href="/logout">
            <i class="fa-solid fa-right-from-bracket me-1"></i>
            <span>Logout</span>
          </a>
        </div>
      </div>
    </div>

    <!-- Magical Effects -->
    <div class="navbar-magic-effects">
      <div class="magic-sparkle sparkle-1"></div>
      <div class="magic-sparkle sparkle-2"></div>
      <div class="magic-sparkle sparkle-3"></div>
    </div>
  </nav>

  <style>
    /* Dashboard Navbar Styles */
    .hogwarts-dashboard-navbar {
      background: linear-gradient(135deg, #0E1A40 0%, #1A237E 30%, #0E1A40 70%, #1A237E 100%);
      backdrop-filter: blur(10px);
      border-bottom: 3px solid #946B2D;
      box-shadow: 0 6px 25px rgba(14, 26, 64, 0.4);
      position: relative;
      overflow: hidden;
      min-height: 75px;
      transition: all 0.3s ease;
    }

    .hogwarts-dashboard-navbar:hover {
      box-shadow: 0 10px 35px rgba(14, 26, 64, 0.6), 0 0 25px rgba(148, 107, 45, 0.3);
      border-bottom-color: #FFD700;
    }

    .hogwarts-dashboard-navbar::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dashboard-stars" x="0" y="0" width="25" height="25" patternUnits="userSpaceOnUse"><circle cx="3" cy="3" r="0.8" fill="%23946B2D" opacity="0.4"/><circle cx="15" cy="10" r="0.5" fill="%23946B2D" opacity="0.3"/><circle cx="22" cy="18" r="0.6" fill="%23946B2D" opacity="0.35"/><polygon points="12,2 14,8 20,8 15,12 17,18 12,14 7,18 9,12 4,8 10,8" fill="%23FFD700" opacity="0.2"/></pattern></defs><rect width="100" height="100" fill="url(%23dashboard-stars)"/></svg>');
      opacity: 0.15;
      pointer-events: none;
    }

    /* Dashboard Brand */
    .dashboard-brand {
      font-family: 'Dancing Script', cursive;
      font-size: 26px;
      font-weight: 700;
      color: #FFD700 !important;
      text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.5);
      transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      position: relative;
      z-index: 2;
      cursor: pointer;
    }

    .dashboard-brand:hover {
      color: #FFFFFF !important;
      transform: scale(1.08) translateY(-3px);
      text-shadow: 0 0 20px rgba(255, 215, 0, 0.8), 2px 2px 8px rgba(0, 0, 0, 0.6);
      filter: drop-shadow(0 0 15px rgba(255, 215, 0, 0.5));
    }

    .dashboard-brand:hover .brand-text {
      animation: enhancedShimmer 2s ease-in-out infinite;
    }

    .dashboard-brand:hover .brand-subtitle {
      color: #FFD700;
      opacity: 1;
      transform: scale(1.05);
      transition: all 0.3s ease-out;
    }

    .dashboard-brand .brand-text {
      background: linear-gradient(45deg, #FFD700, #FFFFFF, #FFD700);
      background-size: 200% 200%;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      animation: dashboardShimmer 4s ease-in-out infinite;
    }

    .dashboard-brand .brand-subtitle {
      font-family: 'Georgia', serif;
      font-size: 9px;
      color: #946B2D;
      margin-left: 8px;
      opacity: 0.9;
      letter-spacing: 0.5px;
      text-transform: uppercase;
    }

    /* Welcome Message */
    .welcome-message {
      color: #FFD700;
      font-family: 'Georgia', serif;
      font-style: italic;
      font-size: 14px;
      margin: auto 20px;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
      transition: all 0.3s ease;
      cursor: default;
    }

    .welcome-message:hover {
      color: #FFFFFF;
      text-shadow: 0 0 15px rgba(255, 215, 0, 0.8), 1px 1px 3px rgba(0, 0, 0, 0.5);
      transform: scale(1.02);
    }

    .welcome-message i {
      color: #946B2D;
      animation: magicGlow 3s ease-in-out infinite;
      transition: all 0.3s ease;
    }

    .welcome-message:hover i {
      color: #FFD700;
      transform: scale(1.2) rotate(15deg);
      filter: drop-shadow(0 0 8px rgba(255, 215, 0, 0.6));
    }

    /* User Info */
    .user-info {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .user-avatar {
      width: 45px;
      height: 45px;
      background: linear-gradient(135deg, #946B2D 0%, #7A5523 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #FFFFFF;
      border: 2px solid #FFD700;
      box-shadow: 0 2px 8px rgba(148, 107, 45, 0.3);
      transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      cursor: pointer;
      position: relative;
      overflow: hidden;
    }

    .user-avatar::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      background: radial-gradient(circle, rgba(255, 215, 0, 0.3) 0%, transparent 70%);
      border-radius: 50%;
      transform: translate(-50%, -50%);
      transition: all 0.6s ease-out;
    }

    .user-avatar:hover::before {
      width: 120px;
      height: 120px;
    }

    .user-avatar:hover {
      transform: scale(1.15) rotate(5deg);
      box-shadow: 0 6px 20px rgba(148, 107, 45, 0.6), 0 0 30px rgba(255, 215, 0, 0.4);
      border-color: #FFFFFF;
      background: linear-gradient(135deg, #FFD700 0%, #946B2D 100%);
    }

    .user-avatar:hover i {
      transform: scale(1.1) rotate(-5deg);
      transition: all 0.3s ease-out;
    }

    .user-details {
      text-align: right;
    }

    .user-name {
      display: block;
      color: #FFD700;
      font-weight: 700;
      font-size: 14px;
      margin-bottom: 2px;
    }

    .user-role {
      display: block;
      color: #946B2D;
      font-size: 11px;
      font-style: italic;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    /* Enhanced Magical Effects */
    .hogwarts-dashboard-navbar .magic-sparkle {
      width: 6px;
      height: 6px;
      background: #FFD700;
      box-shadow: 0 0 6px rgba(255, 215, 0, 0.6);
    }

    .hogwarts-dashboard-navbar .sparkle-1 {
      top: 25%;
      left: 15%;
      animation: dashboardFloat 8s infinite linear;
    }

    .hogwarts-dashboard-navbar .sparkle-2 {
      top: 55%;
      left: 75%;
      animation: dashboardFloat 8s infinite linear 2s;
    }

    .hogwarts-dashboard-navbar .sparkle-3 {
      top: 35%;
      left: 55%;
      animation: dashboardFloat 8s infinite linear 4s;
    }

    /* Dashboard Animations */
    @keyframes dashboardShimmer {
      0% {
        background-position: -200% 0;
      }

      100% {
        background-position: 200% 0;
      }
    }

    @keyframes enhancedShimmer {
      0% {
        background-position: -200% 0;
        filter: brightness(1);
      }

      50% {
        filter: brightness(1.3) contrast(1.1);
      }

      100% {
        background-position: 200% 0;
        filter: brightness(1);
      }
    }

    @keyframes magicGlow {

      0%,
      100% {
        opacity: 0.7;
        transform: scale(1);
        filter: brightness(1);
      }

      50% {
        opacity: 1;
        transform: scale(1.15);
        filter: brightness(1.2) drop-shadow(0 0 8px rgba(255, 215, 0, 0.6));
      }
    }

    @keyframes dashboardFloat {
      0% {
        transform: translateY(0px) rotate(0deg) scale(1);
        opacity: 0;
        filter: blur(0px);
      }

      10% {
        opacity: 1;
        filter: blur(0px);
      }

      50% {
        filter: blur(1px);
      }

      90% {
        opacity: 1;
        filter: blur(0px);
      }

      100% {
        transform: translateY(-120px) rotate(360deg) scale(0.8);
        opacity: 0;
        filter: blur(2px);
      }
    }

    /* Dashboard Responsive */
    @media (max-width: 991.98px) {
      .hogwarts-dashboard-navbar {
        padding: 10px 0;
      }

      .dashboard-brand {
        font-size: 22px;
      }

      .brand-subtitle {
        display: none;
      }

      .welcome-message {
        display: none;
      }

      .user-details {
        display: none !important;
      }

      .navbar-nav {
        margin-top: 15px;
      }

      .magical-link {
        text-align: center;
      }
    }

    @media (max-width: 575.98px) {
      .dashboard-brand {
        font-size: 18px;
      }

      .user-avatar {
        width: 40px;
        height: 40px;
      }

      .btn-auth {
        padding: 6px 10px;
        font-size: 13px;
      }
    }
  </style>
<?php
} else {
?>

  <!-- Enhanced Hogwarts Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark hogwarts-navbar">
    <div class="container-fluid">
      <!-- Hogwarts Brand -->
      <a class="navbar-brand hogwarts-brand" href="/">
        <i class="fa-solid fa-hat-wizard me-2"></i>
        <span class="brand-text">Hogwarts</span>
        <span class="brand-subtitle">School of Witchcraft & Wizardry</span>
      </a>

      <!-- Mobile Toggle -->
      <button class="navbar-toggler magical-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        <span class="toggler-magic"></span>
      </button>

      <!-- Navigation Menu -->
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav mx-auto">
          <!-- Home Link -->
          <a class="nav-link magical-link active" aria-current="page" href="/">
            <i class="fa-solid fa-house-chimney me-1"></i>
            <span>Home</span>
          </a>

          <!-- About Link -->
          <a class="nav-link magical-link" href="#about">
            <i class="fa-solid fa-scroll me-1"></i>
            <span>About</span>
          </a>

          <!-- Services Link -->
          <a class="nav-link magical-link" href="#services">
            <i class="fa-solid fa-wand-magic-sparkles me-1"></i>
            <span>Services</span>
          </a>

          <?php if ($isAuthenticated): ?>
            <a class="nav-link magical-link" href="/classrooms">
              <i class="fa-solid fa-chalkboard me-1"></i>
              <span>Classrooms</span>
            </a>
          <?php endif; ?>

          <?php if ($isAuthenticated && $role === 'Student'): ?>
            <a class="nav-link magical-link" href="/shop">
              <i class="fa-solid fa-cart-shopping me-1"></i>
              <span>Shop</span>
            </a>

            <a class="nav-link magical-link" href="/inventory">
              <i class="fa-solid fa-box-archive me-1"></i>
              <span>Inventory</span>
            </a>
          <?php endif; ?>

          <?php if ($role === 'Dumbledore'): ?>
            <a class="nav-link magical-link dashboard-link" href="/dashboard">
              <i class="fa-solid fa-chart-line me-1"></i>
              <span>Dumbledore Panel</span>
            </a>
          <?php endif; ?>

          <?php if ($role === 'Professor'): ?>
            <a class="nav-link magical-link dashboard-link" href="/dashboard">
              <i class="fa-solid fa-chalkboard-user me-1"></i>
              <span>Professor Dashboard</span>
            </a>
          <?php endif; ?>

          <?php if ($role === 'Student'): ?>
            <a class="nav-link magical-link" href="/student-panel">
              <i class="fa-solid fa-user-graduate me-1"></i>
              <span>Student Panel</span>
            </a>
          <?php endif; ?>
        </div>

        <!-- Auth Section -->
        <div class="navbar-nav ms-auto">
          <div class="auth-buttons">
            <?php if (isset($_SESSION['user'])): ?>
              <form action="/logout" method="POST" class="m-0">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="nav-link btn-auth logout-btn">
                  <i class="fa-solid fa-right-from-bracket me-1"></i>
                  <span>Logout</span>
                </button>
              </form>
            <?php else: ?>
              <a class="nav-link btn-auth register-btn" href="/register">
                <i class="fa-solid fa-user-plus me-1"></i>
                <span>Register</span>
              </a>
              <span class="auth-divider">|</span>
              <a class="nav-link btn-auth login-btn" href="/login">
                <i class="fa-solid fa-key me-1"></i>
                <span>Login</span>
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Magical Effects -->
    <div class="navbar-magic-effects">
      <div class="magic-sparkle sparkle-1"></div>
      <div class="magic-sparkle sparkle-2"></div>
      <div class="magic-sparkle sparkle-3"></div>
    </div>
  </nav>

  <style>
    /* Enhanced Hogwarts Navbar Styles */
    .hogwarts-navbar {
      background: linear-gradient(135deg, #0E1A40 0%, #1A237E 50%, #0E1A40 100%);
      backdrop-filter: blur(10px);
      border-bottom: 2px solid #946B2D;
      box-shadow: 0 4px 20px rgba(14, 26, 64, 0.3);
      position: relative;
      overflow: hidden;
      min-height: 70px;
      transition: all 0.3s ease;
    }

    .hogwarts-navbar:hover {
      box-shadow: 0 8px 30px rgba(14, 26, 64, 0.5), 0 0 20px rgba(148, 107, 45, 0.2);
      border-bottom-color: #FFD700;
    }

    .hogwarts-navbar::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="stars" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="2" cy="2" r="0.5" fill="%23946B2D" opacity="0.3"/><circle cx="12" cy="8" r="0.3" fill="%23946B2D" opacity="0.2"/><circle cx="18" cy="15" r="0.4" fill="%23946B2D" opacity="0.25"/></pattern></defs><rect width="100" height="100" fill="url(%23stars)"/></svg>');
      opacity: 0.1;
      pointer-events: none;
    }

    /* Brand Styling */
    .hogwarts-brand {
      font-family: 'Dancing Script', cursive;
      font-size: 28px;
      font-weight: 700;
      color: #946B2D !important;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
      transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      position: relative;
      z-index: 2;
      cursor: pointer;
    }

    .hogwarts-brand:hover {
      color: #FFD700 !important;
      transform: scale(1.08) translateY(-3px);
      text-shadow: 0 0 20px rgba(255, 215, 0, 0.8), 2px 2px 8px rgba(0, 0, 0, 0.6);
      filter: drop-shadow(0 0 15px rgba(255, 215, 0, 0.5));
    }

    .hogwarts-brand:hover .brand-text {
      animation: enhancedShimmer 2s ease-in-out infinite;
    }

    .hogwarts-brand:hover .brand-subtitle {
      color: #FFFFFF;
      opacity: 1;
      transform: scale(1.05);
      transition: all 0.3s ease-out;
    }

    .brand-text {
      background: linear-gradient(45deg, #946B2D, #FFD700, #946B2D);
      background-size: 200% 200%;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      animation: shimmer 3s ease-in-out infinite;
    }

    .brand-subtitle {
      font-family: 'Georgia', serif;
      font-size: 10px;
      color: #FFD700;
      margin-left: 8px;
      opacity: 0.8;
      letter-spacing: 0.5px;
    }

    /* Magical Toggler */
    .magical-toggler {
      border: 2px solid #946B2D;
      border-radius: 6px;
      position: relative;
      overflow: hidden;
    }

    .magical-toggler .navbar-toggler-icon {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 215, 0, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    .toggler-magic {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 20px;
      height: 20px;
      background: radial-gradient(circle, #FFD700 0%, transparent 70%);
      border-radius: 50%;
      opacity: 0;
      animation: magicPulse 2s infinite;
    }

    /* Navigation Links */
    .magical-link {
      font-family: 'Georgia', serif;
      font-weight: 600;
      color: #FFD700 !important;
      margin: 0 8px;
      padding: 8px 16px;
      border-radius: 25px;
      transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      position: relative;
      overflow: hidden;
      cursor: pointer;
    }

    .magical-link::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(148, 107, 45, 0.4), rgba(255, 215, 0, 0.3), rgba(148, 107, 45, 0.4), transparent);
      transition: left 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .magical-link::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      background: radial-gradient(circle, rgba(255, 215, 0, 0.2) 0%, transparent 70%);
      border-radius: 50%;
      transform: translate(-50%, -50%);
      transition: all 0.4s ease-out;
    }

    .magical-link:hover::before {
      left: 100%;
    }

    .magical-link:hover::after {
      width: 150px;
      height: 150px;
    }

    .magical-link:hover {
      background: rgba(148, 107, 45, 0.25);
      color: #FFFFFF !important;
      transform: translateY(-4px) scale(1.05);
      box-shadow: 0 8px 25px rgba(148, 107, 45, 0.4), 0 0 20px rgba(255, 215, 0, 0.3);
      text-shadow: 0 0 8px rgba(255, 255, 255, 0.5);
    }

    .magical-link:hover i {
      transform: scale(1.2) rotate(10deg);
      transition: all 0.3s ease-out;
      filter: drop-shadow(0 0 6px rgba(255, 215, 0, 0.8));
    }

    .magical-link.active {
      /* background: linear-gradient(135deg, #946B2D 0%, #7A5523 100%); */
      color: #FFFFFF !important;
      box-shadow: 0 6px 20px rgba(148, 107, 45, 0.5);
      transform: translateY(-2px);
    }

    .dashboard-link {
      background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
      color: #0E1A40 !important;
      font-weight: 700;
    }

    .dashboard-link:hover {
      background: linear-gradient(135deg, #FFA500 0%, #FFD700 100%);
      color: #0E1A40 !important;
    }

    /* Auth Buttons */
    .auth-buttons {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .btn-auth {
      font-family: 'Georgia', serif;
      font-weight: 600;
      padding: 8px 16px;
      border-radius: 20px;
      transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      border: 2px solid transparent;
      cursor: pointer;
      position: relative;
      overflow: hidden;
    }

    .btn-auth::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
      border-radius: 50%;
      transform: translate(-50%, -50%);
      transition: all 0.5s ease-out;
    }

    .btn-auth:hover::before {
      width: 200px;
      height: 200px;
    }

    .register-btn {
      background: linear-gradient(135deg, #946B2D 0%, #7A5523 100%);
      color: #FFFFFF !important;
    }

    .register-btn:hover {
      background: linear-gradient(135deg, #7A5523 0%, #946B2D 100%);
      transform: translateY(-4px) scale(1.08);
      box-shadow: 0 8px 25px rgba(148, 107, 45, 0.5), 0 0 20px rgba(255, 215, 0, 0.3);
      border-color: #FFD700;
    }

    .register-btn:hover i {
      transform: scale(1.2) rotate(15deg);
      transition: all 0.3s ease-out;
    }

    .login-btn {
      background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
      color: #0E1A40 !important;
      font-weight: 700;
    }

    .login-btn:hover {
      background: linear-gradient(135deg, #FFA500 0%, #FFD700 100%);
      transform: translateY(-4px) scale(1.08);
      box-shadow: 0 8px 25px rgba(255, 215, 0, 0.5), 0 0 20px rgba(255, 215, 0, 0.4);
      border-color: #0E1A40;
      color: #FFFFFF !important;
    }

    .login-btn:hover i {
      transform: scale(1.2) rotate(-15deg);
      transition: all 0.3s ease-out;
    }

    .logout-btn {
      background: linear-gradient(135deg, #FF6B6B 0%, #EE5A52 100%);
      color: #FFFFFF !important;
    }

    .logout-btn:hover {
      background: linear-gradient(135deg, #EE5A52 0%, #FF6B6B 100%);
      transform: translateY(-4px) scale(1.08);
      box-shadow: 0 8px 25px rgba(255, 107, 107, 0.5), 0 0 20px rgba(255, 107, 107, 0.4);
      border-color: #FFFFFF;
    }

    .logout-btn:hover i {
      transform: scale(1.2) rotate(180deg);
      transition: all 0.3s ease-out;
    }

    .auth-divider {
      color: #FFD700;
      font-weight: 700;
      margin: 0 4px;
    }

    /* Magical Effects */
    .navbar-magic-effects {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      pointer-events: none;
      overflow: hidden;
    }

    .magic-sparkle {
      position: absolute;
      width: 4px;
      height: 4px;
      background: #FFD700;
      border-radius: 50%;
      animation: enhancedFloat 8s infinite cubic-bezier(0.25, 0.46, 0.45, 0.94);
      box-shadow: 0 0 6px rgba(255, 215, 0, 0.8);
    }

    .sparkle-1 {
      top: 20%;
      left: 10%;
      animation-delay: 0s;
    }

    .sparkle-2 {
      top: 60%;
      left: 80%;
      animation-delay: 2.5s;
    }

    .sparkle-3 {
      top: 40%;
      left: 60%;
      animation-delay: 5s;
    }

    /* Animations */
    @keyframes shimmer {
      0% {
        background-position: -200% 0;
      }

      100% {
        background-position: 200% 0;
      }
    }

    @keyframes enhancedShimmer {
      0% {
        background-position: -200% 0;
        filter: brightness(1) saturate(1);
      }

      25% {
        filter: brightness(1.2) saturate(1.3);
      }

      50% {
        filter: brightness(1.4) saturate(1.5);
      }

      75% {
        filter: brightness(1.2) saturate(1.3);
      }

      100% {
        background-position: 200% 0;
        filter: brightness(1) saturate(1);
      }
    }

    @keyframes magicPulse {

      0%,
      100% {
        opacity: 0;
        transform: translate(-50%, -50%) scale(0.8);
        filter: blur(1px);
      }

      50% {
        opacity: 0.8;
        transform: translate(-50%, -50%) scale(1.3);
        filter: blur(0px) drop-shadow(0 0 10px rgba(255, 215, 0, 0.6));
      }
    }

    @keyframes float {
      0% {
        transform: translateY(0px) rotate(0deg);
        opacity: 0;
        filter: blur(1px);
      }

      10% {
        opacity: 1;
        filter: blur(0px);
      }

      50% {
        transform: translateY(-50px) rotate(180deg) scale(1.2);
        filter: blur(0.5px);
      }

      90% {
        opacity: 1;
        filter: blur(0px);
      }

      100% {
        transform: translateY(-100px) rotate(360deg) scale(0.8);
        opacity: 0;
        filter: blur(2px);
      }
    }

    @keyframes enhancedFloat {
      0% {
        transform: translateY(0px) rotate(0deg) scale(1);
        opacity: 0;
        filter: blur(2px) brightness(0.5);
      }

      5% {
        opacity: 0.3;
        filter: blur(1px) brightness(0.7);
      }

      10% {
        opacity: 1;
        filter: blur(0px) brightness(1);
      }

      25% {
        transform: translateY(-25px) rotate(90deg) scale(1.1);
        filter: brightness(1.2);
      }

      50% {
        transform: translateY(-50px) rotate(180deg) scale(1.3);
        filter: brightness(1.5) drop-shadow(0 0 8px rgba(255, 215, 0, 0.8));
      }

      75% {
        transform: translateY(-75px) rotate(270deg) scale(1.1);
        filter: brightness(1.2);
      }

      90% {
        opacity: 1;
        filter: blur(0px) brightness(1);
      }

      95% {
        opacity: 0.3;
        filter: blur(1px) brightness(0.7);
      }

      100% {
        transform: translateY(-100px) rotate(360deg) scale(0.8);
        opacity: 0;
        filter: blur(2px) brightness(0.5);
      }
    }

    /* Responsive Design */
    @media (max-width: 991.98px) {
      .hogwarts-navbar {
        padding: 8px 0;
      }

      .hogwarts-brand {
        font-size: 24px;
      }

      .brand-subtitle {
        display: none;
      }

      .navbar-nav {
        margin-top: 15px;
      }

      .magical-link {
        margin: 4px 0;
        text-align: center;
      }

      .auth-buttons {
        justify-content: center;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid rgba(148, 107, 45, 0.3);
      }

      .auth-divider {
        display: none;
      }
    }

    @media (max-width: 575.98px) {
      .hogwarts-brand {
        font-size: 20px;
      }

      .btn-auth {
        padding: 6px 12px;
        font-size: 14px;
      }

      .magical-link {
        padding: 6px 12px;
        font-size: 14px;
      }
    }
  </style>
<?php
}
?>
