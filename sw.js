const CACHE_NAME = 'atlas-cache-v3';
const urlsToCache = [
  'offline.html',
  'assets/bootstrap-4.5.3-dist/css/bootstrap.min.css',
  'assets/fontawesome-free-5.15.1-web/css/all.min.css',
  'assets/fontawesome-free-5.15.1-web/webfonts/fa-brands-400.woff2',
  'assets/fontawesome-free-5.15.1-web/webfonts/fa-regular-400.woff2',
  'assets/fontawesome-free-5.15.1-web/webfonts/fa-solid-900.woff2',
  'assets/js/jquery-3.5.1.min.js',
  'assets/js/popper.min.js',
  'assets/bootstrap-4.5.3-dist/js/bootstrap.min.js',
  'assets/js/axios.min.js',
  'assets/js/vue.js',
  'assets/js/vue.min.js',
  'assets/js/componentes.js',
  'assets/js/cronograma.js',
  'assets/js/filtro_actividades.js',
  'assets/js/item_actividad.js',
  'assets/js/mixins.js',
  'assets/js/proyecto.js',
  'assets/js/proyecto_componentes.js'
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

self.addEventListener('push', function (event) {
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        return;
    }

    const sendNotification = body => {
        const title = "Atlas";
        return self.registration.showNotification(title, {
            body,
        });
    };

    if (event.data) {
        const message = event.data.text();
        event.waitUntil(sendNotification(message));
    }
});
