<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;

class Auth extends ResourceController
{
    protected $format = 'json';

    public function __construct()
    {
        $db = \Config\Database::connect();
        $db->query("CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username VARCHAR(50) NOT NULL,
            email VARCHAR(100) NOT NULL,
            password VARCHAR(255) NOT NULL
        )");
    }

    public function login()
    {
        $json = $this->request->getJSON(true) ?: json_decode(file_get_contents('php://input'), true);
        $email = $json['email'] ?? '';
        $password = $json['password'] ?? '';

        if (empty($email) || empty($password)) {
            return $this->fail('Email and password required', 400);
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            try {
                $jwt = $this->generate_jwt($user);

                return $this->respond([
                    'status' => 200,
                    'message' => 'Success',
                    'token' => $jwt,
                ]);
            } catch (\Exception $e) {
                return $this->response->setStatusCode(500)->setJSON([
                    'status' => 500,
                    'error' => 500,
                    'messages' => ['error' => $e->getMessage()]
                ]);
            }
        }

        return $this->failUnauthorized('Invalid email or password');
    }

    public function register()
    {
        $json = $this->request->getJSON(true) ?: json_decode(file_get_contents('php://input'), true);
        $name = $json['name'] ?? $json['username'] ?? '';
        $email = $json['email'] ?? '';
        $password = $json['password'] ?? '';

        if (empty($name) || empty($email) || empty($password)) {
            return $this->fail('All fields required', 400);
        }

        $userModel = new UserModel();

        if ($userModel->where('email', $email)->first()) {
            return $this->fail('Email already exists', 400);
        }

        $data = [
            'nama' => $name,
            'username' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ];

        if ($userModel->insert($data)) {
            return $this->respondCreated([
                'status' => 201,
                'message' => 'Registered successfully',
            ]);
        }

        return $this->fail('Database insertion failed', 500);
    }

     private function generate_jwt($user) {
         $key = getenv('JWT_SECRET') ?: 'E_Inventory_System_UAS_Web2_Secret_Key_Secure_2026';
         $payload = ['iat' => time(), 'exp' => time() + 3600, 'uid' => $user['id'] ?? 1, 'email' => $user['email']];
         return JWT::encode($payload, $key, 'HS256');
     }
}
