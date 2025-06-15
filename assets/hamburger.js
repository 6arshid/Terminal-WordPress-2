document.addEventListener('DOMContentLoaded', function() {
    var trigger = document.getElementById('farshid_hamburger');
    var sidebar = document.getElementById('farshid_sidebar');
    if (!trigger || !sidebar) {
        return;
    }

    trigger.addEventListener('click', function() {
        sidebar.classList.toggle('open');
    });
});
