<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class KategoriController extends ResourceController
{
    protected $modelName = 'App\Models\KategoriModel';
    protected $format    = 'json';

    public function __construct()
    {
        // FORCE AUTO-CREATE SQLITE TABLE
        $db = \Config\Database::connect();
        $db->query("CREATE TABLE IF NOT EXISTS kategori (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nama_kategori VARCHAR(255) NOT NULL
        )");
    }

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function create()
    {
        try {
            $data = $this->request->getJSON(true);
            if (empty($data['nama_kategori'])) {
                return $this->fail('Nama kategori wajib diisi', 400);
            }
            $this->model->insert($data);
            return $this->respondCreated(['message' => 'Kategori berhasil ditambahkan']);
        } catch (\Exception $e) {
            return $this->failServerError('DB Error: ' . $e->getMessage());
        }
    }

    public function update($id = null)
    {
        try {
            $data = $this->request->getJSON(true);
            $this->model->update($id, $data);
            return $this->respond(['message' => 'Kategori diupdate']);
        } catch (\Exception $e) {
            return $this->failServerError('DB Error: ' . $e->getMessage());
        }
    }

    public function delete($id = null)
    {
        $this->model->delete($id);
        return $this->respondDeleted(['message' => 'Kategori dihapus']);
    }
}