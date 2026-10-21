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
        } else if (typeof AOS.refresh === 'function') {
            AOS.refresh();
        }
    }

    window.initAOS = initAOS;

    if (document.readyState !== 'loading') {
        initAOS();
    } else {
        document.addEventListener("DOMContentLoaded", initAOS);
    }

    document.addEventListener("livewire:navigated", function() {
        initAOS();
        setTimeout(initAOS, 50);
        setTimeout(initAOS, 200);
    });
})();
