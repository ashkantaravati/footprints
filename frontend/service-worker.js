const CACHE = 'footprints-v1';
const ASSETS = ['/frontend/src/index.html', '/frontend/src/app.js', '/frontend/src/styles.css', '/frontend/manifest.json'];
self.addEventListener('install', event => event.waitUntil(caches.open(CACHE).then(cache => cache.addAll(ASSETS))));
self.addEventListener('fetch', event => {
  if (event.request.method !== 'GET') return;
  event.respondWith(caches.match(event.request).then(cached => cached || fetch(event.request)));
});
