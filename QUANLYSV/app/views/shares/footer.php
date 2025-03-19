</div>
    <footer class="footer mt-auto py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <span class="text-muted">© <?php echo date('Y'); ?> Hệ thống Sinh viên</span>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="text-muted text-decoration-none me-2">
                        <i class="fas fa-question-circle"></i> Trợ giúp
                    </a>
                    <a href="#" class="text-muted text-decoration-none">
                        <i class="fas fa-info-circle"></i> Về chúng tôi
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JavaScript -->
    <script src="/php/QUANLYSV/public/js/main.js"></script>
    <script>
        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                if (alert && alert.parentNode) {
                    alert.classList.add('fade');
                    setTimeout(() => alert.remove(), 300);
                }
            });
        }, 5000);
    </script>
</body>
</html>
