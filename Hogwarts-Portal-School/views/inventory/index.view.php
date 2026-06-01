<?php require __DIR__ . '/../partials/header.view.php'; ?>
<?php require __DIR__ . '/../partials/nav.view.php'; ?>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<section class="inventory py-5">
    <div class="container">

        <h1 class="text-center text-warning mb-3 page-title">
            <i class="fa-solid fa-box-open me-2"></i> Your Inventory
        </h1>

        <?php if (isset($success)): ?>
            <div class="alert alert-success text-center rounded-pill mx-auto mb-4" style="max-width: 500px;">
                <i class="fa-solid fa-check-circle me-2"></i>
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <!-- Balance Badge -->
        <div class="text-center mb-5">
            <span class="badge bg-warning text-dark fs-6 px-4 py-2 rounded-pill">
                <i class="fa-solid fa-coins me-2"></i>
                Balance: <?= htmlspecialchars($balance) ?> Galleons
            </span>
        </div>

        <!-- ======= WAND SECTION ======= -->
        <?php if ($wand): ?>
            <h2 class="text-center text-warning mb-4 section-label">
                <i class="fa-solid fa-wand-magic-sparkles me-2"></i> Your Wand
            </h2>

            <div class="row justify-content-center mb-2">
                <div class="col-md-4">
                    <div class="wand-card shadow-lg">

                        <span class="wand-ollivanders-badge">
                            <i class="fa-solid fa-store me-1"></i> Ollivander's
                        </span>

                        <span class="wand-unique-badge">
                            <i class="fa-solid fa-star me-1"></i> Unique
                        </span>

                        <div class="wand-icon-wrapper">
                            <i class="fa-solid fa-wand-magic-sparkles wand-icon"></i>
                        </div>

                        <div class="card-body text-center text-white p-4">

                            <h4 class="text-warning fw-bold mb-1" style="font-family: Georgia, serif;">
                                <?= htmlspecialchars($wand['wood_type']) ?> Wand
                            </h4>

                            <p class="text-muted small mb-4">
                                Crafted by Ollivander himself
                            </p>

                            <div class="d-flex gap-3 justify-content-center">
                                <div class="wand-stat">
                                    <div class="wand-stat-label">
                                        <i class="fa-solid fa-tree me-1"></i> Wood
                                    </div>
                                    <div class="wand-stat-value">
                                        <?= htmlspecialchars($wand['wood_type']) ?>
                                    </div>
                                </div>
                                <div class="wand-stat">
                                    <div class="wand-stat-label">
                                        <i class="fa-solid fa-meteor me-1"></i> Core
                                    </div>
                                    <div class="wand-stat-value">
                                        <?= htmlspecialchars($wand['core_type']) ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <hr class="section-divider">

        <!-- ======= ITEMS SECTION ======= -->
        <h2 class="text-center text-warning mb-4 section-label">
            <i class="fa-solid fa-bag-shopping me-2"></i> Purchased Items
        </h2>

        <?php if (!empty($items)): ?>
            <div class="row g-4">
                <?php foreach ($items as $item): ?>

                    <?php
                    $type      = strtolower($item['item_type'] ?? '');
                    $iconClass = 'fa-star';
                    $iconColor = '#9b59b6';

                    if (strpos($type, 'potion') !== false) {
                        $iconClass = 'fa-flask';
                        $iconColor = '#2ecc71';
                    } elseif (strpos($type, 'book') !== false) {
                        $iconClass = 'fa-book-journal-whills';
                        $iconColor = '#3498db';
                    } elseif (strpos($type, 'broom') !== false) {
                        $iconClass = 'fa-broom';
                        $iconColor = '#e67e22';
                    }
                    ?>

                    <div class="col-md-4">
                        <div class="card text-white shadow magical-card h-100 position-relative">

                            <span class="quantity-badge">
                                <?= htmlspecialchars($item['quantity'] ?? 0) ?>x
                            </span>

                            <span class="badge bg-warning text-dark item-type-badge text-uppercase">
                                <?= htmlspecialchars($item['item_type'] ?? 'Unknown') ?>
                            </span>

                            <div class="item-icon-wrapper">
                                <i class="fa-solid <?= $iconClass ?> item-icon" style="color: <?= $iconColor ?>;"></i>
                            </div>

                            <div class="card-body text-center d-flex flex-column">

                                <h4 class="card-title text-warning fw-bold mb-3">
                                    <?= htmlspecialchars($item['item_name']) ?>
                                </h4>

                                <p class="card-text mb-2 price-text">
                                    <i class="fa-solid fa-coins galleon-icon me-1"></i>
                                    <?= htmlspecialchars($item['item_price'] ?? 0) ?>
                                    <span class="fs-6 text-muted">Galleons</span>
                                </p>

                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>

        <?php else: ?>
            <div class="empty-inventory text-center">
                <i class="fa-solid fa-ghost empty-icon mb-4"></i>
                <h3 class="text-warning mb-3 fw-bold">No Items Yet!</h3>
                <p class="text-light mb-4">You haven't purchased any magical items yet. Go to the shop to fill your bag.</p>
                <a href="/shop" class="btn btn-warning px-5 py-2 rounded-pill fw-bold text-dark">
                    <i class="fa-solid fa-store me-2"></i> Visit Shop
                </a>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php require __DIR__ . '/../partials/footer.view.php'; ?>