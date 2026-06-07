// ===== DARK / LIGHT THEME TOGGLE =====
(function () {
    const STORAGE_KEY = 'd5-theme';

    // Apply saved theme immediately (avant le rendu) to avoid flash
    const saved = localStorage.getItem(STORAGE_KEY);
    if (saved === 'dark') {
        document.documentElement.setAttribute('data-theme', 'dark');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('themeToggle');
        if (!btn) return;

        function getTheme() {
            return document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
        }

        function applyTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem(STORAGE_KEY, theme);
            updateButton(theme);
        }

        function updateButton(theme) {
            const icon = btn.querySelector('.theme-icon');
            const label = btn.querySelector('.theme-label');
            if (theme === 'dark') {
                icon.textContent = '☀️';
                label.textContent = 'Clair';
                btn.setAttribute('aria-label', 'Passer en mode clair');
            } else {
                icon.textContent = '🌙';
                label.textContent = 'Sombre';
                btn.setAttribute('aria-label', 'Passer en mode sombre');
            }
        }

        // Init button state
        updateButton(getTheme());

        btn.addEventListener('click', function () {
            const current = getTheme();
            applyTheme(current === 'dark' ? 'light' : 'dark');
        });
    });
})();