<?php
include(base_path('views/partials/header.view.php'));
?>

<div class="dashboard-container professor-panel">
    <aside class="sidebar">
        <div class="sidebar-header">
            <h3 class="sidebar-title">Professor Panel</h3>
        </div>
        <nav class="sidebar-nav">
            <a href="#overview" class="sidebar-link active" data-section="overview">
                <i class="fa-solid fa-chart-line"></i>
                <span>Overview</span>
            </a>
            <a href="#courses" class="sidebar-link" data-section="courses">
                <i class="fa-solid fa-book-open"></i>
                <span>My Courses</span>
            </a>
            <a href="/classrooms" class="sidebar-link">
                <i class="fa-solid fa-chalkboard"></i>
                <span>Classrooms</span>
            </a>
            <a href="/" class="sidebar-link">
                <i class="fa-solid fa-house"></i>
                <span>Home</span>
            </a>
        </nav>
    </aside>

    <div class="main-content">
        <div class="top-bar">
            <div>
                <h2 id="page-title">Professor Overview</h2>
                <p class="student-panel-subtitle"><?php echo htmlspecialchars($professor['professor_name']); ?></p>
            </div>
            <div class="top-bar-actions">
                <a href="/" class="btn btn-bronze">Go home</a>
                <a href="/logout" class="btn btn-bronze">Logout</a>
            </div>
        </div>

        <div class="dashboard-content">
            <section id="overview-section" class="dashboard-section active">
                <h3 class="section-title">
                    <i class="fa-solid fa-chalkboard-user"></i> Professor Control Panel
                </h3>
                <p class="section-date">Academic view for <?php echo date('F Y'); ?></p>

                <!-- Professor Info Card -->
                <div class="student-profile-card">
                    <div class="student-profile-main">
                        <div class="student-avatar">
                            <i class="fa-solid fa-person-chalkboard"></i>
                        </div>
                        <div>
                            <h4><?php echo htmlspecialchars($professor['professor_name']); ?></h4>
                            <p><?php echo htmlspecialchars($professor['email']); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon courses"><?php echo count($courses); ?></div>
                        <p class="stat-label">Active Courses</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon submissions"><?php echo array_sum(array_column($courses, 'enrolled_count')); ?></div>
                        <p class="stat-label">Total Students</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon points"><?php echo array_sum(array_column($courses, 'assignments_count')); ?></div>
                        <p class="stat-label">Total Assignments</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon quizzes"><?php echo array_sum(array_column($courses, 'submissions_count')); ?></div>
                        <p class="stat-label">Total Submissions</p>
                    </div>
                </div>

                <!-- Your Information -->
                <div style="margin-top: 40px;">
                    <h4 class="section-title" style="margin-bottom: 20px;">
                        <i class="fa-solid fa-user"></i> Your Information
                    </h4>
                    <div class="student-summary-grid">
                        <div class="student-summary-item">
                            <span>Name</span>
                            <strong><?php echo htmlspecialchars($professor['professor_name']); ?></strong>
                        </div>
                        <div class="student-summary-item">
                            <span>Username</span>
                            <strong><?php echo htmlspecialchars($professor['user_name']); ?></strong>
                        </div>
                        <div class="student-summary-item">
                            <span>Email</span>
                            <strong><?php echo htmlspecialchars($professor['email']); ?></strong>
                        </div>
                        <div class="student-summary-item">
                            <span>Active Courses</span>
                            <strong><?php echo count($courses); ?></strong>
                        </div>
                    </div>
                </div>

                <!-- Quick Courses Preview -->
                <div style="margin-top: 40px;">
                    <h4 class="section-title" style="margin-bottom: 20px;">
                        <i class="fa-solid fa-book-open"></i> Your Courses
                    </h4>
                    <?php if (!empty($courses)): ?>
                        <div class="table-container">
                            <table class="dashboard-table">
                                <thead>
                                    <tr>
                                        <th>Course Name</th>
                                        <th>Students</th>
                                        <th>Assignments</th>
                                        <th>Submissions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (array_slice($courses, 0, 5) as $course): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                                            <td><?php echo $course['enrolled_count']; ?></td>
                                            <td><?php echo $course['assignments_count']; ?></td>
                                            <td><?php echo $course['submissions_count']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p style="color: #666; font-style: italic;">You haven't been assigned any courses yet.</p>
                    <?php endif; ?>
                </div>
            </section>

            <section id="courses-section" class="dashboard-section">
                <h3 class="section-title">
                    <i class="fa-solid fa-book-open"></i> Your Courses
                </h3>

                <div class="table-container">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Course Name</th>
                                <th>Enrolled Students</th>
                                <th>Assignments</th>
                                <th>Submissions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($courses)): ?>
                                <tr>
                                    <td colspan="4">You haven't been assigned any courses yet.</td>
                                </tr>
                            <?php endif; ?>
                            <?php foreach ($courses as $course): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                                    <td><?php echo $course['enrolled_count']; ?></td>
                                    <td><?php echo $course['assignments_count']; ?></td>
                                    <td><?php echo $course['submissions_count']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
    function showProfessorPanelSection(sectionName) {
        document.querySelectorAll('.dashboard-section').forEach(section => section.classList.remove('active'));
        document.querySelectorAll('.sidebar-link').forEach(link => link.classList.remove('active'));

        const targetSection = document.getElementById(sectionName + '-section');
        const targetLink = document.querySelector(`[data-section="${sectionName}"]`);

        if (targetSection) {
            targetSection.classList.add('active');
        }

        if (targetLink) {
            targetLink.classList.add('active');
        }

        const titles = {
            overview: 'Professor Overview',
            courses: 'Your Courses'
        };

        document.getElementById('page-title').textContent = titles[sectionName] || 'Professor Panel';
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.sidebar-link[data-section]').forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                showProfessorPanelSection(this.getAttribute('data-section'));
            });
        });
    });
</script>

<?php
include(base_path('views/partials/footer.view.php'));
?>
