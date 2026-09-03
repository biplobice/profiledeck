// The address is base64 in the markup so harvesters that never run JS cannot read it.
document.querySelectorAll('[data-email]').forEach((element) => {
    element.addEventListener('click', () => {
        window.location.href = `mailto:${atob(element.dataset.email)}`;
    });
});
