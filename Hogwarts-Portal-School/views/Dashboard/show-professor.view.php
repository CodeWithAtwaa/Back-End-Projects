<?php
include(base_path('views/partials/header.view.php'));

$canManageProfessor = is_dumbledore();
?>

<div class="dashboard-container">
    <div class="main-content mx-auto">
        <div class="top-bar">
            <h2 id="page-title">Professor Details</h2>
            <div class="top-bar-actions">
                <a href="/dashboard" class="btn btn-bronze">Back to Dashboard</a>
            </div>
        </div>

        <div class="dashboard-content">
            <section class="dashboard-section active">
                <h3 class="section-title">Professor Information</h3>

                <div class="student-details">
                    <div class="detail-row">
                        <label>Professor ID:</label>
                        <span><?php echo $professor['professor_id']; ?></span>
                    </div>
                    <div class="detail-row">
                        <label>Name:</label>
                        <span><?php echo $professor['professor_name']; ?></span>
                    </div>
                    <div class="detail-row">
                        <label>Email:</label>
                        <span><?php echo $professor['email']; ?></span>
                    </div>
                    <div class="detail-row">
                        <label>Total Courses:</label>
                        <span><?php echo $professor['courses_count']; ?></span>
                    </div>
                    <div class="detail-row">
                        <label>Students Taught:</label>
                        <span><?php echo $professor['students_count']; ?></span>
                    </div>
                </div>

                <h4 style="margin-top: 30px; margin-bottom: 15px;">Courses Taught</h4>
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Course ID</th>
                            <th>Course Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($courses as $course): ?>
                            <tr>
                                <td><?php echo $course['course_id']; ?></td>
                                <td><?php echo $course['course_name']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <?php if ($canManageProfessor): ?>
                    <div class="action-buttons" style="margin-top: 30px;">
                        <a href="/edit-professor?id=<?php echo $professor['professor_id']; ?>" class="btn btn-submit">
                            <i class="fa-solid fa-edit"></i> Edit Professor
                        </a>
                        <a href="/delete-professor?id=<?php echo $professor['professor_id']; ?>" class="btn btn-danger" style="background-color: #d32f2f; margin-left: 10px;">
                            <i class="fa-solid fa-trash"></i> Delete Professor
                        </a>
                    </div>
                <?php endif; ?>

            </section>
        </div>
    </div>
</div>

<?php
include(base_path('views/partials/footer.view.php'));
?>
