<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Problem;
use App\Models\Rack;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin User Seeder
        User::updateOrCreate(
            ['email' => 'admin@hokytani.com'],
            [
                'name' => 'Admin Hokytani',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Seed Store Grid — layout denah FINAL yang sudah dikonfigurasi admin
        $this->call(StoreGridSeeder::class);

        // 3. Physical Racks & Store Zones Seeder
        $etalase = Rack::create([
            'nama' => 'Etalase Kaca Utama',
            'kode_zona' => 'ETALASE',
            'deskripsi' => 'Display etalase kaca depan kasir untuk produk bernilai tinggi & benih premium.',
            'keterangan_baris' => 'Baris 1: Obat Mahal | Baris 2: Benih Premium',
        ]);

        $rakA = Rack::create([
            'nama' => 'Rak A (Pupuk & Nutrisi)',
            'kode_zona' => 'RAK_A',
            'deskripsi' => 'Area penyimpanan pupuk NPK, Urea, pupuk cair, dan ZPT.',
            'keterangan_baris' => 'Baris 1: Pupuk Kimia & NPK | Baris 2: Pupuk Organik & POC',
        ]);

        $rakB = Rack::create([
            'nama' => 'Rak B (Pestisida & Racun Hama)',
            'kode_zona' => 'RAK_B',
            'deskripsi' => 'Area penyimpanan obat Insektisida, Fungisida, dan Herbisida.',
            'keterangan_baris' => 'Baris 1: Insektisida | Baris 2: Fungisida | Baris 3: Herbisida',
        ]);

        $rakC = Rack::create([
            'nama' => 'Rak C (Benih & Palawija)',
            'kode_zona' => 'RAK_C',
            'deskripsi' => 'Penyimpanan benih padi, sayuran, dan tanaman buah.',
            'keterangan_baris' => 'Baris 1: Benih Padi | Baris 2: Benih Sayur',
        ]);

        $rakD = Rack::create([
            'nama' => 'Rak D (Sprayer & Alat Tani)',
            'kode_zona' => 'RAK_D',
            'deskripsi' => 'Area perkakas cangkul, tangki semprot elektrik, dan perlengkapan.',
            'keterangan_baris' => 'Baris 1: Tangki Sprayer | Baris 2: Alat Potong & Olah Tanah',
        ]);

        $gudang = Rack::create([
            'nama' => 'Gudang Belakang',
            'kode_zona' => 'GUDANG',
            'deskripsi' => 'Stok kemasan karungan dan alat berat.',
            'keterangan_baris' => 'Area Karung Pupuk & Stok Cadangan',
        ]);

        // 4. Main Categories & Subcategories
        $pestisida = Category::create([
            'nama' => 'Pestisida & Proteksi',
            'deskripsi' => 'Insektisida, fungisida, herbisida, dan pembasmi hama tanaman.',
            'parent_id' => null,
        ]);
        $insektisida = Category::create([
            'nama' => 'Insektisida',
            'deskripsi' => 'Pembasmi hama ulat, wereng, dan serangga pengganggu.',
            'parent_id' => $pestisida->id,
        ]);
        $fungisida = Category::create([
            'nama' => 'Fungisida',
            'deskripsi' => 'Obat pembasmi jamur, bercak daun, dan pembusukan akar/batang.',
            'parent_id' => $pestisida->id,
        ]);
        $herbisida = Category::create([
            'nama' => 'Herbisida',
            'deskripsi' => 'Pembasmi rumput liar & gulma daun lebar/sempit.',
            'parent_id' => $pestisida->id,
        ]);

        $pupuk = Category::create([
            'nama' => 'Pupuk & Nutrisi',
            'deskripsi' => 'Pupuk anorganik, organik, ZPT, dan nutrisi pelebat buah.',
            'parent_id' => null,
        ]);
        $pupukKimia = Category::create([
            'nama' => 'Pupuk Anorganik / Kimia',
            'deskripsi' => 'Pupuk NPK, Urea, ZA, SP-36 penyubur tanah cepat.',
            'parent_id' => $pupuk->id,
        ]);
        $pupukOrganik = Category::create([
            'nama' => 'Pupuk Organik & Hayati',
            'deskripsi' => 'Pupuk cair hayati, kompos, dan pembenah tanah alami.',
            'parent_id' => $pupuk->id,
        ]);

        $benih = Category::create([
            'nama' => 'Benih Unggul',
            'deskripsi' => 'Benih varietas unggul bersertifikat resmi.',
            'parent_id' => null,
        ]);
        $benihPadi = Category::create([
            'nama' => 'Benih Padi & Palawija',
            'deskripsi' => 'Benih padi hibrida, jagung, dan kedelai tahan hama.',
            'parent_id' => $benih->id,
        ]);

        $alat = Category::create([
            'nama' => 'Alat & Peralatan Tani',
            'deskripsi' => 'Sprayer semprotan, cangkul, dan peralatan modern.',
            'parent_id' => null,
        ]);
        $sprayer = Category::create([
            'nama' => 'Sprayer & Semprotan',
            'deskripsi' => 'Tangki semprot elektrik dan manual tekanan tinggi.',
            'parent_id' => $alat->id,
        ]);

        // 5. Problems
        $wereng = Problem::create([
            'nama' => 'Wereng Cokelat & Penggerek Batang',
            'tipe' => 'Hama',
            'foto' => null,
        ]);

        $fungus = Problem::create([
            'nama' => 'Bercak Daun & Jamur Antraknosa',
            'tipe' => 'Penyakit',
            'foto' => null,
        ]);

        $rumput = Problem::create([
            'nama' => 'Gulma Daun Lebar & Rumput Teki',
            'tipe' => 'Gulma',
            'foto' => null,
        ]);

        // 6. Products attached to specific Racks
        $p1 = Product::create([
            'rack_id' => $rakA->id,
            'barcode' => 'HKT-8801',
            'nama' => 'Pupuk NPK Mutiara 16-16-16 1Kg',
            'merk' => 'YaraMila',
            'harga' => 22000,
            'deskripsi' => 'Pupuk pemacu pertumbuhan tanaman, mempercepat pembentukan buah dan bunga.',
            'status' => 'Tersedia',
            'foto' => null,
            'lokasi_rak' => 'Rak A1-1',
        ]);
        $p1->categories()->attach([$pupuk->id, $pupukKimia->id]);

        $p2 = Product::create([
            'rack_id' => $rakB->id,
            'barcode' => 'HKT-8802',
            'nama' => 'Insektisida Prevathon 50 SC 250ml',
            'merk' => 'FMC',
            'harga' => 115000,
            'deskripsi' => 'Insektisida sistemik racun kontak dan lambung pembasmi ulat & wereng.',
            'status' => 'Tersedia',
            'foto' => null,
            'lokasi_rak' => 'Rak B1-1',
        ]);
        $p2->categories()->attach([$pestisida->id, $insektisida->id]);
        $p2->problems()->attach([$wereng->id]);

        $p3 = Product::create([
            'rack_id' => $rakB->id,
            'barcode' => 'HKT-8803',
            'nama' => 'Fungisida Amistartop 325 SC 100ml',
            'merk' => 'Syngenta',
            'harga' => 145000,
            'deskripsi' => 'Fungisida sistemik kombinasi 2 bahan aktif pembasmi jamur dan bercak daun.',
            'status' => 'Tersedia',
            'foto' => null,
            'lokasi_rak' => 'Rak B1-2',
        ]);
        $p3->categories()->attach([$pestisida->id, $fungisida->id]);
        $p3->problems()->attach([$fungus->id]);

        $p4 = Product::create([
            'rack_id' => $rakB->id,
            'barcode' => 'HKT-8804',
            'nama' => 'Herbisida RoundUp 486 SL 1 Liter',
            'merk' => 'Bayer',
            'harga' => 98000,
            'deskripsi' => 'Herbisida sistemik membasmi rumput liar dan gulma sampai ke akar.',
            'status' => 'Tersedia',
            'foto' => null,
            'lokasi_rak' => 'Rak B2-1',
        ]);
        $p4->categories()->attach([$pestisida->id, $herbisida->id]);
        $p4->problems()->attach([$rumput->id]);

        $p5 = Product::create([
            'rack_id' => $rakC->id,
            'barcode' => 'HKT-8805',
            'nama' => 'Benih Padi F1 Hibrida Supadi',
            'merk' => 'Bintang Asia',
            'harga' => 85000,
            'deskripsi' => 'Benih padi unggul produktivitas tinggi hingga 12 ton per hektar.',
            'status' => 'Tersedia',
            'foto' => null,
            'lokasi_rak' => 'Rak C-1',
        ]);
        $p5->categories()->attach([$benih->id, $benihPadi->id]);

        $p6 = Product::create([
            'rack_id' => $rakD->id,
            'barcode' => 'HKT-8806',
            'nama' => 'Sprayer Elektrik Swan F16',
            'merk' => 'Swan',
            'harga' => 540000,
            'deskripsi' => 'Tangki semprot elektrik 16 Liter bertekanan tinggi baterai awet.',
            'status' => 'Tersedia',
            'foto' => null,
            'lokasi_rak' => 'Rak D-1',
        ]);
        $p6->categories()->attach([$alat->id, $sprayer->id]);
    }
}
