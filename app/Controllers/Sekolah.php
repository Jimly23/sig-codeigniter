<?php

namespace App\Controllers;

use App\Models\SekolahModel;

class Sekolah extends BaseController
{
    protected SekolahModel $model;

    public function __construct()
    {
        $this->model = new SekolahModel();
    }

    /** GET /sekolah — Halaman list data SMK */
    public function index(): string
    {
        $kecamatan = $this->request->getGet('kecamatan');

        $sekolah = $this->model->getFiltered($kecamatan ?? '');

        // Ambil kecamatan unik dari DB
        $kecamatanList = array_unique(array_column($this->model->findAll(), 'kecamatan'));
        sort($kecamatanList);

        return view('sekolah/index', [
            'sekolah'       => $sekolah,
            'kecamatanList' => $kecamatanList,
            'filterKec'     => $kecamatan ?? '',
        ]);
    }

    /** GET /sekolah/detail/{id} — Halaman detail satu SMK */
    public function detail(int $id): string
    {
        $sekolah = $this->model->find($id);

        if (!$sekolah) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("SMK dengan ID $id tidak ditemukan.");
        }

        return view('sekolah/detail', [
            'sekolah' => $sekolah,
        ]);
    }
}
