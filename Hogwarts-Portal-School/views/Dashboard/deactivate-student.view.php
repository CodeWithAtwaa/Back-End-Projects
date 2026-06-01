<?php
include(base_path('views/partials/header.view.php'));
?>

<div class="dashboard-container">
    <div class="main-content mx-auto">
        <div class="top-bar">
            <h2 id="page-title">Deactivate Student</h2>
            <div class="top-bar-actions">
                <a href="/classrooms#students" class="btn btn-bronze">Back to Classrooms</a>
            </div>
        </div>

        <div class="dashboard-content">
            <section class="dashboard-section active">
                <h3 class="section-title">Confirm Deactivation</h3>

                <div style="background-color: #fff3cd; border: 1px solid #ffc107; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                    <p style="color: #856404; margin: 0;">
                        <i class="fa-solid fa-exclamation-triangle"></i> <strong>Warning:</strong> You are about to deactivate this student account. This action will mark the student as inactive.
                    </p>
                </div>

                <div class="student-details" style="max-width: 600px;">
                    <div class="detail-row">
                        <label>Student ID:</label>
                        <span><?php echo $student['student_id']; ?></span>
                    </div>
                </div>

                <form method="POST" style="margin-top: 30px;">
                    <button type="submit" class="btn btn-danger" style="background-color: #d32f2f;">
                        <i class="fa-solid fa-check"></i> Confirm Deactivation
                    </button>
                    <a href="/classrooms#students" class="btn btn-bronze" style="margin-left: 10px;">
                        Cancel
                    </a>
                </form>
            </section>
        </div>
    </div>
</div>

<?php
include(base_path('views/partials/footer.view.php'));
?>
