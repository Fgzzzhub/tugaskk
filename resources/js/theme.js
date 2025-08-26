export function toggleTheme() {
    const root = document.documentElement;
    const isDark = root.classList.toggle('dark');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
    }
    
    
    export function initThemeToggle(selector = '[data-toggle-theme]') {
    document.addEventListener('click', (e) => {
    const btn = e.target.closest(selector);
    if (!btn) return;
    toggleTheme();
    });
    }
    
    
    // Auto-init
    initThemeToggle();