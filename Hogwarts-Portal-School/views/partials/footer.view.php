<!-- Footer -->
<footer class="site-footer">
    <div class="container-fluid footer-inner">
        <div class="row align-items-center">
            <div class="col-12 col-md-9 footer-copy">
                <p>&copy; 2023 Hogwarts School of Witchcraft and Wizardry. All rights reserved.</p>
            </div>
            <div class="col-12 col-md-3 footer-logo text-center text-md-end">
                <img src="/assets/img/sorting-hat.png" alt="Hogwarts logo">
            </div>
        </div>
    </div>
</footer>

<!-- boostrap 5  cdn -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>

<!-- Custom JS for Navbar Toggler -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggler = document.querySelector('.navbar-toggler');
        const collapseElement = document.querySelector('#navbarNavAltMarkup');
        const navbar = document.querySelector('.navbar');

        // Initialize Bootstrap Collapse
        const bsCollapse = new bootstrap.Collapse(collapseElement, {
            toggle: false
        });

        toggler.addEventListener('click', function() {
            // Toggle using Bootstrap's Collapse
            bsCollapse.toggle();

            // Toggle a custom class for extra animation
            navbar.classList.toggle('navbar-expanded');

            // Optional: Log to console
            console.log('Navbar toggler clicked!');

            // Optional: Add a brief glow effect
            navbar.style.boxShadow = navbar.classList.contains('navbar-expanded') ?
                '0 4px 12px rgba(255, 215, 0, 0.5)' :
                '0 4px 8px rgba(0, 0, 0, 0.3)';
        });
    });
</script>
</body>

</html>