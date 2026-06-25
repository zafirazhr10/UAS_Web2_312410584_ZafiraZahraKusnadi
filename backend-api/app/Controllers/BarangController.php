<?php

namespace App\Controllers;

use App\Models\BarangModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class BarangController extends ResourceController
{
    use ResponseTrait;

    protected $modelName = 'App\Models\BarangModel';
    protected $format = 'json';

    public function index()
    {
        $barang = $this->model->findAll();
        return $this->respond(['status' => 200, 'data' => $barang]);
    }

    public function show($id = null)
    {
        $barang = $this->model->find($id);
        if (!$barang) {
            return $this->failNotFound('Barang tidak ditemukan');
        }
        return $this->respond(['status' => 200, 'data' => $barang]);
    }

public function create()
{
    $rules = [
        'nama_barang' => 'required|min_length[3]|max_length[100]',
        'deskripsi' => 'permit_empty|max_length[255]',
        'stok' => 'required|integer',
        'harga' => 'required|decimal',
        'kategori_id' => 'required|integer'
    ];

    if (!$this->validate($rules)) {
        return $this->fail($this->validator->getErrors());
    }

    $data = [
        'nama_barang' => $this->request->getVar('nama_barang'),
        'deskripsi' => $this->request->getVar('deskripsi'),
        'stok' => $this->request->getVar('stok'),
        'harga' => $this->request->getVar('harga'),
        'kategori_id' => $this->request->getVar('kategori_id')
    ];

    $this->model->save($data);
    return $this->respondCreated($data);
}

public function update($id = null)
{
    $rules = [
        'nama_barang' => 'required|min_length[3]|max_length[100]',
        'deskripsi' => 'permit_empty|max_length[255]',
        'stok' => 'required|integer',
        'harga' => 'required|decimal',
        'kategori_id' => 'required|integer'
    ];

    if (!$this->validate($rules)) {
        return $this->fail($this->validator->getErrors());
    }

    $data = [
        'nama_barang' => $this->request->getVar('nama_barang'),
        'deskripsi' => $this->request->getVar('deskripsi'),
        'stok' => $this->request->getVar('stok'),
        'harga' => $this->request->getVar('harga'),
        'kategori_id' => $this->request->getVar('kategori_id')
    ];

    $this->model->update($id, $data);
    return $this->respond($data);
}

    public function delete($id = null)
    {
        if (!$this->model->delete($id)) {
            return $this->failServerError('Gagal menghapus barang');
        }

        return $this->respondDeleted(['status' => 200, 'message' => 'Barang berhasil dihapus']);
    }
}