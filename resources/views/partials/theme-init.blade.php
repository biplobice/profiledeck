<script>
    (() => {
        const saved = localStorage.getItem('profiledeck-theme');
        const theme = saved === 'light' || saved === 'dark'
            ? saved
            : (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

        document.documentElement.dataset.theme = theme;
        document.documentElement.style.colorScheme = theme;
    })();
</script>
