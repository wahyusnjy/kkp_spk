/**
 * Theme Toggle System
 * Manages dark/light mode with localStorage persistence
 * Default: dark mode
 */

document.addEventListener('DOMContentLoaded', function () {
    // Initialize theme
    initializeTheme();

    // Add event listeners to toggle buttons
    setupThemeToggle();
});

function initializeTheme() {
    // Get saved theme from localStorage, default to 'dark'
    const savedTheme = localStorage.getItem('theme') || 'dark';

    // Apply theme
    applyTheme(savedTheme);
}

function applyTheme(theme) {
    const html = document.documentElement;

    if (theme === 'dark') {
        html.classList.add('dark');
    } else {
        html.classList.remove('dark');
    }

    // Save to localStorage
    localStorage.setItem('theme', theme);

    // Update toggle button icons if they exist
    updateToggleButtons(theme);
}

function setupThemeToggle() {
    // Listen for clicks on theme toggle buttons
    document.addEventListener('click', function (e) {
        const toggleButton = e.target.closest('[data-theme-toggle]');
        if (toggleButton) {
            toggleTheme();
        }
    });
}

function toggleTheme() {
    const currentTheme = localStorage.getItem('theme') || 'dark';
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

    applyTheme(newTheme);
}

function updateToggleButtons(theme) {
    const buttons = document.querySelectorAll('[data-theme-toggle]');
    buttons.forEach(button => {
        const icon = button.querySelector('i');
        if (icon) {
            if (theme === 'dark') {
                icon.className = 'fa-solid fa-sun';
                button.setAttribute('title', 'Switch to Light Mode');
            } else {
                icon.className = 'fa-solid fa-moon';
                button.setAttribute('title', 'Switch to Dark Mode');
            }
        }
    });
}

// Export for external use
window.toggleTheme = toggleTheme;
window.applyTheme = applyTheme;
