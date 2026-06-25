<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BarangSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_barang' => 'Laptop',
                'deskripsi' => 'Laptop dengan spesifikasi tinggi',
                'stok' => 10,
                'harga' => 15000000.00,
                'kategori_id' => 1
            ],
            [
                'nama_barang' => 'Smartphone',
                'deskripsi' => 'Smartphone dengan kamera berkualitas',
                'stok' => 15,
                'harga' => 8000000.00,
                'kategori_id' => 1
            ],
            [
                'nama_barang' => 'T-Shirt',
                'deskripsi' => 'Kaos dengan bahan katun',
                'stok' => 20,
                'harga' => 150000.00,
                'kategori_id' => 2
            ],
            [
                'nama_barang' => 'Jeans',
                'deskripsi' => 'Celana jeans dengan kualitas bagus',
                'stok' => 10,
                'harga' => 300000.00,
                'kategori_id' => 2
            ],
            [
                'nama_barang' => 'Nasi Goreng',
                'deskripsi' => 'Nasi goreng dengan bumbu khas',
                'stok' => 30,
                'harga' => 25000.00,
                'kategori_id' => 3
            ],
            [
                'nama_barang' => 'Mie Goreng',
                'deskripsi' => 'Mie goreng dengan bumbu pedas',
                'stok' => 25,
                'harga' => 20000.00,
                'kategori_id' => 3
            ],
            [
                'nama_barang' => 'Es Teh Manis',
                'deskripsi' => 'Minuman teh manis dingin',
                'stok' => 50,
                'harga' => 10000.00,
                'kategori_id' => 4
            ],
            [
                'nama_barang' => 'Kopi Hitam',
                'deskripsi' => 'Kopi hitam dengan rasa kuat',
                'stok' => 40,
                'harga' => 15000.00,
                'kategori_id' => 4
            ]
        ];

        $this->db->table('barang')->insertBatch($data);
    }
}