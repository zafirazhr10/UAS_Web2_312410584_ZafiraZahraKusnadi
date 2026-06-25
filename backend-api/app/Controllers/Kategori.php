<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Kategori extends ResourceController
{
    protected $modelName = 'App\Models\KategoriModel';
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        if (!$data) {
            return $this->failNotFound('Kategori not found.');
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
            'message' => 'Kategori created successfully.',
            'data'    => $this->model->find($this->model->getInsertID())
        ]);
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true) ?: $this->request->getRawInput();
        if (!$this->model->find($id)) {
            return $this->failNotFound('Kategori not found.');
        }
        if (!$this->model->update($id, $data)) {
            return $this->fail($this->model->errors());
        }
        return $this->respond([
            'status'  => 200,
            'message' => 'Kategori updated successfully.',
            'data'    => $this->model->find($id)
        ]);
    }

    public function delete($id = null)
    {
        if (!$this->model->find($id)) {
            return $this->failNotFound('Kategori not found.');
        }
        $this->model->delete($id);
        return $this->respondDeleted([
            'status'  => 200,
            'message' => 'Kategori deleted successfully.'
        ]);
    }
}