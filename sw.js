const CACHE_NAME = 'atlas-cache-v2';
const urlsToCache = [
  'offline.html',
  'assets/node_modules/bootstrap/dist/css/bootstrap.min.css',
  'assets/fontawesome-free-5.12.0-web/css/all.min.css',
  'assets/fontawesome-free-5.12.0-web/webfonts/fa-brands-400.woff2',
  'assets/fontawesome-free-5.12.0-web/webfonts/fa-regular-400.woff2',
  'assets/fontawesome-free-5.12.0-web/webfonts/fa-solid-900.woff2',
  'assets/node_modules/axios/dist/axios.min.js',
  'assets/node_modules/vue/dist/vue.js',
  'assets/node_modules/vue/dist/vue.min.js',
  'assets/node_modules/@popperjs/core/dist/umd/popper.min.js',
  'assets/js/componentes.js',
  'assets/js/proyecto_componentes.js',
  'assets/js/proyecto.js'
];

self.addEventListener('install', function(evt) {
  evt.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
        return cache.addAll(urlsToCache);
      })
  );
  self.skipWaiting();
});

self.addEventListener('activate', (evt) => {
  evt.waitUntil(
    caches.keys().then((keyList) => {
      return Promise.all(keyList.map((key) => {
        if (key !== CACHE_NAME) {
          return caches.delete(key);
        }
      }));
    })
  );
  self.clients.claim();
});

self.addEventListener('fetch', (evt) => {
  if (evt.request.mode !== 'navigate') {
    return;
  }
  evt.respondWith(
    fetch(evt.request)
    .catch(() => {
      return caches.open(CACHE_NAME)
      .then((cache) => {
        return cache.match('offline.html');
      });
    })
  );
});