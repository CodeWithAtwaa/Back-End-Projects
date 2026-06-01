<?php include(base_path('views/partials/header.view.php')); ?>
<?php include(base_path('views/partials/nav.view.php')); ?>

<section class="py-5" style="background: linear-gradient(135deg, #0E1A40 0%, #0A1429 100%); min-height: 100vh;">
    <div class="container">
        <?php if (isset($success)): ?>
            <div class="alert alert-success text-center rounded-pill mx-auto mb-4" style="max-width: 500px;">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <h1 class="text-center text-warning mb-5" style="font-family: 'Dancing Script', cursive;">My Classrooms</h1>

        <h3 class="text-light border-bottom border-warning pb-2 mb-4">Pending Assignments & Quizzes</h3>
        <div class="row g-4 mb-5">
            <?php if (empty($assignments)): ?>
                <p class="text-muted">You have no pending assignments. Great job!</p>
            <?php endif; ?>

            <?php foreach ($assignments as $task): ?>
                <div class="col-md-6">
                    <div class="card bg-dark text-light border-danger shadow">
                        <div class="card-body">
                            <span class="badge bg-danger float-end"><?= htmlspecialchars($task['assignment_type']) ?></span>
                            <h5 class="text-warning"><?= htmlspecialchars($task['title']) ?></h5>
                            <p class="small text-muted mb-3"><?= htmlspecialchars($task['course_name']) ?></p>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-danger small"><i class="fa-solid fa-clock"></i> Due: <?= date('M d, Y H:i', strtotime($task['deadline'])) ?></span>
                                <a href="/take-quiz?id=<?= $task['assignment_id'] ?>" class="btn btn-warning btn-sm text-dark fw-bold">Start</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <h3 class="text-light border-bottom border-warning pb-2 mb-4">My Courses</h3>
        <div class="row g-4">
            <?php if (empty($courses)): ?>
                <p class="text-muted">You are not enrolled in any courses. <a href="/course-catalog" class="text-warning">Browse catalog.</a></p>
            <?php endif; ?>

            <?php foreach ($courses as $course): ?>
                <div class="col-md-4">
                    <div class="card bg-secondary text-white shadow">
                        <div class="card-body text-center">
                            <h5 class="text-warning"><?= htmlspecialchars($course['course_name']) ?></h5>
                            <p class="small text-light mb-0">Prof. <?= htmlspecialchars($course['professor_name']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include(base_path('views/partials/footer.view.php')); ?>
