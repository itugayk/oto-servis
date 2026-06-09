# Dağıtım Rehberi — Coolify

## 1. Coolify uygulaması oluştur
- **Project / Environment:** mevcut proje altında yeni bir **Application** ekle.
- **Source:** bu GitHub reposu, branch **`demo/oto-servis`**.
- **Build Pack:** `Dockerfile` (repo kökündeki `Dockerfile` otomatik kullanılır).
- **Ports Exposes:** `8080` (serversideup/php-fpm-nginx bu portu dinler).
- **Domain:** `https://oto-servis.demo.dijifa.com`

## 2. Ortam değişkenleri (Environment Variables)
| Anahtar | Değer |
|---|---|
| `APP_NAME` | `OtoPro Servis & Kaporta` |
| `APP_ENV` | `production` |
| `APP_KEY` | `base64:...` (aşağıya bak) |
| `APP_DEBUG` | `false` |
| `APP_URL` | `https://oto-servis.demo.dijifa.com` |
| `APP_LOCALE` | `tr` |
| `APP_TIMEZONE` | `Europe/Istanbul` |
| `DB_CONNECTION` | `sqlite` |
| `LOG_LEVEL` | `error` |

`APP_KEY` üret:
```bash
php artisan key:generate --show
# veya
echo "base64:$(openssl rand -base64 32)"
```

## 3. Kalıcı veri (opsiyonel)
SQLite verisinin dağıtımlar arası korunması için Coolify'da bir **Persistent Storage** ekle:
- **Mount path:** `/var/www/html/database`

Eklenmezse her dağıtımda veritabanı sıfırlanır ve seeder demo verisini yeniden yükler (sorun değil).

Yüklenen görsellerin korunması için ayrıca:
- **Mount path:** `/var/www/html/storage/app/public`

## 4. Deploy
- **Deploy** butonuna bas. İlk build birkaç dakika sürebilir (Composer + Vite + imaj).
- Konteyner açılışında migration + seed otomatik çalışır.

## 5. Doğrulama
- `https://oto-servis.demo.dijifa.com` → ana sayfa
- `/randevu` → randevu sihirbazı (uygun slotlar yükleniyor mu?)
- `/admin` → giriş: `admin@otopro.com` / `password` (canlıda mutlaka değiştir)

## Notlar
- İmaj `serversideup/php:8.3-fpm-nginx` tabanlıdır; PHP 8.3 + nginx + php-fpm tek konteyner.
- Başlangıç script'i: `docker/entrypoint.d/99-laravel-init.sh`.
- Production'da `admin@otopro.com` parolasını değiştirmeyi unutma.
