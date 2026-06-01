<?php
include(base_path('views/partials/header.view.php'));
?>

<div class="dashboard-container">
    <div class="main-content mx-auto">
        <div class="top-bar">
            <h2 id="page-title">Edit Course</h2>
            <div class="top-bar-actions">
                <a href="/classrooms#courses" class="btn btn-bronze">Back to Classrooms</a>
            </div>
        </div>

        <div class="dashboard-content">
            <section class="dashboard-section active">
                <h3 class="section-title">Edit Course Information</h3>

                <form method="POST" class="enroll-form" style="max-width: 700px;">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Course Name</label>
                            <input type="text" name="course_name" class="form-control" value="<?php echo htmlspecialchars($course['course_name']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Professor</label>
                            <select name="professor_id" class="form-control" required>
                                <?php foreach ($professors as $professor): ?>
                                    <option value="<?php echo $professor['professor_id']; ?>" <?php echo $professor['professor_id'] == $course['professor_id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($professor['professor_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div style="margin-top: 20px;">
                        <button type="submit" class="btn btn-submit">
                            <i class="fa-solid fa-save"></i> Save Changes
                        </button>
                        <a href="/show-course?id=<?php echo $course['course_id']; ?>" class="btn btn-bronze" style="margin-left: 10px;">Cancel</a>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>

<?php
include(base_path('views/partials/footer.view.php'));
?>
