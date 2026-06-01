<div class="table-container">
    <?php
    $actionTarget = $studentPanelActionTarget ?? '/classrooms';
    $actionLabel = $studentPanelActionLabel ?? 'Open Classrooms';
    ?>
    <table class="dashboard-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Type</th>
                <th>Course</th>
                <th>Professor</th>
                <th>Deadline</th>
                <th>Max Points</th>
                <th>Status</th>
                <th>Score</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($assignments)): ?>
                <tr>
                    <td colspan="9">No work found for this section.</td>
                </tr>
            <?php endif; ?>
            <?php foreach ($assignments as $assignment): ?>
                <?php
                    $isPending = $assignment['student_status'] === 'Pending';
                    $deadlineHasPassed = strtotime($assignment['deadline']) < time();
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($assignment['title']); ?></td>
                    <td><span class="badge badge-<?php echo strtolower($assignment['assignment_type']); ?>"><?php echo htmlspecialchars($assignment['assignment_type']); ?></span></td>
                    <td><?php echo htmlspecialchars($assignment['course_name']); ?></td>
                    <td><?php echo htmlspecialchars($assignment['professor_name']); ?></td>
                    <td><?php echo date('Y-m-d H:i', strtotime($assignment['deadline'])); ?></td>
                    <td><?php echo $assignment['max_points']; ?></td>
                    <td><span class="badge <?php echo studentPanelStatusClass($assignment['student_status']); ?>"><?php echo htmlspecialchars($assignment['student_status']); ?></span></td>
                    <td>
                        <?php if ($assignment['submission_id']): ?>
                            <?php echo $assignment['score']; ?>/<?php echo $assignment['max_points']; ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($isPending && !$deadlineHasPassed): ?>
                            <a href="<?php echo $actionTarget; ?>" class="btn-action submit">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i> <?php echo htmlspecialchars($actionLabel); ?>
                            </a>
                        <?php elseif ($assignment['submission_id']): ?>
                            <span class="submission-note">Done</span>
                        <?php else: ?>
                            <span class="submission-note">Closed</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
