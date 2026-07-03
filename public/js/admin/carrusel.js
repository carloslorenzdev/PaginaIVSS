document.addEventListener('DOMContentLoaded', function() {
    const toggleBtns = document.querySelectorAll('.btn-toggle-edit');
    
    toggleBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const display = document.getElementById('title-display-' + id);
            const form = document.getElementById('form-edit-' + id);
            
            if (form && display) {
                if (form.classList.contains('hidden')) {
                    form.classList.remove('hidden');
                    display.classList.add('hidden');
                    // Foco al input titulo
                    setTimeout(() => form.querySelector('input[name="titulo"]').focus(), 50);
                } else {
                    form.classList.add('hidden');
                    display.classList.remove('hidden');
                }
            }
        });
    });
});
