<?php
include(base_path('views/partials/header.view.php'));
include(base_path('views/partials/nav.view.php'));

$isStudentClassrooms = $role === 'Student';
$canManageCourses = is_staff();
$canEnrollStudents = is_staff();
$staffAssignments = [];
$staffQuizzes = [];
$registeredCourseCount = 0;

if ($isStudentClassrooms) {
    $registeredCourseCount = count(array_filter($courses, function ($course) {
        return $course['status'] === 'Enrolled';
    }));
}

if (!$isStudentClassrooms) {
    $staffAssignments = array_values(array_filter($Assignments, function ($assignment) {
        return $assignment['assignment_type'] === 'Assignment';
    }));

    $staffQuizzes = array_values(array_filter($Assignments, function ($assignment) {
        return $assignment['assignment_type'] === 'Quiz';
    }));
}

function classroomsStatusClass($status)
{
    return strtolower($status);
}

function classroomsPendingBadge($count)
{
    if ($count < 1) {
        return '';
    }

    return '<span class="classrooms-notification">' . $count . '</span>';
}
?>

<section class="classrooms-page">
    <aside class="classrooms-sidebar">
        <div class="classrooms-sidebar-header">
            <h2>Classrooms</h2>
        </div>

        <nav class="classrooms-nav">
            <a href="#courses" class="classrooms-nav-link active" data-section="courses">
                <i class="fa-solid fa-book-open"></i>
                <span>Courses</span>
            </a>
            <?php if (!$isStudentClassrooms): ?>
                <a href="#students" class="classrooms-nav-link" data-section="students">
                    <i class="fa-solid fa-users"></i>
                    <span>Students</span>
                </a>
            <?php endif; ?>
            <a href="#assignments" class="classrooms-nav-link" data-section="assignments">
                <i class="fa-solid fa-list-check"></i>
                <span>Assignments</span>
                <?php if ($isStudentClassrooms) echo classroomsPendingBadge($pendingAssignmentCount); ?>
            </a>
            <a href="#quizzes" class="classrooms-nav-link" data-section="quizzes">
                <i class="fa-solid fa-circle-question"></i>
                <span>Quizzes</span>
                <?php if ($isStudentClassrooms) echo classroomsPendingBadge($pendingQuizCount); ?>
            </a>
            <a href="<?php echo $isStudentClassrooms ? '/student-panel' : '/dashboard'; ?>" class="classrooms-nav-link">
                <i class="fa-solid fa-arrow-left"></i>
                <span><?php echo $isStudentClassrooms ? 'Student Panel' : 'Dashboard'; ?></span>
            </a>
        </nav>
    </aside>

    <main class="classrooms-main">
        <header class="classrooms-header">
            <div>
                <p class="classrooms-kicker">Hogwarts Academic Portal</p>
                <h1>
                    <i class="fa-solid fa-chalkboard"></i>
                    Classrooms
                </h1>
                <?php if ($isStudentClassrooms): ?>
                    <p><?php echo htmlspecialchars($student['user_name']); ?> · <?php echo htmlspecialchars($student['house_name']); ?></p>
                <?php else: ?>
                    <p><?php echo $role === 'Professor' ? 'Manage your assigned classrooms.' : 'View Hogwarts classrooms.'; ?></p>
                <?php endif; ?>
            </div>
        </header>

        <?php if (\Core\Session::has('submission_message')): ?>
            <div class="alert-magic-success student-alert">
                <?php echo htmlspecialchars(\Core\Session::get('submission_message')); ?>
            </div>
        <?php endif; ?>

        <?php if ($isStudentClassrooms): ?>
            <section id="courses-section" class="classrooms-section active">
                <div class="stats-grid classrooms-stats">
                    <div class="stat-card">
                        <div class="stat-icon courses"><?php echo $registeredCourseCount; ?></div>
                        <p class="stat-label">Registered Courses</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon assignments"><?php echo count($classAssignments); ?></div>
                        <p class="stat-label">Assignments</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon quizzes"><?php echo count($quizzes); ?></div>
                        <p class="stat-label">Quizzes</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon active"><?php echo count($availableCourses); ?></div>
                        <p class="stat-label">Available Courses</p>
                    </div>
                </div>

                <div class="classrooms-card">
                    <h2 class="section-title">
                        <i class="fa-solid fa-book-open"></i> Registered Courses
                    </h2>

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
                                        <td><span class="badge <?php echo classroomsStatusClass($course['status']); ?>"><?php echo htmlspecialchars($course['status']); ?></span></td>
                                        <td><?php echo $course['assignments_count']; ?></td>
                                        <td><?php echo $course['submissions_count']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="classrooms-card">
                    <h2 class="section-title">
                        <i class="fa-solid fa-plus"></i> Choose Courses
                    </h2>

                    <div class="table-container">
                        <table class="dashboard-table">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Professor</th>
                                    <th>Assignments</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($availableCourses)): ?>
                                    <tr>
                                        <td colspan="5">No courses are available yet.</td>
                                    </tr>
                                <?php endif; ?>
                                <?php foreach ($availableCourses as $course): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                                        <td><?php echo htmlspecialchars($course['professor_name']); ?></td>
                                        <td><?php echo $course['assignments_count']; ?></td>
                                        <td>
                                            <?php if ($course['enrollment_status'] === 'Enrolled'): ?>
                                                <span class="badge active">Enrolled</span>
                                            <?php else: ?>
                                                <span class="badge pending">Available</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($course['enrollment_status'] === 'Enrolled'): ?>
                                                -
                                            <?php else: ?>
                                                <form method="POST" action="/enroll-course" style="margin: 0;">
                                                    <input type="hidden" name="course_id" value="<?php echo $course['course_id']; ?>">
                                                    <button type="submit" class="btn-action edit">Enroll</button>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section id="assignments-section" class="classrooms-section">
                <div class="classrooms-card">
                    <h2 class="section-title">
                        <i class="fa-solid fa-list-check"></i> My Assignments
                    </h2>
                    <?php $classroomWorkItems = $classAssignments; $classroomWorkRedirect = '/classrooms#assignments'; include(base_path('views/partials/classrooms-work-table.view.php')); ?>
                </div>
            </section>

            <section id="quizzes-section" class="classrooms-section">
                <div class="classrooms-card">
                    <h2 class="section-title">
                        <i class="fa-solid fa-circle-question"></i> My Quizzes
                    </h2>
                    <?php $classroomWorkItems = $quizzes; $classroomWorkRedirect = '/classrooms#quizzes'; include(base_path('views/partials/classrooms-work-table.view.php')); ?>
                </div>
            </section>
        <?php else: ?>
            <section id="courses-section" class="classrooms-section active">
                <div class="stats-grid classrooms-stats">
                    <div class="stat-card">
                        <div class="stat-icon courses"><?php echo $stats['total_courses']; ?></div>
                        <p class="stat-label">Total Courses</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon enrolled"><?php echo $stats['total_enrollments']; ?></div>
                        <p class="stat-label">Total Enrollments</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon assignments"><?php echo count($staffAssignments); ?></div>
                        <p class="stat-label">Assignments</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon quizzes"><?php echo count($staffQuizzes); ?></div>
                        <p class="stat-label">Quizzes</p>
                    </div>
                </div>

                <div class="classrooms-card">
                    <h2 class="section-title">
                        <i class="fa-solid fa-book"></i> Courses Management
                    </h2>

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
                                            <?php if ($canManageCourses): ?>
                                                <a href="/edit-course?id=<?php echo $course['course_id']; ?>" class="btn-action edit">Edit</a>
                                                <a href="/delete-course?id=<?php echo $course['course_id']; ?>" class="btn-action delete">Delete</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php if ($canManageCourses): ?>
                    <div class="classrooms-card">
                        <h2 class="section-title">
                            <i class="fa-solid fa-plus"></i> Add New Course
                        </h2>

                        <form method="POST" action="/store-course" class="enroll-form">
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Course Name</label>
                                    <input type="text" name="course_name" class="form-control" placeholder="Enter course name" required>
                                </div>
                                <div class="form-group">
                                    <label>Professor</label>
                                    <?php if (is_dumbledore()): ?>
                                        <select name="professor_id" class="form-control" required>
                                            <option value="">Select Professor</option>
                                            <?php foreach ($Professors as $professorItem): ?>
                                                <option value="<?php echo $professorItem['professor_id']; ?>">
                                                    <?php echo htmlspecialchars($professorItem['professor_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php else: ?>
                                        <input type="hidden" name="professor_id" value="<?php echo $currentProfessor['professor_id'] ?? ''; ?>">
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($currentProfessor['professor_name'] ?? 'Current Professor'); ?>" disabled>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-submit">
                                <i class="fa-solid fa-plus"></i> Add Course
                            </button>
                        </form>
                    </div>
                <?php endif; ?>
            </section>

            <section id="assignments-section" class="classrooms-section">
                <div class="classrooms-card">
                    <h2 class="section-title">
                        <i class="fa-solid fa-list-check"></i> Assignments
                    </h2>
                    <?php $staffWorkItems = $staffAssignments; include(base_path('views/partials/classrooms-staff-work-table.view.php')); ?>
                </div>

                <?php if ($canManageCourses): ?>
                    <div class="classrooms-card">
                        <h2 class="section-title">
                            <i class="fa-solid fa-plus"></i> Create New Assignment
                        </h2>

                        <form method="POST" action="/store-assignment" class="enroll-form">
                            <input type="hidden" name="assignment_type" value="Assignment">
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Assignment Title</label>
                                    <input type="text" name="title" class="form-control" placeholder="Enter assignment title" required>
                                </div>
                                <div class="form-group">
                                    <label>Course</label>
                                    <select name="course_id" class="form-control" required>
                                        <option value="">Choose course</option>
                                        <?php foreach ($Courses as $course): ?>
                                            <option value="<?php echo $course['course_id']; ?>"><?php echo htmlspecialchars($course['course_name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Max Points</label>
                                    <input type="number" name="max_points" class="form-control" placeholder="100" value="100" min="1" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Deadline</label>
                                    <input type="datetime-local" name="deadline" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" rows="3" placeholder="Assignment description"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-submit">
                                <i class="fa-solid fa-plus"></i> Create Assignment
                            </button>
                        </form>
                    </div>
                <?php endif; ?>
            </section>

            <section id="quizzes-section" class="classrooms-section">
                <div class="classrooms-card">
                    <h2 class="section-title">
                        <i class="fa-solid fa-circle-question"></i> Quizzes
                    </h2>
                    <?php $staffWorkItems = $staffQuizzes; include(base_path('views/partials/classrooms-staff-work-table.view.php')); ?>
                </div>

                <?php if ($canManageCourses): ?>
                    <div class="classrooms-card">
                        <h2 class="section-title">
                            <i class="fa-solid fa-plus"></i> Create New Quiz
                        </h2>

                        <form method="POST" action="/store-assignment" class="enroll-form">
                            <input type="hidden" name="assignment_type" value="Quiz">
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Quiz Title</label>
                                    <input type="text" name="title" class="form-control" placeholder="Enter quiz title" required>
                                </div>
                                <div class="form-group">
                                    <label>Course</label>
                                    <select name="course_id" class="form-control" required>
                                        <option value="">Choose course</option>
                                        <?php foreach ($Courses as $course): ?>
                                            <option value="<?php echo $course['course_id']; ?>"><?php echo htmlspecialchars($course['course_name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Max Points</label>
                                    <input type="number" name="max_points" class="form-control" placeholder="100" value="100" min="1" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Deadline</label>
                                    <input type="datetime-local" name="deadline" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" rows="3" placeholder="Quiz description"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-submit">
                                <i class="fa-solid fa-plus"></i> Create Quiz
                            </button>
                        </form>
                    </div>
                <?php endif; ?>
            </section>

            <section id="students-section" class="classrooms-section">
                <div class="classrooms-card">
                    <h2 class="section-title">
                        <i class="fa-solid fa-users"></i> Students In My Classrooms
                    </h2>

                    <div class="table-container">
                        <table class="dashboard-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Student</th>
                                    <th>Email</th>
                                    <th>House</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($Students)): ?>
                                    <tr>
                                        <td colspan="6">No students found.</td>
                                    </tr>
                                <?php endif; ?>
                                <?php foreach ($Students as $studentItem): ?>
                                    <tr>
                                        <td><?php echo $studentItem['student_id']; ?></td>
                                        <td><?php echo htmlspecialchars($studentItem['user_name']); ?></td>
                                        <td><?php echo htmlspecialchars($studentItem['user_email']); ?></td>
                                        <td><span class="house-badge <?php echo strtolower($studentItem['house']); ?>"><?php echo htmlspecialchars($studentItem['house']); ?></span></td>
                                        <td><span class="badge <?php echo strtolower($studentItem['status']); ?>"><?php echo htmlspecialchars($studentItem['status']); ?></span></td>
                                        <td>
                                            <a href="/show-student?id=<?php echo $studentItem['student_id']; ?>" class="btn-action show">View</a>
                                            <?php if ($canManageCourses): ?>
                                                <a href="/edit-student?id=<?php echo $studentItem['student_id']; ?>" class="btn-action edit">Edit</a>
                                                <a href="/delete-student?id=<?php echo $studentItem['student_id']; ?>" class="btn-action delete">Delete</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="classrooms-card">
                    <h2 class="section-title">
                        <i class="fa-solid fa-book-open-reader"></i> Students By Course
                    </h2>

                    <div class="table-container">
                        <table class="dashboard-table">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Professor</th>
                                    <th>Student</th>
                                    <th>Email</th>
                                    <th>House</th>
                                    <th>Enrolled At</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($courseStudents)): ?>
                                    <tr>
                                        <td colspan="7">No course enrollments found.</td>
                                    </tr>
                                <?php endif; ?>
                                <?php foreach ($courseStudents as $courseStudent): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($courseStudent['course_name']); ?></td>
                                        <td><?php echo htmlspecialchars($courseStudent['professor_name']); ?></td>
                                        <td><?php echo htmlspecialchars($courseStudent['user_name']); ?></td>
                                        <td><?php echo htmlspecialchars($courseStudent['email']); ?></td>
                                        <td><span class="house-badge <?php echo strtolower($courseStudent['house_name']); ?>"><?php echo htmlspecialchars($courseStudent['house_name']); ?></span></td>
                                        <td><?php echo date('Y-m-d', strtotime($courseStudent['enrolled_at'])); ?></td>
                                        <td><span class="badge <?php echo strtolower($courseStudent['status']); ?>"><?php echo htmlspecialchars($courseStudent['status']); ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php if ($canEnrollStudents): ?>
                    <div class="classrooms-card">
                        <h2 class="section-title">
                            <i class="fa-solid fa-user-plus"></i> Enroll New Student
                        </h2>

                        <form method="POST" action="/store-student" class="enroll-form">
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" name="user_name" class="form-control" placeholder="Enter full name" required>
                                </div>
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                                </div>
                                <div class="form-group">
                                    <label>House (optional)</label>
                                    <select name="house" class="form-control">
                                        <option value="">Sorting Hat chooses</option>
                                        <option value="Gryffindor">Gryffindor</option>
                                        <option value="Slytherin">Slytherin</option>
                                        <option value="Ravenclaw">Ravenclaw</option>
                                        <option value="Hufflepuff">Hufflepuff</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Enroll In Course<?php echo is_dumbledore() ? ' (optional)' : ''; ?></label>
                                    <select name="course_id" class="form-control" <?php echo is_dumbledore() ? '' : 'required'; ?>>
                                        <option value=""><?php echo is_dumbledore() ? 'No course yet' : 'Choose course'; ?></option>
                                        <?php foreach ($Courses as $course): ?>
                                            <option value="<?php echo $course['course_id']; ?>">
                                                <?php echo htmlspecialchars($course['course_name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                                </div>
                                <div class="form-group">
                                    <label>Initial Balance</label>
                                    <input type="number" name="balance" step="0.01" class="form-control" placeholder="1000.00" value="1000.00" required>
                                </div>
                                <div class="form-group">
                                    <label>Wand Wood (optional)</label>
                                    <select name="wood_type" class="form-control">
                                        <option value="">Wand chooses</option>
                                        <option value="Holly">Holly</option>
                                        <option value="Yew">Yew</option>
                                        <option value="Elder">Elder</option>
                                        <option value="Willow">Willow</option>
                                        <option value="Hawthorn">Hawthorn</option>
                                        <option value="Oak">Oak</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Wand Core (optional)</label>
                                    <select name="core_type" class="form-control">
                                        <option value="">Wand chooses</option>
                                        <option value="Phoenix Feather">Phoenix Feather</option>
                                        <option value="Dragon Heartstring">Dragon Heartstring</option>
                                        <option value="Unicorn Hair">Unicorn Hair</option>
                                        <option value="Thestral Tail Hair">Thestral Tail Hair</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-submit">
                                <i class="fa-solid fa-plus"></i> Enroll Student
                            </button>
                        </form>
                    </div>
                <?php endif; ?>
            </section>
        <?php endif; ?>
    </main>
</section>

<script>
    function showClassroomsSection(sectionName) {
        document.querySelectorAll('.classrooms-section').forEach(section => section.classList.remove('active'));
        document.querySelectorAll('.classrooms-nav-link[data-section]').forEach(link => link.classList.remove('active'));

        const targetSection = document.getElementById(sectionName + '-section');
        const targetLink = document.querySelector(`.classrooms-nav-link[data-section="${sectionName}"]`);

        if (targetSection) {
            targetSection.classList.add('active');
        }

        if (targetLink) {
            targetLink.classList.add('active');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.classrooms-nav-link[data-section]').forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const sectionName = this.getAttribute('data-section');
                history.replaceState(null, '', '#' + sectionName);
                showClassroomsSection(sectionName);
            });
        });

        const initialSection = window.location.hash.replace('#', '') || 'courses';
        showClassroomsSection(initialSection);
    });
</script>

<style>
    .classrooms-page {
        background:
            radial-gradient(circle at top right, rgba(148, 107, 45, 0.16), transparent 30%),
            linear-gradient(135deg, #0E1A40 0%, #14295d 48%, #0a132e 100%);
        display: flex;
        min-height: calc(100vh - 70px);
    }

    .classrooms-sidebar {
        background: linear-gradient(180deg, #071022 0%, #0E1A40 65%, #13295c 100%);
        border-right: 4px solid #946B2D;
        box-shadow: 12px 0 28px rgba(3, 9, 23, 0.35);
        color: #eef4ff;
        flex: 0 0 290px;
        min-height: calc(100vh - 70px);
        padding: 28px 0;
    }

    .classrooms-sidebar-header {
        border-bottom: 1px solid rgba(148, 107, 45, 0.45);
        margin-bottom: 24px;
        padding: 0 28px 24px;
    }

    .classrooms-sidebar-header h2 {
        color: #c8d9ff;
        font-family: 'Cinzel', serif;
        font-size: 30px;
        margin: 0;
    }

    .classrooms-sidebar-header p {
        color: #c59b45;
        font-weight: 700;
        letter-spacing: 1px;
        margin: 6px 0 0;
        text-transform: uppercase;
    }

    .classrooms-nav {
        display: flex;
        flex-direction: column;
        gap: 8px;
        padding: 0 14px;
    }

    .classrooms-nav-link {
        align-items: center;
        border-left: 4px solid transparent;
        border-radius: 0 8px 8px 0;
        color: #dbe7ff;
        display: grid;
        gap: 12px;
        grid-template-columns: 24px 1fr auto;
        min-height: 52px;
        padding: 14px 16px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .classrooms-nav-link:hover,
    .classrooms-nav-link.active {
        background: rgba(148, 107, 45, 0.22);
        border-left-color: #946B2D;
        color: #ffffff;
    }

    .classrooms-notification {
        align-items: center;
        background: #c03232;
        border: 2px solid #ffe6e6;
        border-radius: 999px;
        color: #ffffff;
        display: inline-flex;
        font-size: 12px;
        font-weight: 800;
        height: 24px;
        justify-content: center;
        min-width: 24px;
        padding: 0 7px;
    }

    .classrooms-main {
        flex: 1;
        min-width: 0;
        padding: 32px;
    }

    .classrooms-header {
        align-items: center;
        background: rgba(255, 255, 255, 0.94);
        border-bottom: 4px solid #946B2D;
        border-radius: 8px;
        box-shadow: 0 14px 34px rgba(3, 9, 23, 0.25);
        color: #0E1A40;
        display: flex;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 28px;
        padding: 28px 30px;
    }

    .classrooms-header h1 {
        color: #0E1A40;
        font-family: 'Cinzel', serif;
        font-size: 34px;
        margin: 0 0 8px;
    }

    .classrooms-header p {
        color: #42506c;
        font-weight: 700;
        margin: 0;
    }

    .classrooms-kicker {
        color: #946B2D !important;
        font-size: 13px;
        letter-spacing: 1px;
        margin-bottom: 8px !important;
        text-transform: uppercase;
    }

    .classrooms-section {
        display: none;
    }

    .classrooms-section.active {
        display: block;
    }

    .classrooms-stats {
        margin-bottom: 28px;
    }

    .classrooms-card {
        background: rgba(255, 255, 255, 0.96);
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(3, 9, 23, 0.2);
        margin-bottom: 28px;
        padding: 30px;
    }

    .classrooms-card .section-title {
        color: #0E1A40;
    }

    @media (max-width: 900px) {
        .classrooms-page {
            flex-direction: column;
        }

        .classrooms-sidebar {
            flex: 0 0 auto;
            min-height: 0;
        }

        .classrooms-nav {
            flex-direction: row;
            flex-wrap: wrap;
        }

        .classrooms-nav-link {
            flex: 1;
            min-width: 160px;
        }

        .classrooms-main {
            padding: 20px;
        }
    }

    @media (max-width: 768px) {
        .classrooms-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .classrooms-header h1 {
            font-size: 28px;
        }

        .classrooms-card {
            padding: 20px;
        }
    }
</style>

<?php include(base_path('views/partials/footer.view.php')); ?>
