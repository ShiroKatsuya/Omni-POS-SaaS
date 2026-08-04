<?php

namespace App\Http\Controllers;

use App\Services\KasirApiService;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HomeController extends Controller
{
    private KasirApiService $kasirApi;

    public function __construct(KasirApiService $kasirApi)
    {
        $this->kasirApi = $kasirApi;
    }

    public function index(): View
    {
        // Fetch products/services from POS system via API
        $apiProducts = $this->kasirApi->getProducts();
        $apiCategories = $this->kasirApi->getCategories();
        $storeInfo = $this->kasirApi->getStoreInfo();

        // Map API products to service card format for the view
        $services = $this->mapProductsToServices($apiProducts);

        return view('home', [
            'services' => $services,
            'categories' => $apiCategories,
            'gallery' => $this->gallery(),
            'prices' => $this->prices(),
            'testimonials' => $this->testimonials(),
            'team' => $this->team(),
            'faqs' => $this->faqs(),
            'storeInfo' => $storeInfo,
        ]);
    }

    /**
     * Map API product data to the service card format used by the view.
     * Falls back to hardcoded data if API returns empty.
     */
    private function mapProductsToServices(array $apiProducts): array
    {
        if (empty($apiProducts)) {
            return $this->fallbackServices();
        }

        // Map of service names to their display icons and images
        $serviceAssets = [
            'Hair Spa' => ['icon' => 'bi-stars', 'image' => 'https://images.unsplash.com/photo-1560066984-138dadb4c035?auto=format&fit=crop&w=900&q=80'],
            'Hair Coloring' => ['icon' => 'bi-palette2', 'image' => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?auto=format&fit=crop&w=900&q=80'],
            'Hair Cut' => ['icon' => 'bi-scissors', 'image' => 'https://images.unsplash.com/photo-1634449571010-02389ed0f9b0?auto=format&fit=crop&w=900&q=80'],
            'Hair Treatment' => ['icon' => 'bi-droplet-half', 'image' => 'https://images.unsplash.com/photo-1521590832167-7bcbfaa6381f?auto=format&fit=crop&w=900&q=80'],
            'Creambath' => ['icon' => 'bi-flower1', 'image' => 'https://images.unsplash.com/photo-1519823551278-64ac92734fb1?auto=format&fit=crop&w=900&q=80'],
            'Facial' => ['icon' => 'bi-brightness-high', 'image' => 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?auto=format&fit=crop&w=900&q=80'],
            'Make Up' => ['icon' => 'bi-magic', 'image' => 'https://images.unsplash.com/photo-1487412947147-5cebf100ffc2?auto=format&fit=crop&w=900&q=80'],
            'Nail Art' => ['icon' => 'bi-gem', 'image' => 'https://images.unsplash.com/photo-1604654894610-df63bc536371?auto=format&fit=crop&w=900&q=80'],
            'Manicure' => ['icon' => 'bi-hand-index-thumb', 'image' => 'https://images.unsplash.com/photo-1610992015732-2449b76344bc?auto=format&fit=crop&w=900&q=80'],
            'Pedicure' => ['icon' => 'bi-heart', 'image' => 'https://images.unsplash.com/photo-1519014816548-bf5fe059798b?auto=format&fit=crop&w=900&q=80'],
            'Eyelash Extension' => ['icon' => 'bi-eye', 'image' => 'https://images.unsplash.com/photo-1589710751893-f9a6770ad71b?auto=format&fit=crop&w=900&q=80'],
            'Body Spa' => ['icon' => 'bi-water', 'image' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?auto=format&fit=crop&w=900&q=80'],
            'Body Massage' => ['icon' => 'bi-moisture', 'image' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=900&q=80'],
            'Waxing' => ['icon' => 'bi-feather', 'image' => 'https://images.unsplash.com/photo-1600334129128-685c5582fd35?auto=format&fit=crop&w=900&q=80'],
        ];

        $defaultAssets = ['icon' => 'bi-stars', 'image' => 'https://images.unsplash.com/photo-1560066984-138dadb4c035?auto=format&fit=crop&w=900&q=80'];

        return array_map(function ($product) use ($serviceAssets, $defaultAssets) {
            $assets = $serviceAssets[$product['name']] ?? $defaultAssets;
            return [
                'id' => $product['id'],
                'title' => $product['name'],
                'icon' => $assets['icon'],
                'image' => $product['image'] ?? $assets['image'],
                'description' => $product['description'] ?? '',
                'price' => $product['sellingPrice'] ?? 0,
                'category' => $product['category']['name'] ?? null,
            ];
        }, $apiProducts);
    }

    /**
     * Fallback services data when API is unavailable.
     */
    private function fallbackServices(): array
    {
        return [
            ['id' => Str::slug('Hair Spa'), 'title' => 'Hair Spa', 'icon' => 'bi-stars', 'image' => 'https://images.unsplash.com/photo-1560066984-138dadb4c035?auto=format&fit=crop&w=900&q=80', 'description' => 'Relaksasi rambut dan kulit kepala dengan aroma therapy premium.', 'price' => 150000, 'category' => 'Hair Care'],
            ['id' => Str::slug('Hair Coloring'), 'title' => 'Hair Coloring', 'icon' => 'bi-palette2', 'image' => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?auto=format&fit=crop&w=900&q=80', 'description' => 'Pewarnaan rambut elegan menggunakan produk profesional.', 'price' => 250000, 'category' => 'Hair Care'],
            ['id' => Str::slug('Hair Cut'), 'title' => 'Hair Cut', 'icon' => 'bi-scissors', 'image' => 'https://images.unsplash.com/photo-1634449571010-02389ed0f9b0?auto=format&fit=crop&w=900&q=80', 'description' => 'Potongan modern yang disesuaikan dengan bentuk wajah.', 'price' => 75000, 'category' => 'Hair Care'],
            ['id' => Str::slug('Facial'), 'title' => 'Facial', 'icon' => 'bi-brightness-high', 'image' => 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?auto=format&fit=crop&w=900&q=80', 'description' => 'Facial premium untuk kulit bersih, segar, dan glowing.', 'price' => 175000, 'category' => 'Skin Care'],
            ['id' => Str::slug('Make Up'), 'title' => 'Make Up', 'icon' => 'bi-magic', 'image' => 'https://images.unsplash.com/photo-1487412947147-5cebf100ffc2?auto=format&fit=crop&w=900&q=80', 'description' => 'Make up flawless untuk pesta, wisuda, prewedding, dan bridal.', 'price' => 500000, 'category' => 'Make Up'],
            ['id' => Str::slug('Body Spa'), 'title' => 'Body Spa', 'icon' => 'bi-water', 'image' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?auto=format&fit=crop&w=900&q=80', 'description' => 'Spa tubuh premium untuk melepas lelah dan merawat kulit.', 'price' => 300000, 'category' => 'Body Care'],
        ];
    }

    private function gallery(): array
    {
        return [
            'https://images.unsplash.com/photo-1562322140-8baeececf3df?auto=format&fit=crop&w=900&q=80',
            'https://images.unsplash.com/photo-1552693673-1bf958298935?auto=format&fit=crop&w=900&q=80',
            'https://images.unsplash.com/photo-1522337660859-02fbefca4702?auto=format&fit=crop&w=900&q=80',
            'https://images.unsplash.com/photo-1521590832167-7bcbfaa6381f?auto=format&fit=crop&w=900&q=80',
            'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?auto=format&fit=crop&w=900&q=80',
            'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?auto=format&fit=crop&w=900&q=80',
            'https://images.unsplash.com/photo-1604654894610-df63bc536371?auto=format&fit=crop&w=900&q=80',
            'https://images.unsplash.com/photo-1487412947147-5cebf100ffc2?auto=format&fit=crop&w=900&q=80',
            'https://images.unsplash.com/photo-1519823551278-64ac92734fb1?auto=format&fit=crop&w=900&q=80',
            'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=900&q=80',
            'https://images.unsplash.com/photo-1560066984-138dadb4c035?auto=format&fit=crop&w=900&q=80',
            'https://images.unsplash.com/photo-1633681926022-84c23e8cb2d6?auto=format&fit=crop&w=900&q=80',
        ];
    }

    private function prices(): array
    {
        return [
            ['name' => 'Basic Beauty', 'price' => 'Rp299K', 'popular' => false, 'features' => ['Hair Cut', 'Creambath', 'Simple Manicure', 'Beauty Consultation']],
            ['name' => 'Premium Beauty', 'price' => 'Rp699K', 'popular' => true, 'features' => ['Hair Spa', 'Facial Glow', 'Nail Art', 'Relaxing Massage']],
            ['name' => 'Luxury Beauty', 'price' => 'Rp1.299K', 'popular' => false, 'features' => ['Hair Coloring', 'Premium Facial', 'Body Spa', 'Make Up Look']],
            ['name' => 'VIP Treatment', 'price' => 'Rp2.499K', 'popular' => false, 'features' => ['Private Room', 'Full Body Ritual', 'Bridal Make Up', 'Priority Booking']],
        ];
    }

    private function testimonials(): array
    {
        return [
            ['name' => 'Nadia Putri', 'photo' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=300&q=80', 'comment' => 'Pelayanannya sangat detail, salon terasa bersih, wangi, dan hasil hair spa-nya luar biasa.'],
            ['name' => 'Citra Maharani', 'photo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80', 'comment' => 'Make up bridal saya tahan seharian dan tetap terlihat elegan di foto. Highly recommended.'],
            ['name' => 'Alya Rahma', 'photo' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=300&q=80', 'comment' => 'Beautician ramah, hasil nail art rapi, dan suasananya premium sekali.'],
            ['name' => 'Sabrina Lestari', 'photo' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=300&q=80', 'comment' => 'Facial di sini bikin kulit saya lebih cerah tanpa terasa perih.'],
            ['name' => 'Maya Sekar', 'photo' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=300&q=80', 'comment' => 'Salon favorit untuk treatment bulanan. Booking mudah dan selalu tepat waktu.'],
            ['name' => 'Dewi Laras', 'photo' => 'https://images.unsplash.com/photo-1488426862026-3ee34a7d66df?auto=format&fit=crop&w=300&q=80', 'comment' => 'Hair coloring-nya natural, rambut tetap lembut, dan konsultasinya profesional.'],
        ];
    }

    private function team(): array
    {
        return [
            ['name' => 'Amelia Grace', 'role' => 'Senior Hair Stylist', 'experience' => '12 Tahun', 'photo' => 'https://images.unsplash.com/photo-1580618672591-eb180b1a973f?auto=format&fit=crop&w=600&q=80'],
            ['name' => 'Bianca Rose', 'role' => 'Make Up Artist', 'experience' => '10 Tahun', 'photo' => 'https://images.unsplash.com/photo-1594824476967-48c8b964273f?auto=format&fit=crop&w=600&q=80'],
            ['name' => 'Clara Belle', 'role' => 'Skin Therapist', 'experience' => '9 Tahun', 'photo' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=600&q=80'],
            ['name' => 'Diana Elise', 'role' => 'Nail Artist', 'experience' => '8 Tahun', 'photo' => 'https://images.unsplash.com/photo-1595152772835-219674b2a8a6?auto=format&fit=crop&w=600&q=80'],
        ];
    }

    private function faqs(): array
    {
        return [
            ['q' => 'Apakah harus reservasi terlebih dahulu?', 'a' => 'Reservasi sangat disarankan agar jadwal beautician tersedia sesuai waktu pilihan Anda.'],
            ['q' => 'Produk apa yang digunakan?', 'a' => 'Kami menggunakan produk profesional berkualitas salon premium dan aman untuk kulit serta rambut.'],
            ['q' => 'Apakah tersedia private room?', 'a' => 'Ya, private room tersedia untuk paket Luxury Beauty dan VIP Treatment.'],
            ['q' => 'Berapa lama durasi treatment?', 'a' => 'Durasi bergantung layanan, mulai 45 menit hingga 4 jam untuk paket lengkap.'],
            ['q' => 'Apakah alat disterilkan?', 'a' => 'Semua alat dibersihkan dan disterilkan sesuai standar higienitas salon profesional.'],
            ['q' => 'Apakah bisa konsultasi sebelum treatment?', 'a' => 'Bisa. Tim kami akan membantu memilih layanan yang sesuai kebutuhan Anda.'],
            ['q' => 'Apakah menerima layanan bridal?', 'a' => 'Ya, kami menerima make up bridal, prewedding, wisuda, dan event khusus.'],
            ['q' => 'Bagaimana cara mengubah jadwal booking?', 'a' => 'Hubungi WhatsApp kami minimal 6 jam sebelum jadwal untuk pengaturan ulang.'],
        ];
    }
}
