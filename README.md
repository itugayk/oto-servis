# OtoPro Servis & Kaporta

Premium oto servis & kaporta-boya kurumsal sitesi + online servis randevu sistemi + yönetim paneli.

**Stack:** Laravel 12 · Filament 3 · Livewire 3 · Tailwind CSS 4 · Alpine.js

Demo: https://oto-servis.demo.dijifa.com · Yönetim: `/admin`

---

## Özellikler

### Public site
- **Ana Sayfa** — hero, animasyonlu sayaçlar, hizmet grid'i, "neden biz", marka şeridi, galeri, yorumlar, blog, CTA
- **Hizmetler** — liste + her hizmet için detay sayfası (kapsam, SSS, fiyat/süre)
- **Servis Randevusu** — 4 adımlı Livewire formu: hizmet → araç → tarih & uygun slot → iletişim
- **Markalar** — uzmanlık notlarıyla marka grid'i
- **Galeri** — kategori filtreli atölye/iş galerisi
- **Blog** — bakım ipuçları, kategori & detay sayfaları
- **İletişim** — bilgiler, harita, Livewire iletişim formu
- **SEO** — `AutoRepair`, `Service` ve `BlogPosting` JSON-LD yapısal verileri

### Randevu motoru
`App\Services\AppointmentAvailability` çalışma saatleri + slot kapasitesine göre uygun saatleri hesaplar;
geçmiş ve dolu slotları otomatik kapatır, gönderim anında son kontrolle çift rezervasyonu önler.

### Yönetim paneli (`/admin`)
- **Randevular** — durum yönetimi (Bekliyor / İşlemde / Tamamlandı / İptal), hizmet & duruma göre filtre, hızlı durum aksiyonu, bekleyen randevu rozeti
- **Hizmetler** — CRUD, ikon seçimi, kapsam & SSS repeater'ları, sürükle-bırak sıralama
- **Markalar / Galeri / Blog / Yorumlar** — tam CRUD; yorum moderasyonu (tek tık onay)
- **Çalışma Saatleri & Kapasite** — gün bazlı açık/kapalı, saat aralığı ve slot kapasitesi
- **Site Ayarları** — iletişim, sosyal medya, sayaçlar, görseller
- **Dashboard** — randevu istatistik widget'ı

---

## Yerel kurulum

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
```

Yönetim girişi: **admin@otopro.com** / **password**

---

## Dağıtım (Coolify / Docker)

Repo çok aşamalı bir `Dockerfile` içerir (Composer → Vite build → `serversideup/php:8.3-fpm-nginx`).
Konteyner başlangıcında `docker/entrypoint.d/99-laravel-init.sh` çalışır: SQLite hazırlığı,
`migrate --seed`, `storage:link` ve config/route/view cache. Ayrıntılar: [README-DEPLOY.md](README-DEPLOY.md).

Seeder'lar idempotent (`updateOrCreate`) olduğundan her dağıtımda güvenle yeniden çalışır.

Görseller `public/images/auto/` altında repo ile birlikte gelir — site dış bağımlılık olmadan çalışır.
