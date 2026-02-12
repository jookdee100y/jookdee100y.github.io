self.addEventListener('install', (e) => {
  self.skipWaiting(); // บังคับให้อัปเดตโค้ดใหม่ทันที ห้ามจำของเก่า
});

self.addEventListener('fetch', (e) => {
  // ดึงข้อมูลสดจากเน็ตเสมอ ไม่ต้องเก็บลงแคช จะได้ไม่ค้างหน้าตัวแดง
  e.respondWith(fetch(e.request));
});