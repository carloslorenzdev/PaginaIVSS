(function() {
    function initAOS() {
        if (typeof AOS === 'undefined') return;

        AOS.init({
            duration: 750,
            easing: 'ease-out-cubic',
            once: false,
            offset: 40,
            delay: 30,
        });

        if (typeof AOS.refreshHard === 'function') {
            AOS.refreshHard();
        } else {
            AOS.refresh();
        }
    }

    if (document.readyState !== 'loading') {
        initAOS();
    } else {
        document.addEventListener("DOMContentLoaded", initAOS);
    }

    document.addEventListener("livewire:navigated", function() {
        setTimeout(function() {
            initAOS();
        }, 30);
    });
})();
