const version = 3;
let CACHE_NAME = 'my-cv-cache';
var urlsToCache = [
  '/',
  '/js',
  '/fonts',
  '/res/Icons'
];

self.addEventListener('install', function(event) {
  // Perform install steps
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(function(cache) {
        console.log('Opened cache');
        return cache.addAll(urlsToCache);
      })
  );
  
  self.skipWaiting();
});

self.addEventListener('activate', function(event) {
  console.log('SW v%s Activated at', version, new Date().toLocaleTimeString());
});

self.addEventListener('fetch', function(event) {
  if(!navigator.online) { 
    event.respondWith(new Response('<h1> Offline </h1>', {
      headers: {
        'Content-Type': 'text/html'
      }
    }))
  } else {
    event.respondWith(
      caches.match(event.request)
        .then(function(response) {
          // Cache hit - return response
          if (response) {
            return response;
          }
          return fetch(event.request);
        }
      )
    );
  }

    // event.respondWith(fetch(event.request));
    // event.respondWith(new Response('<h1> Offline </h1>', { 
    //   headers: {
    //     'Content-Type': 'text/html'
    //   } })
});