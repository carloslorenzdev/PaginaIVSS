const html = document.querySelector('html');
const mediaColorSchema = window.matchMedia('(prefers-color-scheme: dark)');
const isLightOrAuto = localStorage.getItem('hs_theme') === 'light' || (localStorage.getItem('hs_theme') === 'auto' && !mediaColorSchema.matches);
const isDarkOrAuto = localStorage.getItem('hs_theme') === 'dark' || (localStorage.getItem('hs_theme') === 'auto' && mediaColorSchema.matches);

if (isLightOrAuto && html.classList.contains('dark')) {
    html.classList.remove('dark');
} else if (isDarkOrAuto && html.classList.contains('light')) {
    html.classList.remove('light');
} else if (isDarkOrAuto && !html.classList.contains('dark')) {
    html.classList.add('dark');
} else if (isLightOrAuto && !html.classList.contains('light')) {
    html.classList.add('light');
} else {
    if (mediaColorSchema.matches) {
        // COLOR OSCURO POR DEFECTO
        html.classList.remove('light');
        html.classList.add('dark');
        localStorage.setItem('hs_theme', 'dark');
    } else {
        html.classList.remove('dark');
        html.classList.add('light');
        localStorage.setItem('hs_theme', 'light');
    }
}
