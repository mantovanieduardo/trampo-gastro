// Trampo Gastro - Service Worker
const CACHE_NAME = 'trampo-gastro-v1';
const STATIC_ASSETS = [
    '/',
    '/dashboard',
];

self.addEventListener('install', function(event) {
    event.waitUntil(
        caches.open(CACHE_NAME).then(function(cache) {
            return cache.addAll(STATIC_ASSETS).catch(function() {
                // Ignore cache errors during install
            });
        })
    );
    self.skipWaiting();
});

self.addEventListener('activate', function(event) {
    event.waitUntil(
        caches.keys().then(function(cacheNames) {
            return Promise.all(
                cacheNames.filter(function(name) {
                    return name !== CACHE_NAME;
                }).map(function(name) {
                    return caches.delete(name);
                })
            );
        })
    );
    self.clients.claim();
});

self.addEventListener('fetch', function(event) {
    // Only handle GET requests
    if (event.request.method !== 'GET') return;

    // Skip API/auth requests
    const url = new URL(event.request.url);
    if (url.pathname.startsWith('/api') || url.pathname.startsWith('/login') || url.pathname.startsWith('/logout')) {
        return;
    }

    event.respondWith(
        fetch(event.request).then(function(response) {
            // Cache successful responses for static assets
            if (response.ok && (url.pathname.match(/\.(js|css|png|jpg|svg|woff2?)$/))) {
                const responseClone = response.clone();
                caches.open(CACHE_NAME).then(function(cache) {
                    cache.put(event.request, responseClone);
                });
            }
            return response;
        }).catch(function() {
            // Serve from cache when offline
            return caches.match(event.request).then(function(cached) {
                if (cached) return cached;
                // Return offline page if available
                return caches.match('/');
            });
        })
    );
});
