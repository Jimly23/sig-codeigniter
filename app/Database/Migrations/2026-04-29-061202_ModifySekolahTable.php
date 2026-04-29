<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifySekolahTable extends Migration
{
    public function up()
    {
        // 1. Hapus kolom kepala_sekolah
        if ($this->db->fieldExists('kepala_sekolah', 'sekolah')) {
            $this->forge->dropColumn('sekolah', 'kepala_sekolah');
        }

        // 2. Tambah kolom media_sosial
        if (!$this->db->fieldExists('media_sosial', 'sekolah')) {
            $this->forge->addColumn('sekolah', [
                'media_sosial' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'default'    => null,
                    'after'      => 'website',
                ],
            ]);
        }

        // 3. Insert default admin user jika belum ada
        $db = \Config\Database::connect();
        $existing = $db->table('users')->where('username', 'admin')->countAllResults();
        if ($existing === 0) {
            $db->table('users')->insert([
                'username'      => 'admin',
                'password'      => password_hash('admin123', PASSWORD_DEFAULT),
                'nama_lengkap'  => 'Administrator',
                'role'          => 'superadmin',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);
        }
    }

    public function down()
    {
        // Kembalikan kolom kepala_sekolah
        if (!$this->db->fieldExists('kepala_sekolah', 'sekolah')) {
            $this->forge->addColumn('sekolah', [
                'kepala_sekolah' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => true,
                    'default'    => null,
                    'after'      => 'akreditasi',
                ],
            ]);
        }

        // Hapus kolom media_sosial
        if ($this->db->fieldExists('media_sosial', 'sekolah')) {
            $this->forge->dropColumn('sekolah', 'media_sosial');
        }
    }
}
