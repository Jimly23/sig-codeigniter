<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $useSoftDeletes = false;
    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';

    protected $allowedFields = [
        'username', 'password', 'nama_lengkap', 'role',
    ];

    protected $validationRules = [
        'username' => 'required|max_length[50]',
        'password' => 'required|min_length[4]',
    ];

    protected $validationMessages = [
        'username' => [
            'required'   => 'Username wajib diisi.',
            'max_length' => 'Username maksimal 50 karakter.',
        ],
        'password' => [
            'required'   => 'Password wajib diisi.',
            'min_length' => 'Password minimal 4 karakter.',
        ],
    ];
}
