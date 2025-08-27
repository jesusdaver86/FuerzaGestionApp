// vistas/main.js - Versión optimizada y corregida

/**
 * Módulo principal de la aplicación - Funciones globales y comunes
 */

// =============================================
// Configuración Global Mejorada
// =============================================
const App = {
    /**
     * Inicializa la aplicación
     */
    init: function() {
        try {
            this.setupAjaxDefaults();
            this.setupGlobalEvents();
            this.checkSessionStatus();
            this.setupUIComponents();
            this.setupErrorHandling();
            console.log('Aplicación inicializada correctamente');
        } catch (error) {
            console.error('Error al inicializar la aplicación:', error);
            this.showInitError();
        }
    },

    // =============================================
    // Configuración AJAX mejorada con manejo seguro
    // =============================================
    setupAjaxDefaults: function() {
        try {
            const csrfToken = window.appConfig?.csrfToken || 
                             $('meta[name="csrf-token"]').attr('content') || 
                             '';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                beforeSend: function() {
                    $('#global-loader')?.fadeIn();
                },
                complete: function() {
                    $('#global-loader')?.fadeOut();
                },
                error: this.handleAjaxError
            });
        } catch (error) {
            console.error('Error configurando AJAX:', error);
        }
    },

    // =============================================
    // Eventos globales con delegación mejorada
    // =============================================
    setupGlobalEvents: function() {
        // Manejo de confirmaciones con delegación
        $(document).on('click', '[data-confirm]', (e) => {
            const message = $(e.currentTarget).data('confirm') || '¿Estás seguro de realizar esta acción?';
            if (!confirm(message)) {
                e.preventDefault();
                e.stopImmediatePropagation();
                return false;
            }
        });

        // Cierre de alertas
        $(document).on('click', '[data-dismiss="alert"]', (e) => {
            $(e.currentTarget).closest('.alert').fadeOut(300, function() {
                $(this).remove();
            });
        });

        // Auto-cierre de alertas después de 5 segundos
        $('.alert-auto-dismiss').each(function() {
            setTimeout(() => {
                $(this).fadeOut(300, () => $(this).remove());
            }, 5000);
        });
    },

    // =============================================
    // Manejo de sesión mejorado
    // =============================================
    checkSessionStatus: function() {
        $(document).ajaxError((event, jqxhr) => {
            if (jqxhr.status === 401) {
                this.showSessionExpired();
            }
        });
    },

    // =============================================
    // Componentes UI con verificación de existencia
    // =============================================
    setupUIComponents: function() {
        // Tooltips
        if ($.fn.tooltip) {
            $('[data-toggle="tooltip"]').tooltip({
                trigger: 'hover',
                container: 'body',
                delay: { show: 300, hide: 100 }
            });
        }

        // Popovers
        if ($.fn.popover) {
            $('[data-toggle="popover"]').popover({
                trigger: 'focus',
                container: 'body'
            });
        }

        // Select2
        if ($.fn.select2) {
            $('.select2').select2({
                language: 'es',
                minimumResultsForSearch: 5,
                width: '100%',
                dropdownAutoWidth: true
            });
        }
    },

    // =============================================
    // Manejo de errores centralizado
    // =============================================
    setupErrorHandling: function() {
        window.onerror = (message, source, lineno, colno, error) => {
            console.error('Error global:', { message, source, lineno, colno, error });
            return true; // Previene el mensaje de error por defecto
        };
    },

    // =============================================
    // Métodos utilitarios
    // =============================================
    showSessionExpired: function() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: 'Sesión expirada',
                text: 'Tu sesión ha expirado. Serás redirigido para iniciar sesión nuevamente.',
                timer: 3000,
                timerProgressBar: true,
                willClose: () => {
                    window.location.href = 'login';
                }
            });
        } else {
            alert('Tu sesión ha expirado. Serás redirigido al login.');
            window.location.href = 'login';
        }
    },

    showInitError: function() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Error de inicialización',
                text: 'Hubo un problema al cargar la aplicación. Por favor recarga la página.',
                allowOutsideClick: false,
                confirmButtonText: 'Recargar'
            }).then(() => {
                window.location.reload();
            });
        } else {
            alert('Error al cargar la aplicación. Por favor recarga la página.');
        }
    },

    handleAjaxError: function(jqXHR, textStatus, errorThrown) {
        console.error('AJAX Error:', { jqXHR, textStatus, errorThrown });
        
        let errorMsg = 'Error en la solicitud. Por favor intente nuevamente.';
        if (jqXHR.responseJSON?.message) {
            errorMsg = jqXHR.responseJSON.message;
        }
        
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMsg,
                confirmButtonText: 'Entendido'
            });
        } else {
            alert(errorMsg);
        }
    },

    formatCurrency: function(amount) {
        try {
            return new Intl.NumberFormat('es-VE', {
                style: 'currency',
                currency: 'USD',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(amount);
        } catch (error) {
            console.error('Error formateando moneda:', error);
            return '$' + parseFloat(amount).toFixed(2);
        }
    }
};

// =============================================
// Inicialización segura
// =============================================
$(document).ready(function() {
    // Verificar dependencias antes de iniciar
    if (typeof $ !== 'undefined' && typeof jQuery !== 'undefined') {
        App.init();
    } else {
        console.error('jQuery no está cargado correctamente');
        document.addEventListener('DOMContentLoaded', App.init.bind(App));
    }
});

// =============================================
// Exportación para módulos (opcional)
// =============================================
if (typeof exports !== 'undefined') {
    exports.App = App;
} else {
    window.App = App;
    window.formatCurrency = App.formatCurrency;
    window.handleAjaxError = App.handleAjaxError;
}