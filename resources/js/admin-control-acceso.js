import { ToastAlert } from './toastify.js';

(function() {
    function initModule() {
    // Checkbox global para grupo
    const groupCheckboxes = document.querySelectorAll('.check-grupo');
    
    groupCheckboxes.forEach(function(groupCheckbox) {
        const grupo = groupCheckbox.getAttribute('data-grupo');
        const permisos = document.querySelectorAll('.checkbox-grupo-' + grupo);
        
        // Set initial state of group checkbox based on children (ON if ANY child is checked)
        groupCheckbox.checked = Array.from(permisos).some(cb => cb.checked);

        // Click event on group checkbox
        groupCheckbox.addEventListener('change', function() {
            const isChecked = groupCheckbox.checked;
            
            permisos.forEach(function(permiso) {
                permiso.checked = isChecked;
            });

            // Mostrar alerta visual
            const nombreModulo = grupo.replace(/_/g, ' ').toUpperCase();
            if (isChecked) {
                ToastAlert(['success', {
                    mensaje: `Módulo Activado`,
                    ayuda: `Se han habilitado todos los permisos para el módulo de ${nombreModulo}. El rol ahora tiene control total sobre esta sección.`
                }]);
            } else {
                ToastAlert(['danger', {
                    mensaje: `Módulo Deshabilitado por Seguridad`,
                    ayuda: `Se han revocado todos los permisos de ${nombreModulo}. El rol ya no podrá visualizar ni acceder a esta sección en el panel.`
                }]);
            }
        });

        // Update group checkbox when a child is clicked
        permisos.forEach(function(permiso) {
            permiso.addEventListener('change', function() {
                // If at least one permission is checked, the module should remain ON
                groupCheckbox.checked = Array.from(permisos).some(cb => cb.checked);
            });
        });
    });

    // Marcar todos
    const btnMarcarTodos = document.getElementById('btn-marcar-todos');
    if (btnMarcarTodos) {
        btnMarcarTodos.addEventListener('click', function() {
            document.querySelectorAll('.permiso-checkbox').forEach(cb => cb.checked = true);
            groupCheckboxes.forEach(cb => { cb.checked = true; });
            ToastAlert(['success', { mensaje: 'Permisos Totales', ayuda: 'Se han concedido todos los permisos disponibles al rol.' }]);
        });
    }

    // Desmarcar todos
    const btnDesmarcarTodos = document.getElementById('btn-desmarcar-todos');
    if (btnDesmarcarTodos) {
        btnDesmarcarTodos.addEventListener('click', function() {
            document.querySelectorAll('.permiso-checkbox').forEach(cb => cb.checked = false);
            groupCheckboxes.forEach(cb => { cb.checked = false; });
            ToastAlert(['warning', { mensaje: 'Permisos Revocados', ayuda: 'Se han retirado todos los permisos del rol. Su acceso será nulo.' }]);
        });
    }
    }

    if (document.readyState !== 'loading') {
        initModule();
    } else {
        document.addEventListener('DOMContentLoaded', initModule);
    }
    document.addEventListener('turbo:load', initModule);
})();
