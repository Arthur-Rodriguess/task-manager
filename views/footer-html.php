<script>
    const toggle = document.getElementById('userToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    toggle.addEventListener('click', () => {
        sidebar.classList.add('open');
        overlay.classList.add('show');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
    });
</script>
</body>
</html>