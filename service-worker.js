// 1. Configuración básica
const CACHE_NAME = 'fuerza-gestion-v3'; // Incremented version
const BASE_PATH = '/fuente/';

// No need to pre-cache everything, as the service worker will cache on the fly.
const ASSETS_TO_PRECACHE = [
  BASE_PATH,
  BASE_PATH + 'index.php'
];

// 2. Instalación: Cachear recursos esenciales
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => cache.addAll(ASSETS_TO_PRECACHE))
      .catch(err => console.log('Error al precachear:', err))
  );
  self.skipWaiting();
});

// 3. Estrategia: Network First for navigation, Cache First for assets
self.addEventListener('fetch', (event) => {
  if (!event.request.url.startsWith('http')) return;

  // Network First for navigation requests (HTML pages)
  if (event.request.mode === 'navigate') {
    event.respondWith(
      fetch(event.request)
        .then(response => {
          const responseClone = response.clone();
          caches.open(CACHE_NAME).then(cache => {
            cache.put(event.request, responseClone);
          });
          return response;
        })
        .catch(() => caches.match(event.request))
    );
    return;
  }

  // Cache First for other assets (CSS, JS, images)
  event.respondWith(
    caches.match(event.request).then((cachedResponse) => {
      return cachedResponse || fetch(event.request).then((response) => {
        if (!response || response.status !== 200 || response.type !== 'basic') {
          return response;
        }
        const responseToCache = response.clone();
        caches.open(CACHE_NAME).then((cache) => {
          cache.put(event.request, responseToCache);
        });
        return response;
      }).catch(error => {
        console.error('Fetching asset failed:', error);
        throw error;
      })
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
