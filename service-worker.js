// 1. Configuración básica
const CACHE_NAME = 'fuerza-gestion-v1';
const BASE_PATH = '/fuente/';  // Ajusta según tu estructura

// Archivos esenciales para cachear (rutas relativas a /fuente/)
const ASSETS = [
  BASE_PATH,
  BASE_PATH + 'index.php',
  BASE_PATH + 'assets/css/styles.css',
  BASE_PATH + 'assets/js/app.js',
  BASE_PATH + 'assets/icons/icon-192x192.png',
  BASE_PATH + 'assets/icons/icon-512x512.png',
  // Añade más rutas según necesites
];

// 2. Instalación: Cachear recursos esenciales
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => cache.addAll(ASSETS))
      .catch(err => console.log('Error al cachear:', err))
  );
});

// 3. Estrategia: Cache First, luego red
self.addEventListener('fetch', (event) => {
  if (!event.request.url.startsWith('http')) return;

  event.respondWith(
    caches.match(event.request)
      .then((cachedResponse) => {
        // Devuelve del cache si existe
        if (cachedResponse) return cachedResponse;
        
        // Si no, haz petición a red
        return fetch(event.request)
          .then((response) => {
            // Opcional: Cachear nuevas respuestas
            const responseClone = response.clone();
            caches.open(CACHE_NAME)
              .then((cache) => cache.put(event.request, responseClone));
            return response;
          });
      })
  );
});

// 4. Limpieza de caches antiguos
self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((cache) => {
          if (cache !== CACHE_NAME) return caches.delete(cache);
        })
      );
    })
  );
});