</div> </div> <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        // Toggle Sidebar
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar, #content').toggleClass('active');
        });

        // Auto-active Link
        var path = window.location.href;
        $('.nav-link').each(function() {
            if (this.href === path) {
                $(this).addClass('active');
            }
        });
    });
</script>
</body>
</html>