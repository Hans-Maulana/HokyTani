<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreGridSeeder extends Seeder
{
    /**
     * Seed denah toko yang sudah dikonfigurasi oleh admin.
     * Layout ini merupakan layout FINAL yang disimpan permanen.
     * Jangan ubah file ini kecuali ingin reset layout denah.
     */
    public function run(): void
    {
        DB::table('store_grids')->truncate();

        $cells = [
            // ── BARIS 1 ──────────────────────────────────────────────
            ['row_idx' => 1, 'col_idx' => 1, 'label' => 'Area Bibit Padi',      'zone_type' => 'tumpukan', 'color' => 'red'],
            ['row_idx' => 1, 'col_idx' => 2, 'label' => 'Area Bibit Padi',      'zone_type' => 'tumpukan', 'color' => 'red'],
            ['row_idx' => 1, 'col_idx' => 3, 'label' => 'Area Bibit Padi',      'zone_type' => 'tumpukan', 'color' => 'red'],
            ['row_idx' => 1, 'col_idx' => 4, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 1, 'col_idx' => 5, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 1, 'col_idx' => 6, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 1, 'col_idx' => 7, 'label' => 'Etalase Kasir',        'zone_type' => 'etalase',  'color' => 'green'],
            ['row_idx' => 1, 'col_idx' => 8, 'label' => 'Etalase Kasir',        'zone_type' => 'etalase',  'color' => 'green'],

            // ── BARIS 2 ──────────────────────────────────────────────
            ['row_idx' => 2, 'col_idx' => 1, 'label' => 'Rak Oli',              'zone_type' => 'rak',      'color' => 'blue'],
            ['row_idx' => 2, 'col_idx' => 2, 'label' => 'Etalase Benih',        'zone_type' => 'etalase',  'color' => 'green'],
            ['row_idx' => 2, 'col_idx' => 3, 'label' => 'Etalase Benih',        'zone_type' => 'etalase',  'color' => 'green'],
            ['row_idx' => 2, 'col_idx' => 4, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 2, 'col_idx' => 5, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 2, 'col_idx' => 6, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 2, 'col_idx' => 7, 'label' => 'Meja Kasir',           'zone_type' => 'kasir',    'color' => 'amber'],
            ['row_idx' => 2, 'col_idx' => 8, 'label' => 'Meja Kasir',           'zone_type' => 'kasir',    'color' => 'amber'],

            // ── BARIS 3 ──────────────────────────────────────────────
            ['row_idx' => 3, 'col_idx' => 1, 'label' => 'Rak Oli',              'zone_type' => 'rak',      'color' => 'blue'],
            ['row_idx' => 3, 'col_idx' => 2, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 3, 'col_idx' => 3, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 3, 'col_idx' => 4, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 3, 'col_idx' => 5, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 3, 'col_idx' => 6, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 3, 'col_idx' => 7, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 3, 'col_idx' => 8, 'label' => 'Rak Merah 1',          'zone_type' => 'rak',      'color' => 'blue'],

            // ── BARIS 4 ──────────────────────────────────────────────
            ['row_idx' => 4, 'col_idx' => 1, 'label' => 'Rak Oli',              'zone_type' => 'rak',      'color' => 'blue'],
            ['row_idx' => 4, 'col_idx' => 2, 'label' => 'Etalase Lampu',        'zone_type' => 'etalase',  'color' => 'green'],
            ['row_idx' => 4, 'col_idx' => 3, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 4, 'col_idx' => 4, 'label' => 'Rak Hijau',         'zone_type' => 'rak',      'color' => 'blue'],
            ['row_idx' => 4, 'col_idx' => 5, 'label' => 'Rak Biru',             'zone_type' => 'rak',      'color' => 'blue'],
            ['row_idx' => 4, 'col_idx' => 6, 'label' => 'Kotak',                'zone_type' => 'tumpukan', 'color' => 'red'],
            ['row_idx' => 4, 'col_idx' => 7, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 4, 'col_idx' => 8, 'label' => 'Rak Merah 1',          'zone_type' => 'rak',      'color' => 'blue'],

            // ── BARIS 5 ──────────────────────────────────────────────
            ['row_idx' => 5, 'col_idx' => 1, 'label' => 'Rak Oli',              'zone_type' => 'rak',      'color' => 'blue'],
            ['row_idx' => 5, 'col_idx' => 2, 'label' => 'Tumpukan Benih',       'zone_type' => 'tumpukan', 'color' => 'red'],
            ['row_idx' => 5, 'col_idx' => 3, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 5, 'col_idx' => 4, 'label' => 'Etalase Kaca Luar 1',  'zone_type' => 'etalase',  'color' => 'green'],
            ['row_idx' => 5, 'col_idx' => 5, 'label' => 'Etalase Kaca Dalam 1', 'zone_type' => 'etalase',  'color' => 'green'],
            ['row_idx' => 5, 'col_idx' => 6, 'label' => 'Kotak',                'zone_type' => 'tumpukan', 'color' => 'red'],
            ['row_idx' => 5, 'col_idx' => 7, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 5, 'col_idx' => 8, 'label' => 'Rak Merah 1',          'zone_type' => 'rak',      'color' => 'blue'],

            // ── BARIS 6 ──────────────────────────────────────────────
            ['row_idx' => 6, 'col_idx' => 1, 'label' => 'Rak Kayu',             'zone_type' => 'rak',      'color' => 'blue'],
            ['row_idx' => 6, 'col_idx' => 2, 'label' => 'Tumpukan Benih',       'zone_type' => 'tumpukan', 'color' => 'red'],
            ['row_idx' => 6, 'col_idx' => 3, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 6, 'col_idx' => 4, 'label' => 'Etalase Kaca Luar 1',  'zone_type' => 'etalase',  'color' => 'green'],
            ['row_idx' => 6, 'col_idx' => 5, 'label' => 'Etalase Kaca Dalam 1', 'zone_type' => 'etalase',  'color' => 'green'],
            ['row_idx' => 6, 'col_idx' => 6, 'label' => 'Kotak',                'zone_type' => 'tumpukan', 'color' => 'red'],
            ['row_idx' => 6, 'col_idx' => 7, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 6, 'col_idx' => 8, 'label' => 'Rak Merah 1',          'zone_type' => 'rak',      'color' => 'blue'],

            // ── BARIS 7 ──────────────────────────────────────────────
            ['row_idx' => 7, 'col_idx' => 1, 'label' => 'Rak Kayu',             'zone_type' => 'rak',      'color' => 'blue'],
            ['row_idx' => 7, 'col_idx' => 2, 'label' => 'Tumpukan Benih',       'zone_type' => 'tumpukan', 'color' => 'red'],
            ['row_idx' => 7, 'col_idx' => 3, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 7, 'col_idx' => 4, 'label' => 'Etalase Kaca Luar 2',  'zone_type' => 'etalase',  'color' => 'green'],
            ['row_idx' => 7, 'col_idx' => 5, 'label' => 'Etalase Kaca Dalam 2', 'zone_type' => 'etalase',  'color' => 'green'],
            ['row_idx' => 7, 'col_idx' => 6, 'label' => 'Kotak',                'zone_type' => 'tumpukan', 'color' => 'red'],
            ['row_idx' => 7, 'col_idx' => 7, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 7, 'col_idx' => 8, 'label' => 'Rak Merah 2',          'zone_type' => 'rak',      'color' => 'blue'],

            // ── BARIS 8 ──────────────────────────────────────────────
            ['row_idx' => 8, 'col_idx' => 1, 'label' => 'Rak Kayu',             'zone_type' => 'rak',      'color' => 'blue'],
            ['row_idx' => 8, 'col_idx' => 2, 'label' => 'Rak Kayu',             'zone_type' => 'rak',      'color' => 'blue'],
            ['row_idx' => 8, 'col_idx' => 3, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 8, 'col_idx' => 4, 'label' => 'Etalase Kaca Luar 2',  'zone_type' => 'etalase',  'color' => 'green'],
            ['row_idx' => 8, 'col_idx' => 5, 'label' => 'Etalase Kaca Dalam 2', 'zone_type' => 'etalase',  'color' => 'green'],
            ['row_idx' => 8, 'col_idx' => 6, 'label' => 'Kotak',                'zone_type' => 'tumpukan', 'color' => 'red'],
            ['row_idx' => 8, 'col_idx' => 7, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 8, 'col_idx' => 8, 'label' => 'Rak Merah 2',          'zone_type' => 'rak',      'color' => 'blue'],

            // ── BARIS 9 ──────────────────────────────────────────────
            ['row_idx' => 9, 'col_idx' => 1, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 9, 'col_idx' => 2, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 9, 'col_idx' => 3, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 9, 'col_idx' => 4, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 9, 'col_idx' => 5, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 9, 'col_idx' => 6, 'label' => 'Lorong Jalan',         'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 9, 'col_idx' => 7, 'label' => 'Jalan',                'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 9, 'col_idx' => 8, 'label' => 'Rak Merah 2',          'zone_type' => 'rak',      'color' => 'blue'],

            // ── BARIS 10 (Belakang Toko) ─────────────────────────────
            ['row_idx' => 10, 'col_idx' => 1, 'label' => 'Dapur',               'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 10, 'col_idx' => 2, 'label' => 'Dapur',               'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 10, 'col_idx' => 3, 'label' => 'Dapur',               'zone_type' => 'jalan',    'color' => 'gray'],
            ['row_idx' => 10, 'col_idx' => 4, 'label' => 'Rak Belakang',        'zone_type' => 'rak',      'color' => 'blue'],
            ['row_idx' => 10, 'col_idx' => 5, 'label' => 'RakBelakang',         'zone_type' => 'rak',      'color' => 'blue'],
            ['row_idx' => 10, 'col_idx' => 6, 'label' => 'Rak Belakang',        'zone_type' => 'rak',      'color' => 'blue'],
            ['row_idx' => 10, 'col_idx' => 7, 'label' => 'Rak Belakang',        'zone_type' => 'rak',      'color' => 'blue'],
            ['row_idx' => 10, 'col_idx' => 8, 'label' => 'Rak Merah 2',         'zone_type' => 'rak',      'color' => 'blue'],
        ];

        $now = now();
        foreach ($cells as &$cell) {
            $cell['created_at'] = $now;
            $cell['updated_at'] = $now;
        }

        DB::table('store_grids')->insert($cells);
    }
}
