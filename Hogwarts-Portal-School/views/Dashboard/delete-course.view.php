<?php
include(base_path('views/partials/header.view.php'));
?>

<div class="dashboard-container">
    <div class="main-content mx-auto">
        <div class="top-bar">
            <h2 id="page-title">Delete Course</h2>
            <div class="top-bar-actions">
                <a href="/classrooms#courses" class="btn btn-bronze">Back to Classrooms</a>
            </div>
        </div>

        <div class="dashboard-content">
            <section class="dashboard-section active">
                <h3 class="section-title">Confirm Course Deletion</h3>

                <div style="background-color: #fff3cd; border: 1px solid #ffc107; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                    <p style="color: #856404; margin: 0;">Deleting this course also deletes its enrollments, assignments, submissions, and related house point rows.</p>
                </div>

                <div class="student-details" style="max-width: 700px;">
                    <div class="detail-row">
                        <label>Course:</label>
                        <span><?php echo htmlspecialchars($course['course_name']); ?></span>
                    </div>
                    <div class="detail-row">
                        <label>Professor:</label>
                        <span><?php echo htmlspecialchars($course['professor_name']); ?></span>
                    </div>
                    <div class="detail-row">
                        <label>Enrollments:</label>
                        <span><?php echo $course['enrollments_count']; ?></span>
                    </div>
                    <div class="detail-row">
                        <label>Assignments:</label>
                        <span><?php echo $course['assignments_count']; ?></span>
                    </div>
                </div>

                <form method="POST" style="margin-top: 30px;">
                    <button type="submit" class="btn btn-danger" style="background-color: #d32f2f;">
                        <i class="fa-solid fa-trash"></i> Delete Course
                    </button>
                    <a href="/show-course?id=<?php echo $course['course_id']; ?>" class="btn btn-bronze" style="margin-left: 10px;">Cancel</a>
                </form>
            </section>
        </div>
    </div>
</div>

<?php
include(base_path('views/partials/footer.view.php'));
?>
