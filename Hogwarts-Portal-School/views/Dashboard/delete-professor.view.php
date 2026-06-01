<?php
include(base_path('views/partials/header.view.php'));
?>

<div class="dashboard-container">
    <div class="main-content mx-auto">
        <div class="top-bar">
            <h2 id="page-title">Delete Professor</h2>
            <div class="top-bar-actions">
                <a href="/dashboard" class="btn btn-bronze">Back to Dashboard</a>
            </div>
        </div>

        <div class="dashboard-content">
            <section class="dashboard-section active">
                <h3 class="section-title">Confirm Professor Removal</h3>

                <div class="student-details" style="max-width: 700px;">
                    <div class="detail-row">
                        <label>Professor:</label>
                        <span><?php echo htmlspecialchars($professor['professor_name']); ?></span>
                    </div>
                    <div class="detail-row">
                        <label>Email:</label>
                        <span><?php echo htmlspecialchars($professor['email']); ?></span>
                    </div>
                    <div class="detail-row">
                        <label>Courses:</label>
                        <span><?php echo $professor['courses_count']; ?></span>
                    </div>
                </div>

                <?php if ((int) $professor['courses_count'] > 0): ?>
                    <p style="margin-top: 20px; color: #856404;">This professor still has assigned courses. Move or delete those courses first.</p>
                    <a href="/dashboard" class="btn btn-bronze">Back to Dashboard</a>
                <?php else: ?>
                    <form method="POST" style="margin-top: 30px;">
                        <button type="submit" class="btn btn-danger" style="background-color: #d32f2f;">
                            <i class="fa-solid fa-trash"></i> Delete Professor
                        </button>
                        <a href="/show-professor?id=<?php echo $professor['professor_id']; ?>" class="btn btn-bronze" style="margin-left: 10px;">Cancel</a>
                    </form>
                <?php endif; ?>
            </section>
        </div>
    </div>
</div>

<?php
include(base_path('views/partials/footer.view.php'));
?>
