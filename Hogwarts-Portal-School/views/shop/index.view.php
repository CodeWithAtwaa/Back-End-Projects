<?php
include __DIR__ . '/../partials/header.view.php';
include __DIR__ . '/../partials/nav.view.php';
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<section class="shop py-5">
    <div class="container">

        <h1 class="text-center text-warning mb-5 shop-title">
            <i class="fa-solid fa-hat-wizard me-2"></i> Diagon Alley Shop
        </h1>

        <?php if (isset($errors['balance'])): ?>
            <div class="alert alert-danger text-center rounded-pill mx-auto mb-4" style="max-width: 500px;">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>
                <?= htmlspecialchars($errors['balance']) ?>
            </div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div class="alert alert-success text-center rounded-pill mx-auto mb-4" style="max-width: 500px;">
                <i class="fa-solid fa-check-circle me-2"></i>
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <?php if (!empty($items)): ?>
                <?php foreach ($items as $item): ?>

                    <?php
                    $type = strtolower($item['item_type'] ?? '');
                    $iconClass = 'fa-magic';
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

                            <span class="badge bg-warning text-dark item-type-badge text-uppercase">
                                <?= htmlspecialchars($item['item_type']) ?>
                            </span>

                            <div class="item-icon-wrapper">
                                <i class="fa-solid <?= $iconClass ?> item-icon" style="color: <?= $iconColor ?>;"></i>
                            </div>

                            <div class="card-body text-center d-flex flex-column">
                                <h4 class="card-title text-warning fw-bold mb-3">
                                    <?= htmlspecialchars($item['item_name']) ?>
                                </h4>

                                <p class="card-text mb-4 price-text">
                                    <i class="fa-solid fa-coins galleon-icon me-1"></i>
                                    <?= htmlspecialchars($item['item_price']) ?>
                                    <span class="fs-6 text-muted">Galleons</span>
                                </p>

                                <form method="POST" action="/shop/buy" class="mt-auto">
                                    <input type="hidden" name="item_id" value="<?= $item['item_id'] ?>">
                                    <button type="submit" class="btn btn-outline-warning w-100 buy-btn">
                                        <i class="fa-solid fa-bag-shopping me-2"></i> Buy
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center text-white py-5">
                    <h3>No items available in the shop right now.</h3>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>

<?php require __DIR__ . '/../partials/footer.view.php'; ?>
