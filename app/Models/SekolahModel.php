<?php

namespace App\Models;

use CodeIgniter\Model;

class SekolahModel extends Model
{
    protected $table      = 'sekolah';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $useSoftDeletes = false;
    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';

    protected $allowedFields = [
        'nama', 'npsn', 'kecamatan', 'alamat', 'akreditasi',
        'kepala_sekolah', 'no_telp', 'email', 'website',
        'jurusan', 'luas_tanah',
        'latitude', 'longitude',
        'foto1', 'foto2', 'foto3', 'foto4', 'foto5',
    ];

    // ─── Validation rules ──────────────────────────────────────
    protected $validationRules = [
        'nama'       => 'required|max_length[150]',
        'npsn'       => 'required|max_length[20]',
        'kecamatan'  => 'required|max_length[50]',
        'alamat'     => 'required',
        'akreditasi' => 'required|in_list[A,B,C,TT]',
        'latitude'   => 'required|decimal',
        'longitude'  => 'required|decimal',
    ];

    protected $validationMessages = [
        'nama' => [
            'required'   => 'Nama sekolah wajib diisi.',
            'max_length' => 'Nama sekolah maksimal 150 karakter.',
        ],
        'npsn' => [
            'required'   => 'NPSN wajib diisi.',
            'max_length' => 'NPSN maksimal 20 karakter.',
        ],
        'kecamatan' => [
            'required' => 'Kecamatan wajib dipilih.',
        ],
        'alamat' => [
            'required' => 'Alamat wajib diisi.',
        ],
        'akreditasi' => [
            'required' => 'Akreditasi wajib dipilih.',
            'in_list'  => 'Akreditasi harus A, B, C, atau TT.',
        ],
        'latitude' => [
            'required' => 'Latitude wajib diisi.',
            'decimal'  => 'Latitude harus berupa angka desimal.',
        ],
        'longitude' => [
            'required' => 'Longitude wajib diisi.',
            'decimal'  => 'Longitude harus berupa angka desimal.',
        ],
    ];

    // ─── Query helpers ─────────────────────────────────────────

    /** Get all, optionally filtered by kecamatan and/or search keyword */
    public function getFiltered(string $kecamatan = '', string $search = ''): array
    {
        $builder = $this->builder();

        if ($kecamatan !== '') {
            $builder->where('kecamatan', $kecamatan);
        }

        if ($search !== '') {
            $builder->groupStart()
                    ->like('nama', $search)
                    ->orLike('alamat', $search)
                    ->groupEnd();
        }

        return $builder->orderBy('nama', 'ASC')->get()->getResultArray();
    }

    /** Count per kecamatan */
    public function countByKecamatan(): array
    {
        return $this->select('kecamatan, COUNT(*) as total')
                    ->groupBy('kecamatan')
                    ->findAll();
    }
}
