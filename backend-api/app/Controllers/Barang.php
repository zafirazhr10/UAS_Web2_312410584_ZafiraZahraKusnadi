<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Barang extends ResourceController
{
    protected $modelName = 'App\Models\BarangModel';
    protected $format    = 'json';

    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('barang');
        $builder->select('barang.*, kategori.nama_kategori');
        $builder->join('kategori', 'kategori.id = barang.kategori_id');
        $query = $builder->get();
        return $this->respond($query->getResultArray());
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        if (!$data) {
            return $this->failNotFound('Barang not found.');
        }
        return $this->respond($data);
    }

    public function create()
    {
        $data = $this->request->getJSON(true) ?: $this->request->getPost();
        if (!$this->model->insert($data)) {
            return $this->fail($this->model->errors());
        }
        return $this->respondCreated([
            'status'  => 201,
            'message' => 'Barang created successfully.',
            'data'    => $this->model->find($this->model->getInsertID())
        ]);
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true) ?: $this->request->getRawInput();
        if (!$this->model->find($id)) {
            return $this->failNotFound('Barang not found.');
        }
        if (!$this->model->update($id, $data)) {
            return $this->fail($this->model->errors());
        }
        return $this->respond([
            'status'  => 200,
            'message' => 'Barang updated successfully.',
            'data'    => $this->model->find($id)
        ]);
    }

    public function delete($id = null)
    {
        if (!$this->model->find($id)) {
            return $this->failNotFound('Barang not found.');
        }
        $this->model->delete($id);
        return $this->respondDeleted([
            'status'  => 200,
            'message' => 'Barang deleted successfully.'
        ]);
    }
}