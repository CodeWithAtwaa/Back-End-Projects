<?php
include(base_path('views/partials/header.view.php'));

$canManageAcademic = is_staff();
?>

<div class="dashboard-container">
    <div class="main-content mx-auto">
        <div class="top-bar">
            <h2 id="page-title">Student Details</h2>
            <div class="top-bar-actions">
                <a href="/classrooms#students" class="btn btn-bronze">Back to Classrooms</a>
            </div>
        </div>

        <div class="dashboard-content">
            <section class="dashboard-section active">
                <h3 class="section-title">Student Information</h3>

                <div class="student-details">
                    <div class="detail-row">
                        <label>Student ID:</label>
                        <span><?php echo $student['student_id']; ?></span>
                    </div>
                    <div class="detail-row">
                        <label>Name:</label>
                        <span><?php echo $student['user_name']; ?></span>
                    </div>
                    <div class="detail-row">
                        <label>Email:</label>
                        <span><?php echo $student['user_email']; ?></span>
                    </div>
                    <div class="detail-row">
                        <label>House:</label>
                        <span><?php echo $student['house']; ?></span>
                    </div>
                    <div class="detail-row">
                        <label>Balance:</label>
                        <span>₹<?php echo number_format($student['balance'], 2); ?></span>
                    </div>
                    <div class="detail-row">
                        <label>Wand:</label>
                        <span><?php echo $student['wand']; ?></span>
                    </div>
                    <div class="detail-row">
                        <label>Status:</label>
                        <span><span class="badge <?php echo strtolower($student['status']); ?>"><?php echo $student['status']; ?></span></span>
                    </div>
                </div>

                <?php if ($canManageAcademic): ?>
                    <div class="action-buttons" style="margin-top: 30px;">
                        <a href="/edit-student?id=<?php echo $student['student_id']; ?>" class="btn btn-submit">
                            <i class="fa-solid fa-edit"></i> Edit Student
                        </a>
                        <a href="/deactivate-student?id=<?php echo $student['student_id']; ?>" class="btn btn-danger" style="background-color: #d32f2f; margin-left: 10px;">
                            <i class="fa-solid fa-ban"></i> Deactivate Student
                        </a>
                        <a href="/delete-student?id=<?php echo $student['student_id']; ?>" class="btn btn-danger" style="background-color: #a61b1b; margin-left: 10px;">
                            <i class="fa-solid fa-trash"></i> Delete Student
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
