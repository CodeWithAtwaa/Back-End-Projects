<?php
include(base_path('views/partials/header.view.php'));

$deadlineValue = date('Y-m-d\TH:i', strtotime($assignment['deadline']));
$backTarget = $assignment['assignment_type'] === 'Quiz' ? '/classrooms#quizzes' : '/classrooms#assignments';
?>

<div class="dashboard-container">
    <div class="main-content mx-auto">
        <div class="top-bar">
            <h2 id="page-title">Edit Assignment</h2>
            <div class="top-bar-actions">
                <a href="<?php echo $backTarget; ?>" class="btn btn-bronze">Back to Classrooms</a>
            </div>
        </div>

        <div class="dashboard-content">
            <section class="dashboard-section active">
                <h3 class="section-title">Edit Assignment Information</h3>

                <form method="POST" class="enroll-form" style="max-width: 850px;">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($assignment['title']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Type</label>
                            <select name="assignment_type" class="form-control" required>
                                <option value="Quiz" <?php echo $assignment['assignment_type'] === 'Quiz' ? 'selected' : ''; ?>>Quiz</option>
                                <option value="Assignment" <?php echo $assignment['assignment_type'] === 'Assignment' ? 'selected' : ''; ?>>Assignment</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Course</label>
                            <select name="course_id" class="form-control" required>
                                <?php foreach ($courses as $course): ?>
                                    <option value="<?php echo $course['course_id']; ?>" <?php echo $course['course_id'] == $assignment['course_id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($course['course_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Max Points</label>
                            <input type="number" name="max_points" class="form-control" min="1" value="<?php echo $assignment['max_points']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Deadline</label>
                            <input type="datetime-local" name="deadline" class="form-control" value="<?php echo $deadlineValue; ?>" required>
                        </div>
                    </div>

                    <div style="margin-top: 20px;">
                        <button type="submit" class="btn btn-submit">
                            <i class="fa-solid fa-save"></i> Save Changes
                        </button>
                        <a href="/show-assignment?id=<?php echo $assignment['assignment_id']; ?>" class="btn btn-bronze" style="margin-left: 10px;">Cancel</a>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>

<?php
include(base_path('views/partials/footer.view.php'));
?>
