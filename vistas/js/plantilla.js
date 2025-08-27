// vistas/js/plantilla.js

/**
 * Configuración inicial del menú sidebar
 */
function inicializarSidebar() {
    if (typeof $.fn.tree === 'function') {
        $('.sidebar-menu').tree();
    } else {
        console.warn('Plugin tree no está disponible');
    }
}

/**
 * Configuración de DataTables con verificación
 */
function inicializarDataTables() {
    if (typeof $.fn.DataTable === 'function') {
        $(".tablas").DataTable({
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
            "responsive": true,
            "autoWidth": false
        });
    } else {
        console.error('DataTables no está cargado correctamente');
        // Fallback básico para tablas
        $(".tablas").addClass('table table-bordered table-striped');
    }
}

/**
 * Configuración de iCheck para checkboxes y radios
 */
function inicializarICheck() {
    if (typeof $.fn.iCheck === 'function') {
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
    } else {
        console.warn('iCheck no está disponible');
    }
}

/**
 * Configuración de input masks
 */
function inicializarInputMasks() {
    if (typeof $.fn.inputmask === 'function') {
        $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
        $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' });
        $('[data-mask]').inputmask();
    } else {
        console.warn('Inputmask no está disponible');
    }
}

/**
 * Ajustes responsivos para el sidebar
 */
function manejarResponsividad() {
    const ajustarSidebar = () => {
        if (window.matchMedia("(max-width:767px)").matches) {
            $("body").removeClass('sidebar-collapse');
        } else {
            $("body").addClass('sidebar-collapse');
        }
    };

    ajustarSidebar();
    $(window).resize(ajustarSidebar);
}

/**
 * Inicialización segura de todos los componentes
 */
function inicializarPlantilla() {
    try {
        // Verificar que jQuery esté cargado
        if (typeof $ === 'undefined') {
            throw new Error('jQuery no está cargado');
        }

        // Esperar a que todos los plugins estén listos
        const interval = setInterval(() => {
            if (typeof $.fn.DataTable !== 'undefined' && 
                typeof $.fn.iCheck !== 'undefined' && 
                typeof $.fn.inputmask !== 'undefined') {
                clearInterval(interval);
                
                inicializarSidebar();
                inicializarDataTables();
                inicializarICheck();
                inicializarInputMasks();
                manejarResponsividad();
                
                console.log('Componentes de plantilla inicializados correctamente');
            }
        }, 100);

        // Timeout por si los plugins no se cargan
        setTimeout(() => {
            if (interval) clearInterval(interval);
        }, 5000);

    } catch (error) {
        console.error('Error al inicializar componentes:', error);
    }
}

// Inicialización cuando el DOM esté listo
$(document).ready(inicializarPlantilla);