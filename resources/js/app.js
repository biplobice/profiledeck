const root = document.documentElement;
const themeButtons = document.querySelectorAll('[data-theme-toggle]');
const menuButton = document.querySelector('[data-menu-toggle]');
const menu = document.querySelector('[data-menu]');
const progress = document.querySelector('[data-reading-progress]');

const preferredTheme = () => {
    const saved = localStorage.getItem('profiledeck-theme');

    if (saved === 'light' || saved === 'dark') {
        return saved;
    }

    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
};

const syncThemeButtons = (theme) => {
    const nextTheme = theme === 'dark' ? 'light' : 'dark';

    themeButtons.forEach((button) => {
        button.setAttribute('aria-label', `Use ${nextTheme} theme`);
        button.setAttribute('title', `Use ${nextTheme} theme`);
    });
};

const setTheme = (theme) => {
    root.dataset.theme = theme;
    root.style.colorScheme = theme;
    syncThemeButtons(theme);
};

setTheme(preferredTheme());

themeButtons.forEach((button) => {
    button.addEventListener('click', () => {
        const nextTheme = root.dataset.theme === 'dark' ? 'light' : 'dark';

        localStorage.setItem('profiledeck-theme', nextTheme);
        setTheme(nextTheme);
    });
});

menuButton?.addEventListener('click', () => {
    const isOpen = menu?.classList.toggle('is-open');

    menuButton.setAttribute('aria-expanded', String(Boolean(isOpen)));
});

menu?.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => {
        menu.classList.remove('is-open');
        menuButton?.setAttribute('aria-expanded', 'false');
    });
});

if (progress) {
    const updateProgress = () => {
        const height = document.documentElement.scrollHeight - window.innerHeight;
        const percent = height > 0 ? Math.min(100, (window.scrollY / height) * 100) : 0;

        progress.style.width = `${percent}%`;
    };

    updateProgress();
    window.addEventListener('scroll', updateProgress, { passive: true });
    window.addEventListener('resize', updateProgress);
}

// The address is base64 in the markup so harvesters that never run JS cannot read it.
document.querySelectorAll('[data-email]').forEach((element) => {
    element.addEventListener('click', () => {
        window.location.href = `mailto:${atob(element.dataset.email)}`;
    });
});
