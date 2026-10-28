const VERSION='chmuzuch-pwa-v1';
const STATIC=[ '/', '/offline.html', '/pwa-icon.svg', '/manifest.webmanifest' ];
self.addEventListener('install',event=>{event.waitUntil(caches.open(VERSION).then(cache=>cache.addAll(STATIC)));self.skipWaiting();});
self.addEventListener('activate',event=>{event.waitUntil(Promise.all([caches.keys().then(keys=>Promise.all(keys.filter(key=>key.startsWith('chmuzuch-pwa-')&&key!==VERSION).map(key=>caches.delete(key)))),self.clients.claim()]));});
self.addEventListener('fetch',event=>{
 const req=event.request;
 if(req.method!=='GET'||new URL(req.url).origin!==self.location.origin)return;
 const url=new URL(req.url);
 if(url.pathname.startsWith('/admin')||url.pathname.startsWith('/login')||url.pathname.startsWith('/logout')||url.pathname.startsWith('/api')||url.pathname.startsWith('/storage/')||url.pathname.includes('csrf')||url.pathname.endsWith('.stl'))return;
 if(req.mode==='navigate'){
  event.respondWith(fetch(req).then(response=>response).catch(async()=>await caches.match(req)||await caches.match('/offline.html')));
  return;
 }
 if(url.pathname.startsWith('/build/')||['.css','.js','.svg','.png','.jpg','.webp','.woff2'].some(ext=>url.pathname.endsWith(ext))){
  event.respondWith(caches.match(req).then(cached=>cached||fetch(req).then(response=>{if(response.ok){const copy=response.clone();caches.open(VERSION).then(cache=>cache.put(req,copy));}return response;})));
 }
});