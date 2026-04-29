<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    /** GET /login */
    public function loginPage()
    {
        // Jika sudah login, redirect ke dashboard
        if (session()->get('is_admin')) {
            return redirect()->to(base_url('admin/dashboard'));
        }
        return view('auth/login');
    }

    /** POST /login */
    public function loginProcess()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // ─── Autentikasi via database ───
        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'is_admin'      => true,
                'user_id'       => $user['id'],
                'username'      => $user['username'],
                'nama_lengkap'  => $user['nama_lengkap'],
                'role'          => $user['role'],
            ]);
            return redirect()->to(base_url('admin/dashboard'));
        }

        return redirect()->back()
                         ->with('error', 'Username atau password salah.')
                         ->withInput();
    }

    /** GET /logout */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
