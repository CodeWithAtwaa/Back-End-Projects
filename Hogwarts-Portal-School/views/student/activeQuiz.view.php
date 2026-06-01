<?php 
include(base_path('views/partials/header.view.php')); 
include(base_path('views/partials/nav.view.php')); 

$houseNames = [
    1 => ['name' => 'Gryffindor', 'color' => '#740001', 'accent' => '#D3A625'],
    2 => ['name' => 'Slytherin', 'color' => '#1A472A', 'accent' => '#5D5D5D'],
    3 => ['name' => 'Ravenclaw', 'color' => '#0E1A48', 'accent' => '#946B2D'],
    4 => ['name' => 'Hufflepuff', 'color' => '#FFDB00', 'accent' => '#000000'],
];

$houseId = $_SESSION['user']['house_id'] ?? 1;
$theme = $houseNames[$houseId] ?? $houseNames[1];
?>

<section class="py-5" style="background-color: <?= $theme['color'] ?>; min-height: 100vh;">
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        
        <div class="card shadow-lg w-100" style="max-width: 700px; background: rgba(255, 255, 255, 0.95); border: 4px solid <?= $theme['accent'] ?>; border-radius: 15px;">
            <div class="card-body p-5 text-center">
                
                <h6 style="color: <?= $theme['color'] ?>; font-weight: bold; text-transform: uppercase;">
                    <?= htmlspecialchars($assignment['course_name']) ?>
                </h6>
                <h1 class="mb-4" style="font-family: 'Cinzel', serif; color: #333;">
                    <?= htmlspecialchars($assignment['title']) ?>
                </h1>
                
                <p class="text-muted mb-5">
                    Answer carefully. Points awarded will contribute directly to the <?= $theme['name'] ?> House Cup total!
                </p>

                <form action="/submit-quiz" method="POST">
                    <input type="hidden" name="assignment_id" value="<?= $assignment['assignment_id'] ?>">
                    
                    <div class="mb-4 text-start">
                        <label class="form-label fw-bold">Write your magical solution below:</label>
                        <textarea class="form-control" rows="5" name="answer" required placeholder="Cast your spell here..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-lg w-100 fw-bold" style="background-color: <?= $theme['accent'] ?>; color: <?= $houseId == 4 ? '#000' : '#fff' ?>;">
                        Submit & Earn Points
                    </button>
                </form>

            </div>
        </div>

    </div>
</section>

<?php include(base_path('views/partials/footer.view.php')); ?>