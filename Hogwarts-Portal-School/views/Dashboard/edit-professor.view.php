<?php
include(base_path('views/partials/header.view.php'));
?>

<div class="dashboard-container">
    <div class="main-content mx-auto">
        <div class="top-bar">
            <h2 id="page-title">Edit Professor</h2>
            <div class="top-bar-actions">
                <a href="/dashboard" class="btn btn-bronze">Back to Dashboard</a>
            </div>
        </div>

        <div class="dashboard-content">
            <section class="dashboard-section active">
                <h3 class="section-title">Edit Professor Information</h3>

                <form method="POST" class="enroll-form" style="max-width: 700px;">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="user_name" class="form-control" value="<?php echo htmlspecialchars($professor['user_name']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($professor['email']); ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Professor Display Name</label>
                            <input type="text" name="professor_name" class="form-control" value="<?php echo htmlspecialchars($professor['professor_name']); ?>" required>
                        </div>
                    </div>

                    <div style="margin-top: 20px;">
                        <button type="submit" class="btn btn-submit">
                            <i class="fa-solid fa-save"></i> Save Changes
                        </button>
                        <a href="/show-professor?id=<?php echo $professor['professor_id']; ?>" class="btn btn-bronze" style="margin-left: 10px;">Cancel</a>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>

<?php
include(base_path('views/partials/footer.view.php'));
?>
