<?php
include(base_path('views/partials/header.view.php'));

$canManageAcademic = is_staff();
$backTarget = $assignment['assignment_type'] === 'Quiz' ? '/classrooms#quizzes' : '/classrooms#assignments';
?>

<div class="dashboard-container">
    <div class="main-content mx-auto">
        <div class="top-bar">
            <h2 id="page-title">Assignment Details</h2>
            <div class="top-bar-actions">
                <a href="<?php echo $backTarget; ?>" class="btn btn-bronze">Back to Classrooms</a>
            </div>
        </div>

        <div class="dashboard-content">
            <section class="dashboard-section active">
                <h3 class="section-title"><?php echo $assignment['title']; ?></h3>

                <div class="student-details">
                    <div class="detail-row">
                        <label>Assignment ID:</label>
                        <span><?php echo $assignment['assignment_id']; ?></span>
                    </div>
                    <div class="detail-row">
                        <label>Type:</label>
                        <span><span class="badge badge-<?php echo strtolower($assignment['assignment_type']); ?>"><?php echo $assignment['assignment_type']; ?></span></span>
                    </div>
                    <div class="detail-row">
                        <label>Course:</label>
                        <span><?php echo $assignment['course_name']; ?></span>
                    </div>
                    <div class="detail-row">
                        <label>Professor:</label>
                        <span><?php echo $assignment['professor_name']; ?></span>
                    </div>
                    <div class="detail-row">
                        <label>Max Points:</label>
                        <span><?php echo $assignment['max_points']; ?></span>
                    </div>
                    <div class="detail-row">
                        <label>Deadline:</label>
                        <span><?php echo date('Y-m-d H:i', strtotime($assignment['deadline'])); ?></span>
                    </div>
                    <div class="detail-row">
                        <label>Created:</label>
                        <span><?php echo date('Y-m-d H:i', strtotime($assignment['created_at'])); ?></span>
                    </div>
                    <div class="detail-row">
                        <label>Total Submissions:</label>
                        <span><?php echo $assignment['submission_count']; ?></span>
                    </div>
                </div>

                <?php if (count($submissions) > 0): ?>
                    <h4 style="margin-top: 30px; margin-bottom: 15px;">Student Scores</h4>
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Score</th>
                                <th>Submitted At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($submissions as $sub): ?>
                                <?php $scoreFormId = 'score-form-' . $assignment['assignment_id'] . '-' . $sub['student_id']; ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($sub['user_name']); ?></td>
                                    <?php if ($canManageAcademic): ?>
                                        <td>
                                            <form id="<?php echo $scoreFormId; ?>" method="POST" action="/store-score" style="margin: 0;"></form>
                                            <input form="<?php echo $scoreFormId; ?>" type="hidden" name="assignment_id" value="<?php echo $assignment['assignment_id']; ?>">
                                            <input form="<?php echo $scoreFormId; ?>" type="hidden" name="student_id" value="<?php echo $sub['student_id']; ?>">
                                            <input form="<?php echo $scoreFormId; ?>" type="number" name="score" class="form-control" min="0" max="<?php echo $assignment['max_points']; ?>" value="<?php echo $sub['score'] ?? 0; ?>" required style="max-width: 120px; display: inline-block;">
                                            / <?php echo $assignment['max_points']; ?>
                                        </td>
                                    <?php else: ?>
                                        <td>
                                            <?php echo $sub['submission_id'] ? $sub['score'] . '/' . $assignment['max_points'] : '-'; ?>
                                        </td>
                                    <?php endif; ?>
                                    <td>
                                        <?php echo $sub['submitted_at'] ? date('Y-m-d H:i', strtotime($sub['submitted_at'])) : 'Not submitted'; ?>
                                    </td>
                                    <?php if ($canManageAcademic): ?>
                                        <td>
                                            <button form="<?php echo $scoreFormId; ?>" type="submit" class="btn-action edit">Save Score</button>
                                            <?php if ($sub['submission_id']): ?>
                                                <form method="POST" action="/delete-score" style="display: inline;">
                                                    <input type="hidden" name="assignment_id" value="<?php echo $assignment['assignment_id']; ?>">
                                                    <input type="hidden" name="submission_id" value="<?php echo $sub['submission_id']; ?>">
                                                    <button type="submit" class="btn-action delete">Delete Score</button>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                    <?php else: ?>
                                        <td>-</td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p style="margin-top: 20px; color: #666;">No students are enrolled in this course yet.</p>
                <?php endif; ?>

                <?php if ($canManageAcademic): ?>
                    <div class="action-buttons" style="margin-top: 30px;">
                        <a href="/edit-assignment?id=<?php echo $assignment['assignment_id']; ?>" class="btn btn-submit">
                            <i class="fa-solid fa-edit"></i> Edit Assignment
                        </a>
                        <a href="/delete-assignment?id=<?php echo $assignment['assignment_id']; ?>" class="btn btn-danger" style="background-color: #d32f2f; margin-left: 10px;">
                            <i class="fa-solid fa-trash"></i> Delete Assignment
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
