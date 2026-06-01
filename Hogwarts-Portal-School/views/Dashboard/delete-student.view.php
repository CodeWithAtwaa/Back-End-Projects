<?php
include(base_path('views/partials/header.view.php'));
?>

<div class="dashboard-container">
    <div class="main-content mx-auto">
        <div class="top-bar">
            <h2 id="page-title">Delete Student</h2>
            <div class="top-bar-actions">
                <a href="/classrooms#students" class="btn btn-bronze">Back to Classrooms</a>
            </div>
        </div>

        <div class="dashboard-content">
            <section class="dashboard-section active">
                <h3 class="section-title">Confirm Student Deletion</h3>

                <div style="background-color: #fff3cd; border: 1px solid #ffc107; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                    <p style="color: #856404; margin: 0;">Deleting this student removes the linked user account and cascades related student records.</p>
                </div>

                <div class="student-details" style="max-width: 700px;">
                    <div class="detail-row">
                        <label>Name:</label>
                        <span><?php echo htmlspecialchars($student['user_name']); ?></span>
                    </div>
                    <div class="detail-row">
                        <label>Email:</label>
                        <span><?php echo htmlspecialchars($student['email']); ?></span>
                    </div>
                    <div class="detail-row">
                        <label>House:</label>
                        <span><?php echo htmlspecialchars($student['house_name']); ?></span>
                    </div>
                    <div class="detail-row">
                        <label>Status:</label>
                        <span><?php echo htmlspecialchars($student['status']); ?></span>
                    </div>
                </div>

                <form method="POST" style="margin-top: 30px;">
                    <button type="submit" class="btn btn-danger" style="background-color: #d32f2f;">
                        <i class="fa-solid fa-trash"></i> Delete Student
                    </button>
                    <a href="/show-student?id=<?php echo $student['student_id']; ?>" class="btn btn-bronze" style="margin-left: 10px;">Cancel</a>
                </form>
            </section>
        </div>
    </div>
</div>

<?php
include(base_path('views/partials/footer.view.php'));
?>
