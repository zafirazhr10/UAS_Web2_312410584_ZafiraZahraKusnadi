<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SystemSeeder extends Seeder
{
    public function run()
    {
        $this->call('UserSeeder');
        $this->call('KategoriSeeder');
        $this->call('BarangSeeder');
    }
}