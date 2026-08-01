const themeStorageKey = "warungku-theme";

const syncThemeButtons = () => {
    const isDark = document.documentElement.classList.contains("dark");

    document.querySelectorAll("[data-theme-toggle]").forEach((button) => {
        const lightIcon = button.querySelector("[data-theme-icon-light]");
        const darkIcon = button.querySelector("[data-theme-icon-dark]");

        if (lightIcon) {
            lightIcon.classList.toggle("hidden", isDark);
        }

        if (darkIcon) {
            darkIcon.classList.toggle("hidden", !isDark);
        }
    });
};

const applyTheme = (theme) => {
    const root = document.documentElement;
    const isDark = theme === "dark";

    root.classList.toggle("dark", isDark);
    root.style.colorScheme = theme;
    localStorage.setItem(themeStorageKey, theme);
    syncThemeButtons();
};

const initializeTheme = () => {
    const storedTheme = localStorage.getItem(themeStorageKey);
    const prefersDark = window.matchMedia(
        "(prefers-color-scheme: dark)",
    ).matches;
    const initialTheme = storedTheme ?? (prefersDark ? "dark" : "light");

    applyTheme(initialTheme);
};

const toggleTheme = () => {
    const currentTheme = document.documentElement.classList.contains("dark")
        ? "dark"
        : "light";
    applyTheme(currentTheme === "dark" ? "light" : "dark");
};

window.toggleTheme = toggleTheme;

const handleThemeNavigation = () => {
    initializeTheme();
};

document.addEventListener("DOMContentLoaded", handleThemeNavigation);
document.addEventListener("livewire:navigated", handleThemeNavigation);
window.addEventListener("pageshow", handleThemeNavigation);

document.addEventListener("click", (event) => {
    const button = event.target.closest("[data-theme-toggle]");

    if (button) {
        event.preventDefault();
        toggleTheme();
    }
});

window
    .matchMedia("(prefers-color-scheme: dark)")
    .addEventListener("change", (event) => {
        if (!localStorage.getItem(themeStorageKey)) {
            applyTheme(event.matches ? "dark" : "light");
        }
    });
