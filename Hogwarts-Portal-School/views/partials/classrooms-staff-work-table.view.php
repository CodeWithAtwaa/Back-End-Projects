<div class="table-container">
    <table class="dashboard-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Type</th>
                <th>Course</th>
                <th>Professor</th>
                <th>Max Points</th>
                <th>Deadline</th>
                <th>Submissions</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($staffWorkItems)): ?>
                <tr>
                    <td colspan="9">No work found for this section.</td>
                </tr>
            <?php endif; ?>
            <?php foreach ($staffWorkItems as $assignment): ?>
                <tr>
                    <td><?php echo $assignment['assignment_id']; ?></td>
                    <td><?php echo htmlspecialchars($assignment['title']); ?></td>
                    <td><span class="badge badge-<?php echo strtolower($assignment['assignment_type']); ?>"><?php echo htmlspecialchars($assignment['assignment_type']); ?></span></td>
                    <td><?php echo htmlspecialchars($assignment['course_name']); ?></td>
                    <td><?php echo htmlspecialchars($assignment['professor_name']); ?></td>
                    <td><?php echo $assignment['max_points']; ?></td>
                    <td><?php echo date('Y-m-d H:i', strtotime($assignment['deadline'])); ?></td>
                    <td><?php echo $assignment['submission_count']; ?></td>
                    <td>
                        <a href="/show-assignment?id=<?php echo $assignment['assignment_id']; ?>" class="btn-action show">View</a>
                        <?php if ($canManageCourses): ?>
                            <a href="/edit-assignment?id=<?php echo $assignment['assignment_id']; ?>" class="btn-action edit">Edit</a>
                            <a href="/delete-assignment?id=<?php echo $assignment['assignment_id']; ?>" class="btn-action delete">Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
