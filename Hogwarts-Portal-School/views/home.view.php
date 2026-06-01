<?php
$header = "Home";
include 'partials/header.view.php';
include 'partials/nav.view.php';
?>

<main>

    <section class="home-hero" id="home">
        <div class="star-field" aria-hidden="true">
            <span></span><span></span><span></span><span></span><span></span>
        </div>

        <div class="hero-inner">
            <div class="hero-copy">
                <span class="hero-kicker">Witchcraft, wizardry, and house glory</span>
                <h1>Hogwarts School</h1>
                <p>
                    Learn spells, join courses, complete quizzes and tasks, submit work before the deadline,
                    and lift your house on the leaderboard.
                </p>
                <div class="hero-actions">
                    <?php if (is_student()): ?>
                        <a href="/student-panel#assignments" class="hero-button primary">
                            <i class="fa-solid fa-paper-plane"></i>
                            Submit Work
                        </a>
                    <?php elseif (is_staff()): ?>
                        <a href="/classrooms" class="hero-button primary">
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                            Manage Classes
                        </a>
                    <?php else: ?>
                        <a href="/register" class="hero-button primary">
                            <i class="fa-solid fa-hat-wizard"></i>
                            Join Hogwarts
                        </a>
                    <?php endif; ?>
                    <a href="/leaderboard" class="hero-button secondary">
                        <i class="fa-solid fa-ranking-star"></i>
                        House Cup
                    </a>
                </div>
            </div>

            <div class="hero-stage" aria-hidden="true">
                <img class="hero-castle" src="/assets/img/castle.jpg" alt="">
                <img class="hero-hat" src="/assets/img/sorting-hat.png" alt="">
                <img class="hero-snitch" src="/assets/img/snitch.png" alt="">
                <img class="hero-wand" src="/assets/img/magic-wand.png" alt="">
            </div>
        </div>

        <div class="hero-house-strip">
            <span>Gryffindor</span>
            <span>Slytherin</span>
            <span>Ravenclaw</span>
            <span>Hufflepuff</span>
        </div>
    </section>

    <section class="home-feature-band" id="about">
        <div class="feature-intro">
            <span>Inside the portal</span>
            <h2>Everything students need for class work and house points.</h2>
        </div>

        <div class="feature-grid">
            <div class="feature-card">
                <i class="fa-solid fa-book-open"></i>
                <h3>Enroll in courses</h3>
                <p>Students can discover classes, join active courses, and track every quiz, task, and assignment.</p>
            </div>
            <div class="feature-card">
                <i class="fa-solid fa-paper-plane"></i>
                <h3>Submit before deadlines</h3>
                <p>On-time submissions immediately earn points and push the student's house higher.</p>
            </div>
            <div class="feature-card">
                <i class="fa-solid fa-ranking-star"></i>
                <h3>Compete for the cup</h3>
                <p>House totals update through the points ledger, making the leaderboard feel alive.</p>
            </div>
            <div class="feature-card">
                <i class="fa-solid fa-chalkboard-user"></i>
                <h3>Professor tools</h3>
                <p>Staff can create courses, tasks, quizzes, assignments, and review submissions.</p>
            </div>
        </div>
    </section>

    <section class="submission-showcase" id="services">
        <div class="showcase-panel">
            <div>
                <span class="hero-kicker">New student workflow</span>
                <h2>From pending work to house points in one click.</h2>
            </div>
            <div class="showcase-steps">
                <div><strong>01</strong><span>Choose an open quiz, task, or assignment.</span></div>
                <div><strong>02</strong><span>Submit while the deadline is still active.</span></div>
                <div><strong>03</strong><span>Earn full points for your house automatically.</span></div>
            </div>
        </div>
    </section>


</main>

<?php
include 'partials/footer.view.php';
?>
