<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Brand;
use App\Models\BlogPost;
use App\Models\GalleryItem;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\WorkingHour;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /** Curated, visually-verified automotive imagery (bundled locally for a self-contained demo). */
    private function img(string $id, int $w = 1200): string
    {
        return "/images/auto/{$id}.jpg";
    }

    public function run(): void
    {
        $this->seedAdmin();
        $this->seedSettings();
        $this->seedWorkingHours();
        $this->seedServices();
        $this->seedBrands();
        $this->seedGallery();
        $this->seedTestimonials();
        $this->seedBlog();
        $this->seedAppointments();
    }

    private function seedAdmin(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@otopro.com'],
            ['name' => 'OtoPro Admin', 'password' => Hash::make('password')]
        );
    }

    private function seedSettings(): void
    {
        $settings = [
            'site_name' => 'OtoPro Servis & Kaporta',
            'tagline' => 'Aracınız emin ellerde',
            'phone' => '+90 212 555 0 117',
            'whatsapp' => '905555550117',
            'email' => 'info@otopro.com',
            'address' => 'Oto Sanayi Sitesi 4. Blok No:12, Bağcılar / İstanbul',
            'map_embed' => 'https://www.google.com/maps?q=Bagcilar+Istanbul&output=embed',
            'working_text' => 'Hafta içi 09:00 - 18:00 · Cumartesi 09:00 - 14:00',
            'instagram' => 'https://instagram.com',
            'facebook' => 'https://facebook.com',
            'youtube' => 'https://youtube.com',
            'stat_years' => '18',
            'stat_vehicles' => '24000',
            'stat_experts' => '12',
            'stat_warranty' => '24',
            'hero_image' => $this->img('1486006920555-c77dcf18193c', 1600),
            'about_image' => $this->img('1530046339160-ce3e530c7d2f', 1200),
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }

    private function seedWorkingHours(): void
    {
        $rows = [
            ['day' => 1, 'is_open' => true,  'open_time' => '09:00', 'close_time' => '18:00', 'slot_minutes' => 60, 'capacity' => 3],
            ['day' => 2, 'is_open' => true,  'open_time' => '09:00', 'close_time' => '18:00', 'slot_minutes' => 60, 'capacity' => 3],
            ['day' => 3, 'is_open' => true,  'open_time' => '09:00', 'close_time' => '18:00', 'slot_minutes' => 60, 'capacity' => 3],
            ['day' => 4, 'is_open' => true,  'open_time' => '09:00', 'close_time' => '18:00', 'slot_minutes' => 60, 'capacity' => 3],
            ['day' => 5, 'is_open' => true,  'open_time' => '09:00', 'close_time' => '18:00', 'slot_minutes' => 60, 'capacity' => 3],
            ['day' => 6, 'is_open' => true,  'open_time' => '09:00', 'close_time' => '14:00', 'slot_minutes' => 60, 'capacity' => 2],
            ['day' => 0, 'is_open' => false, 'open_time' => '09:00', 'close_time' => '14:00', 'slot_minutes' => 60, 'capacity' => 0],
        ];

        foreach ($rows as $row) {
            WorkingHour::updateOrCreate(['day' => $row['day']], $row);
        }
    }

    private function seedServices(): void
    {
        $services = [
            [
                'name' => 'Periyodik Bakım',
                'icon' => 'clipboard-document-check',
                'summary' => 'Üretici standartlarında periyodik bakım: yağ, filtre, fren ve 40 nokta kontrolü.',
                'image' => $this->img('1487754180451-c456f719a1fc'),
                'price_from' => 1500,
                'duration_min' => 90,
                'is_featured' => true,
                'sort_order' => 1,
                'features' => [
                    'Motor yağı ve yağ filtresi değişimi',
                    'Hava, polen ve yakıt filtresi kontrolü',
                    'Fren balata ve disk kontrolü',
                    '40 noktada dijital araç raporu',
                    'Akü ve şarj sistemi testi',
                ],
                'description' => "Aracınızın ömrünü uzatan en önemli işlem düzenli periyodik bakımdır. OtoPro'da tüm bakım işlemleri üretici servis kitabına uygun olarak, orijinal veya OEM eşdeğeri parçalarla yapılır. İşlem sonunda aracınızın güncel durumunu gösteren dijital bir rapor teslim edilir.",
                'faqs' => [
                    ['q' => 'Periyodik bakım ne sıklıkla yapılmalı?', 'a' => 'Genellikle her 15.000 km veya yılda bir kez önerilir; aracınızın kullanım kılavuzundaki değerler esas alınır.'],
                    ['q' => 'Orijinal parça kullanıyor musunuz?', 'a' => 'Evet, talebe göre orijinal veya OEM eşdeğeri parça kullanıyor, her ikisinde de garanti veriyoruz.'],
                ],
            ],
            [
                'name' => 'Mekanik Onarım',
                'icon' => 'wrench-screwdriver',
                'summary' => 'Motor, şanzıman, debriyaj ve süspansiyon onarımları uzman ekiple.',
                'image' => $this->img('1619642751034-765dfdf7c58e'),
                'price_from' => 2000,
                'duration_min' => 180,
                'is_featured' => true,
                'sort_order' => 2,
                'features' => [
                    'Motor revizyonu ve triger seti değişimi',
                    'Şanzıman ve debriyaj onarımı',
                    'Süspansiyon ve direksiyon sistemi',
                    'Soğutma ve turbo sistemleri',
                    'Test sürüşü ile kalite kontrol',
                ],
                'description' => "Deneyimli teknisyen kadromuz ve üretici diagnostik cihazlarımızla en karmaşık mekanik arızaları doğru teşhis eder, kalıcı şekilde çözeriz. Tüm onarımlar işçilik garantisi kapsamındadır.",
                'faqs' => [
                    ['q' => 'Onarım öncesi fiyat veriyor musunuz?', 'a' => 'Evet, arıza tespitinin ardından onayınız olmadan işleme başlamıyoruz.'],
                ],
            ],
            [
                'name' => 'Kaporta & Boya',
                'icon' => 'sparkles',
                'summary' => 'Fırın boya, göçük düzeltme ve kaza sonrası komple kaporta onarımı.',
                'image' => $this->img('1493238792000-8113da705763'),
                'price_from' => 3500,
                'duration_min' => 480,
                'is_featured' => true,
                'sort_order' => 3,
                'features' => [
                    'Fırın boya ile orijinal renk uyumu',
                    'Boyasız göçük düzeltme (PDR)',
                    'Kaza sonrası komple kaporta',
                    'Sigorta anlaşmalı onarım süreci',
                    'Seramik kaplama ve pasta-cila',
                ],
                'description' => "Profesyonel boyahane ekipmanlarımız ve renk eşleştirme sistemimizle aracınızı ilk günkü görünümüne kavuşturuyoruz. Sigorta hasar süreçlerinizi de baştan sona biz yönetiyoruz.",
                'faqs' => [
                    ['q' => 'Boya garantiniz var mı?', 'a' => 'Tüm boya işlemlerimiz 2 yıl renk ve tutunma garantilidir.'],
                    ['q' => 'Sigorta ile çalışıyor musunuz?', 'a' => 'Tüm sigorta şirketleriyle anlaşmalıyız, ekspertiz sürecini sizin için takip ediyoruz.'],
                ],
            ],
            [
                'name' => 'Lastik & Rot Balans',
                'icon' => 'lifebuoy',
                'summary' => 'Lastik değişimi, rot ayarı, balans ve mevsimlik lastik oteli.',
                'image' => $this->img('1568605117036-5fe5e7bab0b7'),
                'price_from' => 800,
                'duration_min' => 45,
                'sort_order' => 4,
                'features' => [
                    'Lastik satış ve montajı',
                    'Bilgisayarlı rot ve balans ayarı',
                    'Nitrojen gazı dolumu',
                    'Mevsimlik lastik oteli (saklama)',
                    'Jant doğrultma ve tamiri',
                ],
                'description' => "Bilgisayarlı rot-balans cihazlarımızla aracınızın yol tutuşunu ve lastik ömrünü optimize ediyoruz. Mevsimlik lastiklerinizi uygun koşullarda saklayan lastik otelimizden faydalanabilirsiniz.",
                'faqs' => [
                    ['q' => 'Lastiklerimi saklıyor musunuz?', 'a' => 'Evet, lastik otelimizde nem ve sıcaklık kontrollü ortamda güvenle saklıyoruz.'],
                ],
            ],
            [
                'name' => 'Elektronik & Arıza Tespiti',
                'icon' => 'cpu-chip',
                'summary' => 'Beyin (ECU) testi, arıza tespit cihazı ile hızlı ve doğru teşhis.',
                'image' => $this->img('1558618666-fcd25c85cd64'),
                'price_from' => 1000,
                'duration_min' => 60,
                'sort_order' => 5,
                'features' => [
                    'OBD-II arıza kodu okuma ve silme',
                    'ECU / beyin yazılımı ve testi',
                    'Sensör ve aktüatör kontrolü',
                    'Aydınlatma ve multimedya sistemleri',
                    'Akü ve marş-şarj sistemi analizi',
                ],
                'description' => "Modern araçların elektronik mimarisi uzmanlık gerektirir. Üretici seviyesindeki arıza tespit cihazlarımızla motor arıza lambası, sensör hataları ve elektronik problemleri kısa sürede teşhis ediyoruz.",
                'faqs' => [
                    ['q' => 'Motor arıza lambası yanıyor, ne yapmalıyım?', 'a' => 'En kısa sürede arıza tespiti yaptırın; cihazla okuma yaparak sorunun kaynağını netleştiriyoruz.'],
                ],
            ],
        ];

        foreach ($services as $data) {
            Service::updateOrCreate(['slug' => Str::slug($data['name'])], $data);
        }
    }

    private function seedBrands(): void
    {
        $brands = [
            ['name' => 'BMW', 'note' => 'Motronic & N/B serisi motor uzmanlığı'],
            ['name' => 'Mercedes-Benz', 'note' => 'Star Diagnosis ile tam teşhis'],
            ['name' => 'Audi', 'note' => 'TFSI / TDI ve DSG şanzıman'],
            ['name' => 'Volkswagen', 'note' => 'VAG grubu yazılım ve bakım'],
            ['name' => 'Ford', 'note' => 'EcoBoost ve PowerShift servisi'],
            ['name' => 'Renault', 'note' => 'Clip diagnostik desteği'],
            ['name' => 'Fiat', 'note' => 'Multijet dizel motor bakımı'],
            ['name' => 'Toyota', 'note' => 'Hybrid sistem sertifikalı bakım'],
            ['name' => 'Hyundai', 'note' => 'GDS ile garanti uyumlu işlem'],
            ['name' => 'Peugeot', 'note' => 'PureTech & BlueHDi uzmanlığı'],
            ['name' => 'Opel', 'note' => 'Tech2 diagnostik'],
            ['name' => 'Honda', 'note' => 'VTEC motor servisi'],
        ];

        foreach ($brands as $i => $b) {
            Brand::updateOrCreate(
                ['slug' => Str::slug($b['name'])],
                ['name' => $b['name'], 'note' => $b['note'], 'sort_order' => $i, 'is_active' => true]
            );
        }
    }

    private function seedGallery(): void
    {
        $items = [
            ['title' => 'Servis bakım alanı', 'category' => 'Atölye', 'image' => '1486006920555-c77dcf18193c'],
            ['title' => 'Mekanik onarım istasyonu', 'category' => 'Atölye', 'image' => '1530046339160-ce3e530c7d2f'],
            ['title' => 'Motor revizyonu', 'category' => 'Mekanik', 'image' => '1619642751034-765dfdf7c58e'],
            ['title' => 'Arıza tespit & diagnostik', 'category' => 'Mekanik', 'image' => '1558618666-fcd25c85cd64'],
            ['title' => 'Boya & kaporta sonrası', 'category' => 'Kaporta', 'image' => '1493238792000-8113da705763'],
            ['title' => 'Teslim edilen araç', 'category' => 'Araçlar', 'image' => '1605559424843-9e4c228bf1c2'],
            ['title' => 'Showroom teslim', 'category' => 'Araçlar', 'image' => '1494976388531-d1058494cdd8'],
            ['title' => 'Detaylı temizlik', 'category' => 'Araçlar', 'image' => '1568844293986-8d0400bd4745'],
        ];

        foreach ($items as $i => $it) {
            GalleryItem::updateOrCreate(
                ['title' => $it['title']],
                [
                    'category' => $it['category'],
                    'image' => $this->img($it['image'], 1000),
                    'sort_order' => $i,
                    'is_active' => true,
                ]
            );
        }
    }

    private function seedTestimonials(): void
    {
        $items = [
            ['name' => 'Mehmet Yılmaz', 'vehicle' => 'BMW 320i', 'rating' => 5, 'body' => 'Periyodik bakımımı yaptırdım, her şeyi tek tek anlattılar ve rapor verdiler. Fiyatlar şeffaf, işçilik kusursuz.'],
            ['name' => 'Ayşe Demir', 'vehicle' => 'VW Golf', 'rating' => 5, 'body' => 'Kaza sonrası kaportamı buraya emanet ettim. Aracım ilk günkü gibi oldu, sigorta işlemlerini de onlar halletti.'],
            ['name' => 'Caner Aksoy', 'vehicle' => 'Ford Focus', 'rating' => 5, 'body' => 'Motor arıza lambası yanıyordu, başka yerlerde çözemediler. Burada cihazla teşhis edip aynı gün hallettiler.'],
            ['name' => 'Zeynep Kara', 'vehicle' => 'Audi A3', 'rating' => 4, 'body' => 'Randevu sistemi çok pratik, beklemeden işlem yaptırdım. Ekip ilgili ve güler yüzlü.'],
            ['name' => 'Burak Şahin', 'vehicle' => 'Mercedes C180', 'rating' => 5, 'body' => 'Yıllardır aracımı sadece buraya getiriyorum. Orijinal parça ve garanti konusunda içim çok rahat.'],
            ['name' => 'Elif Yıldız', 'vehicle' => 'Renault Megane', 'rating' => 5, 'body' => 'Lastik değişimi ve rot balans için gittim, çok hızlıydılar. Lastik oteli hizmeti de harika.'],
        ];

        foreach ($items as $i => $t) {
            Testimonial::updateOrCreate(
                ['name' => $t['name'], 'body' => $t['body']],
                array_merge($t, ['is_approved' => true, 'is_featured' => $i < 3])
            );
        }
    }

    private function seedBlog(): void
    {
        $posts = [
            [
                'title' => 'Kışa Girerken Aracınızda Kontrol Etmeniz Gereken 7 Şey',
                'category' => 'Mevsimlik Bakım',
                'image' => '1517524008697-84bbe3c3fd98',
                'excerpt' => 'Soğuk havalar aracınızı zorlar. Akü, antifriz, lastik ve silecekler için kış öncesi kontrol listesi.',
                'read' => 5,
            ],
            [
                'title' => 'Motor Yağı Ne Zaman Değişmeli? Doğru Bilinen Yanlışlar',
                'category' => 'Bakım İpuçları',
                'image' => '1487754180451-c456f719a1fc',
                'excerpt' => 'Yağ değişim aralığı kilometreye mi yoksa zamana mı bağlı? Sentetik ve mineral yağ farkı.',
                'read' => 4,
            ],
            [
                'title' => 'Lastik Ömrünü Uzatan 6 Basit Alışkanlık',
                'category' => 'Lastik',
                'image' => '1568605117036-5fe5e7bab0b7',
                'excerpt' => 'Doğru basınç, düzenli rotasyon ve rot-balans ile lastiklerinizden çok daha uzun süre faydalanın.',
                'read' => 4,
            ],
            [
                'title' => 'Motor Arıza Lambası Yandığında Ne Yapmalı?',
                'category' => 'Arıza Tespiti',
                'image' => '1558618666-fcd25c85cd64',
                'excerpt' => 'Turuncu motor lambası her zaman panik sebebi değildir; ama görmezden de gelinmemeli. İşte yol haritası.',
                'read' => 6,
            ],
            [
                'title' => 'Uzun Yol Öncesi Araç Kontrol Rehberi',
                'category' => 'Sürüş',
                'image' => '1503376780353-7e6692767b70',
                'excerpt' => 'Tatil yoluna çıkmadan önce frenden lastiğe, sıvılardan aydınlatmaya yapılması gereken kontroller.',
                'read' => 5,
            ],
        ];

        foreach ($posts as $i => $p) {
            BlogPost::updateOrCreate(
                ['slug' => Str::slug($p['title'])],
                [
                    'title' => $p['title'],
                    'category' => $p['category'],
                    'author' => 'OtoPro Ekibi',
                    'cover_image' => $this->img($p['image']),
                    'excerpt' => $p['excerpt'],
                    'body' => $this->blogBody($p['excerpt']),
                    'read_minutes' => $p['read'],
                    'is_published' => true,
                    'published_at' => Carbon::now()->subDays(($i + 1) * 6),
                ]
            );
        }
    }

    private function blogBody(string $excerpt): string
    {
        return <<<HTML
<p>{$excerpt}</p>
<p>Aracınızın güvenliği ve uzun ömürlü olması, küçük ama düzenli kontrollerden geçer. OtoPro Servis &amp; Kaporta uzman ekibi olarak, en sık karşılaştığımız sorunların büyük bölümünün önceden önlenebileceğini görüyoruz.</p>
<h2>Neden önemli?</h2>
<p>Zamanında yapılan kontroller hem güvenliğinizi artırır hem de ileride çıkabilecek büyük masrafların önüne geçer. Düzenli bakım, aracınızın ikinci el değerini de korur.</p>
<ul>
<li>Üretici bakım takvimine sadık kalın.</li>
<li>Anormal ses, koku veya titreşimleri görmezden gelmeyin.</li>
<li>Sıvı seviyelerini ve lastik basıncını periyodik kontrol edin.</li>
<li>Arıza lambası yandığında zaman kaybetmeden teşhis yaptırın.</li>
</ul>
<h2>OtoPro önerisi</h2>
<p>Emin olamadığınız her durumda servisimize uğrayabilir, ücretsiz ön kontrolden faydalanabilirsiniz. Online randevu sistemimiz üzerinden size en uygun saati saniyeler içinde seçebilirsiniz.</p>
<blockquote>Doğru bakım, en ucuz onarımdır.</blockquote>
HTML;
    }

    private function seedAppointments(): void
    {
        $services = Service::pluck('id')->all();
        if (empty($services)) {
            return;
        }

        $samples = [
            ['name' => 'Okan Türker', 'phone' => '0532 111 22 33', 'vehicle_make' => 'BMW', 'vehicle_model' => '320d', 'vehicle_year' => 2019, 'plate' => '34 ABC 123', 'status' => 'pending', 'days' => 1, 'time' => '10:00'],
            ['name' => 'Selin Acar', 'phone' => '0541 222 33 44', 'vehicle_make' => 'Volkswagen', 'vehicle_model' => 'Passat', 'vehicle_year' => 2020, 'plate' => '06 DEF 456', 'status' => 'in_progress', 'days' => 0, 'time' => '11:00'],
            ['name' => 'Hakan Öz', 'phone' => '0555 333 44 55', 'vehicle_make' => 'Ford', 'vehicle_model' => 'Focus', 'vehicle_year' => 2017, 'plate' => '35 GHI 789', 'status' => 'completed', 'days' => -3, 'time' => '14:00'],
            ['name' => 'Derya Aydın', 'phone' => '0533 444 55 66', 'vehicle_make' => 'Audi', 'vehicle_model' => 'A4', 'vehicle_year' => 2021, 'plate' => '34 JKL 012', 'status' => 'pending', 'days' => 2, 'time' => '15:00'],
            ['name' => 'Emre Çelik', 'phone' => '0542 555 66 77', 'vehicle_make' => 'Renault', 'vehicle_model' => 'Megane', 'vehicle_year' => 2018, 'plate' => '16 MNO 345', 'status' => 'completed', 'days' => -7, 'time' => '09:00'],
        ];

        foreach ($samples as $i => $s) {
            Appointment::updateOrCreate(
                ['reference' => 'OTO-DEMO0' . ($i + 1)],
                [
                    'service_id' => $services[$i % count($services)],
                    'name' => $s['name'],
                    'phone' => $s['phone'],
                    'email' => Str::slug($s['name']) . '@example.com',
                    'vehicle_make' => $s['vehicle_make'],
                    'vehicle_model' => $s['vehicle_model'],
                    'vehicle_year' => $s['vehicle_year'],
                    'plate' => $s['plate'],
                    'preferred_date' => Carbon::today()->addDays($s['days']),
                    'preferred_time' => $s['time'],
                    'status' => $s['status'],
                    'notes' => null,
                ]
            );
        }
    }
}
