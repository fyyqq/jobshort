(function () {
    var root = document.documentElement;

    function isDark() {
        return root.getAttribute('data-theme') === 'dark';
    }

    function apply(dark) {
        if (dark) {
            root.setAttribute('data-theme', 'dark');
            root.setAttribute('data-bs-theme', 'dark');
        } else {
            root.removeAttribute('data-theme');
            root.removeAttribute('data-bs-theme');
        }
        try {
            localStorage.setItem('theme', dark ? 'dark' : 'light');
        } catch (e) {}
        document.querySelectorAll('#darkmode').forEach(function (el) {
            el.checked = dark;
        });
    }

    document.querySelectorAll('#darkmode').forEach(function (el) {
        el.checked = isDark();
        el.addEventListener('change', function () {
            apply(el.checked);
        });
    });

    if (isDark()) root.setAttribute('data-bs-theme', 'dark');
})();
