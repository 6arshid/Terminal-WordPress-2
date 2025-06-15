(function() {
    const trigger = document.getElementById('farshid_hamburger');
    const sidebar = document.getElementById('farshid_sidebar');
    if (!trigger || !sidebar) {
        return;
    }

    trigger.addEventListener('click', function(e) {
        e.preventDefault();
        sidebar.classList.toggle('open');
    });

    document.addEventListener('click', function(e) {
        if (!sidebar.contains(e.target) && e.target !== trigger && sidebar.classList.contains('open')) {
            sidebar.classList.remove('open');
        }
    });
})();
