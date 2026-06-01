<?php
include(base_path('views/partials/header.view.php'));
?>

<div class="dashboard-container">
    <div class="main-content mx-auto">
        <div class="top-bar">
            <h2 id="page-title">Edit Student</h2>
            <div class="top-bar-actions">
                <a href="/classrooms#students" class="btn btn-bronze">Back to Classrooms</a>
            </div>
        </div>

        <div class="dashboard-content">
            <section class="dashboard-section active">
                <h3 class="section-title">Edit Student Information</h3>

                <form method="POST" class="enroll-form" style="max-width: 600px;">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="user_name" class="form-control" value="<?php echo htmlspecialchars($student['user_name']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($student['user_email']); ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>House</label>
                            <select name="house_id" class="form-control" required>
                                <?php foreach ($houses as $house): ?>
                                    <option value="<?php echo $house['house_id']; ?>" <?php echo $house['house_id'] == $student['house_id'] ? 'selected' : ''; ?>>
                                        <?php echo $house['house_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Balance</label>
                            <input type="number" name="balance" class="form-control" value="<?php echo $student['balance']; ?>" step="0.01" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="Active" <?php echo $student['status'] === 'Active' ? 'selected' : ''; ?>>Active</option>
                                <option value="Inactive" <?php echo $student['status'] === 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Wand Wood</label>
                            <select name="wood_type" class="form-control" required>
                                <?php foreach (['Holly', 'Yew', 'Elder', 'Willow', 'Hawthorn', 'Oak'] as $wood): ?>
                                    <option value="<?php echo $wood; ?>" <?php echo $student['wood_type'] === $wood ? 'selected' : ''; ?>>
                                        <?php echo $wood; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Wand Core</label>
                            <select name="core_type" class="form-control" required>
                                <?php foreach (['Phoenix Feather', 'Dragon Heartstring', 'Unicorn Hair', 'Thestral Tail Hair'] as $core): ?>
                                    <option value="<?php echo $core; ?>" <?php echo $student['core_type'] === $core ? 'selected' : ''; ?>>
                                        <?php echo $core; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div style="margin-top: 20px;">
                        <button type="submit" class="btn btn-submit">
                            <i class="fa-solid fa-save"></i> Save Changes
                        </button>
                        <a href="/classrooms#students" class="btn btn-bronze" style="margin-left: 10px;">
                            Cancel
                        </a>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>

<?php
include(base_path('views/partials/footer.view.php'));
?>
