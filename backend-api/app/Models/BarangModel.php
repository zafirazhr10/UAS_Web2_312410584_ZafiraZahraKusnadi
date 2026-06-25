<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_barang', 'deskripsi', 'stok', 'harga', 'kategori_id'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nama_barang' => 'required|min_length[3]|max_length[100]',
        'deskripsi' => 'permit_empty|max_length[255]',
        'stok' => 'required|integer|greater_than_equal_to[0]',
        'harga' => 'required|decimal|greater_than[0]',
        'kategori_id' => 'required|integer|is_not_unique[kategori.id]'
    ];

    protected $validationMessages = [
        'nama_barang' => [
            'required' => 'Nama barang harus diisi',
            'min_length' => 'Nama barang minimal 3 karakter',
            'max_length' => 'Nama barang maksimal 100 karakter'
        ],
        'deskripsi' => [
            'max_length' => 'Deskripsi maksimal 255 karakter'
        ],
        'stok' => [
            'required' => 'Stok harus diisi',
            'integer' => 'Stok harus berupa angka bulat',
            'greater_than_equal_to' => 'Stok minimal 0'
        ],
        'harga' => [
            'required' => 'Harga harus diisi',
            'decimal' => 'Harga harus berupa angka desimal',
            'greater_than' => 'Harga harus lebih besar dari 0'
        ],
        'kategori_id' => [
            'required' => 'Kategori harus dipilih',
            'integer' => 'ID kategori harus berupa angka',
            'is_not_unique' => 'Kategori tidak valid'
        ]
    ];
}