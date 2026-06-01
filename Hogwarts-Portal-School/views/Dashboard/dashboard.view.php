<?php
include(base_path('views/partials/header.view.php'));

$canManageAcademic = is_dumbledore();
$canCreateProfessor = is_dumbledore();
$professorActionVerb = $canCreateProfessor ? 'Manage' : 'View';
?>

<div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h3 class="sidebar-title">Hogwarts</h3>
        </div>
        <nav class="sidebar-nav">
            <a href="#dashboard" class="sidebar-link active" data-section="dashboard">
                <i class="fa-solid fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
            <a href="#students" class="sidebar-link" data-section="students">
                <i class="fa-solid fa-users"></i>
                <span>Students</span>
            </a>
            <a href="#courses" class="sidebar-link" data-section="courses">
                <i class="fa-solid fa-book"></i>
                <span>Courses</span>
            </a>
            <a href="#professors" class="sidebar-link" data-section="professors">
                <i class="fa-solid fa-chalkboard-user"></i>
                <span>Professors</span>
            </a>
            <a href="/classrooms" class="sidebar-link">
                <i class="fa-solid fa-chalkboard"></i>
                <span>Classrooms</span>
            </a>
            <a href="/leaderboard" class="sidebar-link">
                <i class="fa-solid fa-trophy"></i>
                <span>Leaderboard</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <h2 id="page-title">Dashboard Overview</h2>
            <div class="top-bar-actions">
                <a href="/" class="btn btn-bronze">Go home</a>
                <a href="/logout" class="btn btn-bronze">Logout</a>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <!-- Dashboard Overview Section -->
            <section id="dashboard-section" class="dashboard-section active">
                <h3 class="section-title">Dashboard Overview</h3>
                <p class="section-date">Current term: <?php echo date('F Y'); ?></p>

                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon enrolled"><?php echo $stats['active_students']; ?></div>
                        <p class="stat-label">Enrolled Students</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon professors"><?php echo $stats['total_professors']; ?></div>
                        <p class="stat-label">Professors</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon submissions"><?php echo $stats['total_submissions']; ?></div>
                        <p class="stat-label">Submissions</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon points"><?php echo number_format($stats['house_points']); ?></div>
                        <p class="stat-label">Total House Points</p>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions">
                    <button class="btn btn-submit" onclick="showSection('students')">
                        <i class="fa-solid fa-users"></i> View Students
                    </button>
                    <button class="btn btn-submit" onclick="showSection('courses')">
                        <i class="fa-solid fa-book"></i> View Courses
                    </button>
                    <button class="btn btn-submit" onclick="showSection('professors')">
                        <i class="fa-solid fa-chalkboard-user"></i> <?php echo $professorActionVerb; ?> Professors
                    </button>
                    <a class="btn btn-submit" href="/classrooms">
                        <i class="fa-solid fa-chalkboard"></i> Open Classrooms
                    </a>
                </div>
            </section>

            <!-- Students Preview Section -->
            <section id="students-section" class="dashboard-section">
                <h3 class="section-title">
                    <i class="fa-solid fa-users"></i> Students Preview
                </h3>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon enrolled"><?php echo $stats['total_students']; ?></div>
                        <p class="stat-label">Total Students</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon active"><?php echo $stats['active_students']; ?></div>
                        <p class="stat-label">Active Students</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon submissions"><?php echo $stats['inactive_students']; ?></div>
                        <p class="stat-label">Inactive Students</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon courses"><?php echo $stats['total_enrollments']; ?></div>
                        <p class="stat-label">Total Enrollments</p>
                    </div>
                </div>

                <div class="table-container">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>House</th>
                                <th>Balance</th>
                                <th>Wand</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($Students)): ?>
                                <tr>
                                    <td colspan="8">No students found.</td>
                                </tr>
                            <?php endif; ?>
                            <?php foreach ($Students as $std): ?>
                                <tr>
                                    <td><?php echo $std['student_id']; ?></td>
                                    <td><?php echo htmlspecialchars($std['user_name']); ?></td>
                                    <td><?php echo htmlspecialchars($std['user_email']); ?></td>
                                    <td><span class="house-badge <?php echo strtolower($std['house']); ?>"><?php echo htmlspecialchars($std['house']); ?></span></td>
                                    <td><?php echo number_format($std['balance'], 2); ?></td>
                                    <td><?php echo $std['wand'] ?? 'Not assigned'; ?></td>
                                    <td><span class="badge <?php echo strtolower($std['status']); ?>"><?php echo htmlspecialchars($std['status']); ?></span></td>
                                    <td>
                                        <a href="/show-student?id=<?php echo $std['student_id']; ?>" class="btn-action show">View</a>
                                        <?php if ($canManageAcademic): ?>
                                            <a href="/edit-student?id=<?php echo $std['student_id']; ?>" class="btn-action edit">Edit</a>
                                            <a href="/delete-student?id=<?php echo $std['student_id']; ?>" class="btn-action delete">Delete</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Courses Preview Section -->
            <section id="courses-section" class="dashboard-section">
                <h3 class="section-title">
                    <i class="fa-solid fa-book"></i> Courses Preview
                </h3>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon courses"><?php echo $stats['total_courses']; ?></div>
                        <p class="stat-label">Total Courses</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon enrolled"><?php echo $stats['total_enrollments']; ?></div>
                        <p class="stat-label">Total Enrollments</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon assignments"><?php echo $stats['total_class_assignments']; ?></div>
                        <p class="stat-label">Assignments</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon submissions"><?php echo $stats['total_submissions']; ?></div>
                        <p class="stat-label">Submissions</p>
                    </div>
                </div>

                <div class="table-container">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Course Name</th>
                                <th>Professor</th>
                                <th>Enrolled Students</th>
                                <th>Assignments</th>
                                <th>Submissions</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($Courses)): ?>
                                <tr>
                                    <td colspan="8">No courses found.</td>
                                </tr>
                            <?php endif; ?>
                            <?php foreach ($Courses as $course): ?>
                                <tr>
                                    <td><?php echo $course['course_id']; ?></td>
                                    <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                                    <td><?php echo htmlspecialchars($course['professor_name']); ?></td>
                                    <td><?php echo $course['enrolled_count']; ?></td>
                                    <td><?php echo $course['assignments_count']; ?></td>
                                    <td><?php echo $course['submissions_count']; ?></td>
                                    <td><span class="badge active">Active</span></td>
                                    <td>
                                        <a href="/show-course?id=<?php echo $course['course_id']; ?>" class="btn-action show">View</a>
                                        <?php if ($canManageAcademic): ?>
                                            <a href="/edit-course?id=<?php echo $course['course_id']; ?>" class="btn-action edit">Edit</a>
                                            <a href="/delete-course?id=<?php echo $course['course_id']; ?>" class="btn-action delete">Delete</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Professors Management Section -->
            <section id="professors-section" class="dashboard-section">
                <h3 class="section-title">
                    <i class="fa-solid fa-chalkboard-user"></i> Professors Management
                </h3>

                <!-- Professor Stats -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon professors"><?php echo $stats['total_professors']; ?></div>
                        <p class="stat-label">Total Professors</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon active"><?php echo $stats['total_professors']; ?></div>
                        <p class="stat-label">Active Professors</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon courses"><?php echo $stats['total_courses']; ?></div>
                        <p class="stat-label">Courses Teaching</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon quizzes"><?php echo $stats['total_assignments']; ?></div>
                        <p class="stat-label">Academic Work</p>
                    </div>
                </div>

                <!-- Professors Table -->
                <div class="table-container">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Courses</th>
                                <th>Students</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($Professors as $prof): ?>
                                <tr>
                                    <td><?php echo $prof['professor_id']; ?></td>
                                    <td><?php echo $prof['professor_name']; ?></td>
                                    <td><?php echo $prof['email']; ?></td>
                                    <td><?php echo $prof['courses_count']; ?></td>
                                    <td><?php echo $prof['students_count']; ?></td>
                                    <td><span class="badge active">Active</span></td>
                                    <td>
                                        <a href="/show-professor?id=<?php echo $prof['professor_id']; ?>" class="btn-action show">View</a>
                                        <?php if ($canCreateProfessor): ?>
                                            <a href="/edit-professor?id=<?php echo $prof['professor_id']; ?>" class="btn-action edit">Edit</a>
                                            <a href="/delete-professor?id=<?php echo $prof['professor_id']; ?>" class="btn-action delete">Delete</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($canCreateProfessor): ?>
                    <!-- Add New Professor Form -->
                    <div class="form-section">
                        <h4 class="form-title">
                            <i class="fa-solid fa-user-plus"></i> Add New Professor
                        </h4>
                        <form method="POST" action="/store-professor" class="enroll-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="user_name" class="form-control" placeholder="Enter professor name" required>
                            </div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Professor Display Name</label>
                                <input type="text" name="professor_name" class="form-control" placeholder="Professor name" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-submit">
                            <i class="fa-solid fa-plus"></i> Add Professor
                        </button>
                        </form>
                    </div>
                <?php endif; ?>
            </section>

        </div>
    </div>
</div>

<script>
    function showSection(sectionName) {
        const sections = document.querySelectorAll('.dashboard-section');
        sections.forEach(section => section.classList.remove('active'));

        const sidebarLinks = document.querySelectorAll('.sidebar-link');
        sidebarLinks.forEach(link => link.classList.remove('active'));

        const targetSection = document.getElementById(sectionName + '-section');
        if (targetSection) {
            targetSection.classList.add('active');
        }

        const targetLink = document.querySelector(`[data-section="${sectionName}"]`);
        if (targetLink) {
            targetLink.classList.add('active');
        }

        const titles = {
            'dashboard': 'Dashboard Overview',
            'students': 'Students Preview',
            'courses': 'Courses Preview',
            'professors': 'Professors Management'
        };
        document.getElementById('page-title').textContent = titles[sectionName] || 'Dashboard';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const sidebarLinks = document.querySelectorAll('.sidebar-link');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const section = this.getAttribute('data-section');
                if (!section) {
                    return;
                }
                e.preventDefault();
                showSection(section);
            });
        });

        const initialSection = window.location.hash.replace('#', '');
        if (['dashboard', 'students', 'courses', 'professors'].includes(initialSection)) {
            showSection(initialSection);
        }
    });
</script>

<?php
include(base_path('views/partials/footer.view.php'));
?>
