<?php

namespace App\Controllers;

use App\Models\SekolahModel;
use App\Models\UserModel;

class Admin extends BaseController
{
    protected SekolahModel $model;

    protected array $kecamatanList = [
        'Bumiayu', 'Paguyangan', 'Sirampog',
        'Tonjong', 'Bantarkawung', 'Salem',
    ];

    public function __construct()
    {
        $this->model = new SekolahModel();
        // Proteksi: harus login
        if (!session()->get('is_admin')) {
            header('Location: ' . base_url('login'));
            exit;
        }
    }

    // ─── DASHBOARD ──────────────────────────────────────────────
    public function dashboard(): string
    {
        $semua = $this->model->findAll();

        // Hitung per kecamatan dari DB
        $countData = $this->model->countByKecamatan();
        $statsKec  = [];
        foreach ($this->kecamatanList as $kec) {
            $statsKec[$kec] = 0;
        }
        foreach ($countData as $row) {
            $statsKec[$row['kecamatan']] = (int)$row['total'];
        }

        return view('admin/dashboard', [
            'pageTitle'     => 'Dashboard',
            'activePage'    => 'dashboard',
            'kecamatanList' => $this->kecamatanList,
            'statsKec'      => $statsKec,
            'totalSMK'      => count($semua),
        ]);
    }

    // ─── KELOLA DATA SMK ────────────────────────────────────────
    public function sekolah(): string
    {
        $filterKec = $this->request->getGet('kecamatan') ?? '';
        $search    = $this->request->getGet('search') ?? '';

        $sekolah = $this->model->getFiltered($filterKec, $search);

        return view('admin/sekolah/index', [
            'pageTitle'     => 'Kelola Data SMK',
            'activePage'    => 'sekolah',
            'kecamatanList' => $this->kecamatanList,
            'sekolah'       => $sekolah,
            'filterKec'     => $filterKec,
            'search'        => $search,
        ]);
    }

    // ─── FORM TAMBAH ────────────────────────────────────────────
    public function tambah(): string
    {
        return view('admin/sekolah/form', [
            'pageTitle'     => 'Tambah Data SMK',
            'activePage'    => 'tambah',
            'kecamatanList' => $this->kecamatanList,
            'sekolah'       => null,
            'isEdit'        => false,
            'validation'    => \Config\Services::validation(),
        ]);
    }

    // ─── SIMPAN DATA BARU ───────────────────────────────────────
    public function simpan()
    {
        // Validasi input
        $rules = [
            'nama'       => 'required|max_length[150]',
            'npsn'       => 'required|max_length[20]|is_unique[sekolah.npsn]',
            'kecamatan'  => 'required|max_length[50]',
            'alamat'     => 'required',
            'akreditasi' => 'required|in_list[A,B,C,TT]',
            'latitude'   => 'required|decimal',
            'longitude'  => 'required|decimal',
        ];

        $messages = [
            'npsn' => [
                'is_unique' => 'NPSN sudah terdaftar di database.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        // Prepare data
        $data = [
            'nama'           => $this->request->getPost('nama'),
            'npsn'           => $this->request->getPost('npsn'),
            'kecamatan'      => $this->request->getPost('kecamatan'),
            'alamat'         => $this->request->getPost('alamat'),
            'akreditasi'     => $this->request->getPost('akreditasi'),
            'no_telp'        => $this->request->getPost('no_telp'),
            'email'          => $this->request->getPost('email'),
            'website'        => $this->request->getPost('website'),
            'media_sosial'   => $this->request->getPost('media_sosial'),
            'jurusan'        => $this->request->getPost('jurusan'),
            'luas_tanah'     => $this->request->getPost('luas_tanah'),
            'latitude'       => $this->request->getPost('latitude'),
            'longitude'      => $this->request->getPost('longitude'),
        ];

        // Handle foto uploads (foto1 – foto5)
        $fotoFields = ['foto1', 'foto2', 'foto3', 'foto4', 'foto5'];
        foreach ($fotoFields as $field) {
            $file = $this->request->getFile($field);
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/sekolah', $newName);
                $data[$field] = $newName;
            }
        }

        $this->model->insert($data);

        session()->setFlashdata('success', 'Data SMK berhasil ditambahkan.');
        return redirect()->to(base_url('admin/sekolah'));
    }

    // ─── FORM EDIT ──────────────────────────────────────────────
    public function edit(int $id): string
    {
        $sekolah = $this->model->find($id);
        if (!$sekolah) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data SMK ID $id tidak ditemukan.");
        }

        return view('admin/sekolah/form', [
            'pageTitle'     => 'Edit Data SMK',
            'activePage'    => 'sekolah',
            'kecamatanList' => $this->kecamatanList,
            'sekolah'       => $sekolah,
            'isEdit'        => true,
            'validation'    => \Config\Services::validation(),
        ]);
    }

    // ─── UPDATE DATA ────────────────────────────────────────────
    public function update(int $id)
    {
        $sekolah = $this->model->find($id);
        if (!$sekolah) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data SMK ID $id tidak ditemukan.");
        }

        // Validasi input (npsn unique kecuali milik sendiri)
        $rules = [
            'nama'       => 'required|max_length[150]',
            'npsn'       => "required|max_length[20]|is_unique[sekolah.npsn,id,{$id}]",
            'kecamatan'  => 'required|max_length[50]',
            'alamat'     => 'required',
            'akreditasi' => 'required|in_list[A,B,C,TT]',
            'latitude'   => 'required|decimal',
            'longitude'  => 'required|decimal',
        ];

        $messages = [
            'npsn' => [
                'is_unique' => 'NPSN sudah terdaftar di database.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        // Prepare data
        $data = [
            'nama'           => $this->request->getPost('nama'),
            'npsn'           => $this->request->getPost('npsn'),
            'kecamatan'      => $this->request->getPost('kecamatan'),
            'alamat'         => $this->request->getPost('alamat'),
            'akreditasi'     => $this->request->getPost('akreditasi'),
            'no_telp'        => $this->request->getPost('no_telp'),
            'email'          => $this->request->getPost('email'),
            'website'        => $this->request->getPost('website'),
            'media_sosial'   => $this->request->getPost('media_sosial'),
            'jurusan'        => $this->request->getPost('jurusan'),
            'luas_tanah'     => $this->request->getPost('luas_tanah'),
            'latitude'       => $this->request->getPost('latitude'),
            'longitude'      => $this->request->getPost('longitude'),
        ];

        // Handle foto uploads (replace existing if new file uploaded)
        $fotoFields = ['foto1', 'foto2', 'foto3', 'foto4', 'foto5'];
        foreach ($fotoFields as $field) {
            $file = $this->request->getFile($field);
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Hapus foto lama jika ada
                if (!empty($sekolah[$field])) {
                    $oldPath = FCPATH . 'uploads/sekolah/' . $sekolah[$field];
                    if (is_file($oldPath)) {
                        unlink($oldPath);
                    }
                }
                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/sekolah', $newName);
                $data[$field] = $newName;
            }
        }

        $this->model->update($id, $data);

        session()->setFlashdata('success', 'Data SMK berhasil diperbarui.');
        return redirect()->to(base_url('admin/sekolah'));
    }

    // ─── HAPUS DATA ─────────────────────────────────────────────
    public function hapus(int $id)
    {
        $sekolah = $this->model->find($id);
        if (!$sekolah) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data SMK ID $id tidak ditemukan.");
        }

        // Hapus file foto terkait
        $fotoFields = ['foto1', 'foto2', 'foto3', 'foto4', 'foto5'];
        foreach ($fotoFields as $field) {
            if (!empty($sekolah[$field])) {
                $filePath = FCPATH . 'uploads/sekolah/' . $sekolah[$field];
                if (is_file($filePath)) {
                    unlink($filePath);
                }
            }
        }

        $this->model->delete($id);

        session()->setFlashdata('success', 'Data SMK berhasil dihapus.');
        return redirect()->to(base_url('admin/sekolah'));
    }

    // ═══════════════════════════════════════════════════════════
    // ─── KELOLA ADMIN USERS ─────────────────────────────────────
    // ═══════════════════════════════════════════════════════════

    /** GET /admin/users — Daftar semua admin */
    public function users(): string
    {
        $userModel = new UserModel();
        $users = $userModel->orderBy('id', 'ASC')->findAll();

        return view('admin/users/index', [
            'pageTitle'     => 'Kelola Admin',
            'activePage'    => 'users',
            'kecamatanList' => $this->kecamatanList,
            'users'         => $users,
        ]);
    }

    /** GET /admin/users/tambah — Form tambah admin */
    public function tambahUser(): string
    {
        return view('admin/users/form', [
            'pageTitle'     => 'Tambah Admin Baru',
            'activePage'    => 'users',
            'kecamatanList' => $this->kecamatanList,
        ]);
    }

    /** POST /admin/users/simpan — Simpan admin baru */
    public function simpanUser()
    {
        $rules = [
            'username'         => 'required|max_length[50]|is_unique[users.username]',
            'password'         => 'required|min_length[4]',
            'password_confirm' => 'required|matches[password]',
        ];

        $messages = [
            'username' => [
                'is_unique' => 'Username sudah digunakan.',
            ],
            'password_confirm' => [
                'matches' => 'Konfirmasi password tidak cocok.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $userModel->insert([
            'username'      => $this->request->getPost('username'),
            'password'      => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
            'role'          => $this->request->getPost('role') ?? 'admin',
        ]);

        session()->setFlashdata('success', 'Admin baru berhasil ditambahkan.');
        return redirect()->to(base_url('admin/users'));
    }

    /** POST /admin/users/hapus/{id} — Hapus admin */
    public function hapusUser(int $id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("User ID $id tidak ditemukan.");
        }

        // Tidak bisa hapus diri sendiri
        if ($user['username'] === session()->get('username')) {
            session()->setFlashdata('error', 'Tidak dapat menghapus akun yang sedang digunakan.');
            return redirect()->to(base_url('admin/users'));
        }

        $userModel->delete($id);

        session()->setFlashdata('success', 'Admin berhasil dihapus.');
        return redirect()->to(base_url('admin/users'));
    }
}
