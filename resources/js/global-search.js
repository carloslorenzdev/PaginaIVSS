document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('global-search-input');
        
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                const query = this.value.toLowerCase();
                
                // Busca todas las tarjetas o filas que tengan la clase .searchable-item, exceptuando botones y enlaces sueltos
                const items = document.querySelectorAll('.searchable-item:not(button):not(a)');
                
                items.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    if (text.includes(query)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }
    });