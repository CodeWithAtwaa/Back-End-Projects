<?php include(base_path('views/partials/header.view.php')); ?>

<div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h3 class="sidebar-title">Hogwarts</h3>
        </div>
        <nav class="sidebar-nav">
            <a href="/dashboard#dashboard" class="sidebar-link" data-section="dashboard">
                <i class="fa-solid fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
            <a href="/dashboard#students" class="sidebar-link" data-section="students">
                <i class="fa-solid fa-users"></i>
                <span>Students</span>
            </a>
            <a href="/dashboard#professors" class="sidebar-link" data-section="professors">
                <i class="fa-solid fa-chalkboard-user"></i>
                <span>Professors</span>
            </a>
            <a href="/classrooms" class="sidebar-link">
                <i class="fa-solid fa-chalkboard"></i>
                <span>Classrooms</span>
            </a>
            <a href="/leaderboard" class="sidebar-link active">
                <i class="fa-solid fa-trophy"></i>
                <span>Leaderboard</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <h2>House Leaderboard</h2>
            <div class="top-bar-actions">
                <button class="btn btn-bronze" onclick="window.location.href='/'">Go home</button>
                <button class="btn btn-bronze" onclick="window.location.href='/logout'">Logout</button>
            </div>
        </div>

        <div class="dashboard-content mx-auto">
            <div class="lb-container" style="margin: 0; padding: 20px 0 60px;">

                <h2 class="lb-main-title">
                    <i class="fa-solid fa-trophy"></i> House Leaderboard
                </h2>

                <?php
                $houseStyles = [
                  'Gryffindor' => ['bar' => 'linear-gradient(90deg,#c0392b,#e74c3c)', 'badge' => 'lb-griff', 'card' => 'lb-card-griff'],
                  'Slytherin'  => ['bar' => 'linear-gradient(90deg,#1a7a4a,#27ae60)', 'badge' => 'lb-slyth', 'card' => 'lb-card-slyth'],
                  'Ravenclaw'  => ['bar' => 'linear-gradient(90deg,#1a5276,#2980b9)', 'badge' => 'lb-raven', 'card' => 'lb-card-raven'],
                  'Hufflepuff' => ['bar' => 'linear-gradient(90deg,#b7950b,#f1c40f)', 'badge' => 'lb-huffe', 'card' => 'lb-card-huffe'],
                ];
                $maxPts = !empty($houses) ? $houses[0]['total_points'] : 1;
                ?>

                <!-- House Cards -->
                <div class="lb-houses-grid">
                    <?php if (empty($houses)): ?>
                    <p style="color:#5a7090; text-align:center; padding:30px; grid-column:1/-1;">
                        No house data yet.
                    </p>
                    <?php else: ?>
                    <?php foreach ($houses as $i => $house):
                        $style = $houseStyles[$house['house_name']] ?? ['bar' => '#946B2D', 'badge' => '', 'card' => ''];
                        $pct   = $maxPts > 0 ? round($house['total_points'] / $maxPts * 100) : 0;
                    ?>
                    <div class="lb-house-card <?= $style['card'] ?>">
                        <?php
    $medalEmoji = ['👑', '🥈', '🥉', '4️⃣'];
    $medalClass = ['medal-1', 'medal-2', 'medal-3', 'medal-4'];
    ?>
                        <div class="lb-rank-medal <?= $medalClass[$i] ?>">
                            <?= $medalEmoji[$i] ?>
                        </div>
                        <div class="lb-house-name"><?= htmlspecialchars($house['house_name']) ?></div>
                        <div class="lb-house-pts"><?= number_format($house['total_points']) ?></div>
                        <div class="lb-house-label">points</div>
                        <div class="lb-house-label">
                            <?= (int) $house['students_count'] ?> students · <?= (int) $house['scored_submissions'] ?> scores
                        </div>
                        <div class="lb-progress-wrap">
                            <div class="lb-progress-bar" style="width:<?= $pct ?>%; background:<?= $style['bar'] ?>;">
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Top Students -->
                <h3 class="lb-subtitle">
                    <i class="fa-solid fa-user-graduate"></i> Top Students
                </h3>
                <div class="lb-table-wrap">
                    <table class="lb-table">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Student</th>
                                <th>House</th>
                                <th>Points</th>
                                <th>Work</th>
                                <th>Quizzes</th>
                                <th>Assignments</th>
                                <th>Avg Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($students)): ?>
                            <tr>
                                <td colspan="8" style="text-align:center; color:#5a7090; padding:30px;">
                                    No students found yet.
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($students as $i => $s):
                                $rank       = $i + 1;
                                $medalClass = match(true) {
                                    $rank === 1 => 'lb-gold',
                                    $rank === 2 => 'lb-silver',
                                    $rank === 3 => 'lb-bronze',
                                    default     => ''
                                };
                                $rowClass = match(true) {
                                    $rank === 1 => 'lb-row-gold',
                                    $rank === 2 => 'lb-row-silver',
                                    $rank === 3 => 'lb-row-bronze',
                                    default     => ''
                                };
                                $badgeClass = $houseStyles[$s['house']]['badge'] ?? '';
                            ?>
                            <tr class="<?= $rowClass ?>">
                                <td>
                                    <?php if ($rank <= 3): ?>
                                    <span class="lb-medal <?= $medalClass ?>"><?= $rank ?></span>
                                    <?php else: ?>
                                    <span class="lb-rank-plain"><?= $rank ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="lb-student-name"><?= htmlspecialchars($s['name']) ?></td>
                                <td><span
                                        class="lb-badge <?= $badgeClass ?>"><?= htmlspecialchars($s['house']) ?></span>
                                </td>
                                <td class="lb-pts-cell"><?= number_format($s['total_points']) ?></td>
                                <td><?= (int) $s['work_completed'] ?></td>
                                <td><?= $s['quizzes_completed'] ?></td>
                                <td><?= (int) $s['assignments_completed'] ?></td>
                                <td><span class="lb-score"><?= $s['avg_score'] ?>%</span></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include(base_path('views/partials/footer.view.php')); ?>
