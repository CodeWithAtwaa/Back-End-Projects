<?php include __DIR__ . '/../partials/header.view.php'; ?>
<?php include __DIR__ . '/../partials/nav.view.php'; ?>
<section class="auth-section">
    <div class="auth-card">

        <div class="auth-icon">
            <img src="/assets/img/sorting-hat.png" alt="Sorting Hat">
        </div>

        <h1>Welcome Back</h1>
        <p class="auth-subtitle">Enter your credentials to access Hogwarts</p>

        <?php if (!empty($success)): ?>
            <div class="alert-magic-success">
                ✅ <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert-magic">
                <?php foreach ($errors as $error): ?>
                    <div>⚠ <?= htmlspecialchars($error) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="/login" method="POST" >

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
                    placeholder="Min. 6 characters"
                    minlength="6"
                    required
                >
                <?php if (isset($errors['password'])): ?>
                    <div class="invalid-feedback"><?= htmlspecialchars($errors['password']) ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn-submit">
                🔮 Enter the Great Hall
            </button>

        </form>

        <hr class="alert-divider" style="border-color: rgba(255,215,0,0.15); margin: 1.4rem 0;">

        <p class="auth-footer-text">
            New to Hogwarts? <a href="/register">Create your account</a>
        </p>

    </div>
</section>

<?php include __DIR__ . '/../partials/footer.view.php'; ?>