</div><!-- Fin main-content -->

<!-- Bootstrap JS Bundle -->
<script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>

<script>
    // Toggle sidebar mobile
    document.getElementById('sidebarToggle')?.addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('show');
    });

    // Fermer sidebar en cliquant à l'extérieur
    document.addEventListener('click', function(e) {
        const sidebar = document.getElementById('sidebar');
        const toggle = document.getElementById('sidebarToggle');
        if (window.innerWidth < 768 && sidebar.classList.contains('show')) {
            if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        }
    });
</script>
</body>
</html>