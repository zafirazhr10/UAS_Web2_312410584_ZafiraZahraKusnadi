<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Check if users already exist
        $existingUsers = $this->db->table('users')->select('username')->get()->getResultArray();
        $existingUsernames = array_column($existingUsers, 'username');

        $data = [
            [
                'nama' => 'Admin User',
                'username' => 'admin_' . time(),
                'password' => password_hash('admin123', PASSWORD_DEFAULT)
            ],
            [
                'nama' => 'Regular User',
                'username' => 'user_' . time(),
                'password' => password_hash('user123', PASSWORD_DEFAULT)
            ]
        ];

        // Filter out users that already exist
        $filteredData = array_filter($data, function($user) use ($existingUsernames) {
            return !in_array($user['username'], $existingUsernames);
        });

        if (!empty($filteredData)) {
            $this->db->table('users')->insertBatch($filteredData);
        }
    }
}
