<?php include __DIR__ . '/../partials/header.view.php'; ?>
<?php include __DIR__ . '/../partials/nav.view.php'; ?>
<section class="auth-section">
    <div class="auth-card">

        <div class="auth-icon">
            <img src="/assets/img/sorting-hat.png" alt="Sorting Hat">
        </div>

        <h1>Join Hogwarts</h1>
        <p class="auth-subtitle">Create your wizard account</p>

        <?php if (!empty($errors)): ?>
            <div class="alert-magic">
                <?php foreach ($errors as $error): ?>
                    <div>⚠ <?= htmlspecialchars($error) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="sorting-hat-note">
            🎩 The Sorting Hat will assign your house upon registration
        </div>

        <form action="/register" method="POST">

            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                    placeholder="e.g. Harry James Potter"
                    value="<?= htmlspecialchars($old['name'] ?? '') ?>"
                    required
                >
                <?php if (isset($errors['name'])): ?>
                    <div class="invalid-feedback"><?= htmlspecialchars($errors['name']) ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                    placeholder="harry@hogwarts.edu"
                    value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                    required
                >
                <?php if (isset($errors['email'])): ?>
                    <div class="invalid-feedback"><?= htmlspecialchars($errors['email']) ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                    placeholder="Min. 8 characters"
                    minlength="8"
                    required
                >
                <?php if (isset($errors['password'])): ?>
                    <div class="invalid-feedback"><?= htmlspecialchars($errors['password']) ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="form-control <?= isset($errors['password_confirmation']) ? 'is-invalid' : '' ?>"
                    placeholder="Repeat your password"
                    minlength="8"
                    required
                >
                <?php if (isset($errors['password_confirmation'])): ?>
                    <div class="invalid-feedback"><?= htmlspecialchars($errors['password_confirmation']) ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn-submit">
                ✨ Enter the Wizarding World
            </button>

        </form>

        <hr class="auth-divider">

        <p class="auth-footer-text">
            Already have an account? <a href="/login">Log in here</a>
        </p>

    </div>
</section>

<?php include __DIR__ . '/../partials/footer.view.php'; ?>