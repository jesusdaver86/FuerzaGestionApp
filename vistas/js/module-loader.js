// vistas/js/module-loader.js

/**
 * Carga scripts dinámicamente según la página actual
 * @param {string} currentPage - Nombre de la página actual (ej: 'usuarios', 'trabajadores')
 * @param {Object} pageScripts - Objeto que mapea páginas con sus scripts requeridos
 */
export const cargarScripts = async (currentPage, pageScripts) => {
  // Scripts comunes que siempre se cargan
  const scriptsBase = [
    'vistas/js/plantilla.js',
    'vistas/main.js'
  ];

  // Scripts específicos para la página actual
  const scriptsPagina = pageScripts[currentPage] || pageScripts['default'] || [];

  // Combinar todos los scripts a cargar
  const todosScripts = [...scriptsBase, ...scriptsPagina];

  // Función para cargar un script individual
  const cargarScript = (src) => {
    return new Promise((resolve, reject) => {
      const script = document.createElement('script');
      script.src = src;
      script.onload = () => {
        console.log(`Script cargado correctamente: ${src}`);
        resolve();
      };
      script.onerror = () => {
        console.error(`Error al cargar script: ${src}`);
        reject(new Error(`Error al cargar script: ${src}`));
      };
      
      // Agregar atributos para mejor rendimiento
      script.defer = true;
      script.crossOrigin = 'anonymous';
      
      document.body.appendChild(script);
    });
  };

  try {
    // Cargar todos los scripts en paralelo (mejor rendimiento)
    await Promise.all(todosScripts.map(cargarScript));
    
    console.log('Todos los scripts se cargaron exitosamente');
  } catch (error) {
    console.error('Error al cargar scripts:', error);
    
    // Mostrar notificación al usuario solo si SweetAlert2 está disponible
    if (typeof Swal !== 'undefined') {
      Swal.fire({
        icon: 'error',
        title: 'Error de carga',
        text: 'Algunos recursos no se cargaron correctamente. Por favor recarga la página.',
        confirmButtonText: 'Recargar',
        allowOutsideClick: false
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.reload();
        }
      });
    } else {
      alert('Error al cargar recursos. Por favor recarga la página.');
    }
  }
};

/**
 * Carga estilos dinámicamente
 * @param {Array<string>} styles - Array de URLs de hojas de estilo
 */
export const cargarEstilos = (styles) => {
  if (!Array.isArray(styles)) {
    console.error('cargarEstilos: El parámetro debe ser un array');
    return;
  }

  styles.forEach(href => {
    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = href;
    link.crossOrigin = 'anonymous';
    document.head.appendChild(link);
  });
};

/**
 * Versión alternativa para navegadores antiguos (sin módulos ES6)
 */
if (!window.AppModules) {
  window.AppModules = {
    cargarScripts: function(currentPage, pageScripts) {
      // Implementación similar pero sin async/await
      // ...
    },
    cargarEstilos: function(styles) {
      // Implementación similar
      // ...
    }
  };
}