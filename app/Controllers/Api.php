<?php

namespace App\Controllers;

use App\Models\SekolahModel;
use CodeIgniter\API\ResponseTrait;

class Api extends BaseController
{
    use ResponseTrait;

    protected SekolahModel $model;

    public function __construct()
    {
        $this->model = new SekolahModel();
    }

    /**
     * GET /api/sekolah
     * Return semua data sekolah dalam format JSON untuk peta.
     */
    public function sekolah()
    {
        $sekolah = $this->model->orderBy('nama', 'ASC')->findAll();

        $data = array_map(function ($s) {
            return [
                'id'             => (int) $s['id'],
                'nama'           => $s['nama'],
                'npsn'           => $s['npsn'],
                'kecamatan'      => $s['kecamatan'],
                'alamat'         => $s['alamat'],
                'akreditasi'     => $s['akreditasi'],
                'kepala_sekolah' => $s['kepala_sekolah'],
                'jurusan'        => $s['jurusan'],
                'no_telp'        => $s['no_telp'],
                'email'          => $s['email'],
                'latitude'       => (float) $s['latitude'],
                'longitude'      => (float) $s['longitude'],
                'foto1'          => $s['foto1'] ? base_url('uploads/sekolah/' . $s['foto1']) : null,
            ];
        }, $sekolah);

        return $this->respond([
            'status' => 'success',
            'total'  => count($data),
            'data'   => $data,
        ]);
    }

    /**
     * POST /api/expand-url
     * Expand shortened URL (like maps.app.goo.gl) to get coordinates.
     */
    public function expandUrl()
    {
        $url = $this->request->getPost('url');
        if (!$url) {
            return $this->fail('URL required');
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
        
        // Some shortened links reject requests without User-Agent
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
        
        curl_exec($ch);
        $expandedUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close($ch);

        return $this->respond([
            'status' => 'success',
            'expanded_url' => $expandedUrl
        ]);
    }
}
