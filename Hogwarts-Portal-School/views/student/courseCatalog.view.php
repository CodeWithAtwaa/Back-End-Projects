<?php include(base_path('views/partials/header.view.php')); ?>
<?php include(base_path('views/partials/nav.view.php')); ?>

<section class="py-5" style="background: linear-gradient(135deg, #2E1A47 0%, #1C0E3A 100%); min-height: 100vh;">
    <div class="container">
        <h1 class="text-center text-warning mb-5" style="font-family: 'Dancing Script', cursive;">Available Courses</h1>
        
        <div class="row g-4">
            <?php if (empty($courses)): ?>
                <div class="col-12 text-center text-light">You are enrolled in all available courses!</div>
            <?php endif; ?>

            <?php foreach ($courses as $course): ?>
                <div class="col-md-4">
                    <div class="card bg-dark text-white border-warning h-100 shadow">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-book-journal-whills fa-3x text-warning mb-3"></i>
                            <h4 class="card-title text-warning"><?= htmlspecialchars($course['course_name']) ?></h4>
                            <p class="card-text text-muted">Prof. <?= htmlspecialchars($course['professor_name']) ?></p>
                            
                            <form action="/enroll-course" method="POST">
                                <input type="hidden" name="course_id" value="<?= $course['course_id'] ?>">
                                <button type="submit" class="btn btn-outline-warning w-100 mt-3">Enroll Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include(base_path('views/partials/footer.view.php')); ?>