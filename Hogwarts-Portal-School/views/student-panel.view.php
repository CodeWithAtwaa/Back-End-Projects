<?php
include(base_path('views/partials/header.view.php'));

function studentPanelStatusClass($status)
{
    return strtolower($status);
}
?>

<div class="dashboard-container student-panel">
    <aside class="sidebar">
        <div class="sidebar-header">
            <h3 class="sidebar-title">Student Panel</h3>
        </div>
        <nav class="sidebar-nav">
            <a href="#overview" class="sidebar-link active" data-section="overview">
                <i class="fa-solid fa-chart-line"></i>
                <span>Overview</span>
            </a>
            <a href="#courses" class="sidebar-link" data-section="courses">
                <i class="fa-solid fa-book-open"></i>
                <span>Courses</span>
            </a>
            <a href="#assignments" class="sidebar-link" data-section="assignments">
                <i class="fa-solid fa-list-check"></i>
                <span>Assignments</span>
            </a>
            <a href="#quizzes" class="sidebar-link" data-section="quizzes">
                <i class="fa-solid fa-circle-question"></i>
                <span>Quizzes</span>
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
                <h2 id="page-title">Student Overview</h2>
                <p class="student-panel-subtitle"><?php echo htmlspecialchars($student['user_name']); ?> · <?php echo htmlspecialchars($student['house_name']); ?></p>
            </div>
            <div class="top-bar-actions">
                <a href="/" class="btn btn-bronze">Go home</a>
                <a href="/logout" class="btn btn-bronze">Logout</a>
            </div>
        </div>

        <div class="dashboard-content">
            <section id="overview-section" class="dashboard-section active">
                <?php if (\Core\Session::has('submission_message')): ?>
                    <div class="alert-magic-success student-alert">
                        <?php echo htmlspecialchars(\Core\Session::get('submission_message')); ?>
                    </div>
                <?php endif; ?>

                <h3 class="section-title">
                    <i class="fa-solid fa-user-graduate"></i> My Control Panel
                </h3>
                <p class="section-date">Academic view for <?php echo date('F Y'); ?></p>

                <div class="student-profile-card">
                    <div class="student-profile-main">
                        <div class="student-avatar">
                            <i class="fa-solid fa-hat-wizard"></i>
                        </div>
                        <div>
                            <h4><?php echo htmlspecialchars($student['user_name']); ?></h4>
                            <p><?php echo htmlspecialchars($student['email']); ?></p>
                        </div>
                    </div>
                    <div class="student-profile-meta">
                        <span class="house-badge <?php echo strtolower($student['house_name']); ?>"><?php echo htmlspecialchars($student['house_name']); ?></span>
                        <span class="badge <?php echo strtolower($student['status']); ?>"><?php echo htmlspecialchars($student['status']); ?></span>
                    </div>
                </div>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon courses"><?php echo $stats['courses']; ?></div>
                        <p class="stat-label">Registered Courses</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon quizzes"><?php echo $stats['quizzes']; ?></div>
                        <p class="stat-label">Quizzes</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon assignments"><?php echo $stats['class_assignments']; ?></div>
                        <p class="stat-label">Assignments</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon points"><?php echo $stats['average_score']; ?>%</div>
                        <p class="stat-label">Submitted Average</p>
                    </div>
                </div>

                <div class="student-summary-grid">
                    <div class="student-summary-item">
                        <span>Wand</span>
                        <strong><?php echo htmlspecialchars($student['wand'] ?? 'Not assigned'); ?></strong>
                    </div>
                    <div class="student-summary-item">
                        <span>Balance</span>
                        <strong><?php echo number_format($student['balance'], 2); ?></strong>
                    </div>
                    <div class="student-summary-item">
                        <span>House Points</span>
                        <strong><?php echo number_format($student['total_points']); ?></strong>
                    </div>
                    <div class="student-summary-item">
                        <span>Pending Work</span>
                        <strong><?php echo $stats['pending']; ?></strong>
                    </div>
                </div>

                <!-- Your Courses Quick View -->
                <div style="margin-top: 40px;">
                    <h4 class="section-title" style="margin-bottom: 20px;">
                        <i class="fa-solid fa-book-open"></i> Your Courses
                    </h4>
                    <?php if (!empty($courses)): ?>
                        <div class="table-container">
                            <table class="dashboard-table">
                                <thead>
                                    <tr>
                                        <th>Course</th>
                                        <th>Professor</th>
                                        <th>Status</th>
                                        <th>Assignments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (array_slice($courses, 0, 5) as $course): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                                            <td><?php echo htmlspecialchars($course['professor_name']); ?></td>
                                            <td><span class="badge <?php echo strtolower($course['status']); ?>"><?php echo htmlspecialchars($course['status']); ?></span></td>
                                            <td><?php echo $course['assignments_count']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p style="color: #666; font-style: italic;">You are not registered for any courses yet.</p>
                    <?php endif; ?>
                </div>

                <!-- Pending Work Quick View -->
                <div style="margin-top: 40px;">
                    <h4 class="section-title" style="margin-bottom: 20px;">
                        <i class="fa-solid fa-list-check"></i> Pending Work
                    </h4>
                    <?php if (!empty($pendingAssignments)): ?>
                        <div class="table-container">
                            <table class="dashboard-table">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Course</th>
                                        <th>Deadline</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (array_slice($pendingAssignments, 0, 5) as $assignment): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($assignment['title']); ?></td>
                                            <td><span class="badge badge-<?php echo strtolower($assignment['assignment_type']); ?>"><?php echo htmlspecialchars($assignment['assignment_type']); ?></span></td>
                                            <td><?php echo htmlspecialchars($assignment['course_name']); ?></td>
                                            <td><?php echo date('M d, Y', strtotime($assignment['deadline'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p style="color: #666; font-style: italic;">No pending work at the moment!</p>
                    <?php endif; ?>
                </div>
            </section>

            <section id="courses-section" class="dashboard-section">
                <h3 class="section-title">
                    <i class="fa-solid fa-book-open"></i> Registered Courses
                </h3>

                <div class="table-container">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Professor</th>
                                <th>Registered At</th>
                                <th>Status</th>
                                <th>Assignments</th>
                                <th>Submitted</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($courses)): ?>
                                <tr>
                                    <td colspan="6">You are not registered for any courses yet.</td>
                                </tr>
                            <?php endif; ?>
                            <?php foreach ($courses as $course): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                                    <td><?php echo htmlspecialchars($course['professor_name']); ?></td>
                                    <td><?php echo date('Y-m-d', strtotime($course['enrolled_at'])); ?></td>
                                    <td><span class="badge <?php echo strtolower($course['status']); ?>"><?php echo htmlspecialchars($course['status']); ?></span></td>
                                    <td><?php echo $course['assignments_count']; ?></td>
                                    <td><?php echo $course['submissions_count']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </section>

            <section id="assignments-section" class="dashboard-section">
                <?php if (\Core\Session::has('submission_message')): ?>
                    <div class="alert-magic-success student-alert">
                        <?php echo htmlspecialchars(\Core\Session::get('submission_message')); ?>
                    </div>
                <?php endif; ?>
                <h3 class="section-title">
                    <i class="fa-solid fa-list-check"></i> My Assignments
                </h3>
                <?php $assignments = $classAssignments; $studentPanelActionTarget = '/classrooms#assignments'; $studentPanelActionLabel = 'Open in Classrooms'; include(base_path('views/partials/student-work-table.view.php')); ?>
            </section>

            <section id="quizzes-section" class="dashboard-section">
                <h3 class="section-title">
                    <i class="fa-solid fa-circle-question"></i> My Quizzes
                </h3>
                <?php $assignments = $quizzes; $studentPanelActionTarget = '/classrooms#quizzes'; $studentPanelActionLabel = 'Open in Classrooms'; include(base_path('views/partials/student-work-table.view.php')); ?>
            </section>

        </div>
    </div>
</div>

<script>
    function showStudentPanelSection(sectionName) {
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
            overview: 'Student Overview',
            courses: 'Registered Courses',
            assignments: 'My Assignments',
            quizzes: 'My Quizzes'
        };

        document.getElementById('page-title').textContent = titles[sectionName] || 'Student Panel';
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.sidebar-link[data-section]').forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                showStudentPanelSection(this.getAttribute('data-section'));
            });
        });

        const initialSection = window.location.hash.replace('#', '');
        if (initialSection) {
            showStudentPanelSection(initialSection);
        }
    });
</script>

<?php
include(base_path('views/partials/footer.view.php'));
?>
